<?php

namespace Projet5\controller;

use Exception;
use Projet5\controller\Constraints;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;

/**
 * display of posts and pagination management 
 */
class FrontPostController extends Constraints
{
	/**
	 * Displays the list of posts 
	 *
	 * @param object $postModel
	 * @param int $currentPage contains the page number
	 *
	 * @return array  contains post data 
	 */
	public function displayPosts(object $postModel, int $currentPage)
	{
		try {
			// count number of row valide
			$countPosts = $postModel->countAllPost($valide = self::VALUE_POST_VALID);
			$numberPosts = $countPosts->rowCount();
			// take Limits for request SQL
			$paging = $this->paging(Router::POST_PER_PAGE, $numberPosts, $currentPage);

			$posts = $postModel->loadAllPost($valide, $paging['startLimit'], Router::POST_PER_PAGE);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
			return;
		}

		$this->render('blog_posts.twig', $_SESSION, $paging, [], $posts, []);
	}

	/**
	 * Displays a post
	 *
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 * @param string $idPost contains post id
	 *
	 * @return array contains post data
	 */
	public function displayPost(PostModel $postModel, CommentModel $commentModel, string $idPost)
	{
		try {
			// load the post
			$post = $postModel->loadPost($idPost);
			// load comments for this post
			$comments = $commentModel->loadAllCommentsWithIdPost($idPost);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
			return;
		}


		// if the post does not exist display an error message 		
		// if ($postModel->loadPost($idPost) == false) {
		// 	$this->render('error_404.twig', $_SESSION, []);
		// 	return;
		// }

		// if the post is waiting display an error message
		if ($post->getPublish() === self::POST_STATUS_WAITING) {
			$_SESSION['error'] = 'Cet article est en attente de validation';
			header('location:Articles-Page1');
			exit;
		}

		// display post and comments 
		$this->render('post.twig', $_SESSION, [], $post, [], $comments);
	}

	/**
	 * Function returning an array with the $currentPage and the $totalPages.
	 *
	 * @param int $numberPerPage contains the maximum number of posts or comments per page 
	 * @param int $numberRow contains the total number of posts or comments
	 * @param int $currentPage contains the current page
	 *
	 * @return array
	 */
	private function paging(int $numberPerPage, int $numberRow, int $currentPage = 1)
	{
		// calcul total pages
		$totalPages = ceil($numberRow / $numberPerPage);
		// calcul startlimit for request SQL
		$startLimit = intval(($currentPage - 1) * $numberPerPage);

		return $paging = [
			'startLimit' => $startLimit,
			'currentPage' => $currentPage,
			'totalPages' => $totalPages
		];
	}

	/**
	 * render Template
	 *
	 * @param string $templateName Template name to render
	 * @param array $session user session
	 * @param array $paging contains the data of the number of pages 
	 * @param object $post contains post data
	 * @param object $posts contains posts data 
	 * @param object $comments contains comment data
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render(string $templateName, array $session, array $paging, $post = [], $posts = [], $comments = [])
	{
		echo $this->twig->render($templateName, ['SESSION' => $session, 'paging' => $paging, 'post' => $post, 'posts' => $posts, 'comments' => $comments]);
	}
}
