<?php

namespace Projet5\controller;

use Projet5\controller\Constraints;
use Projet5\model\PostModel;

/**
 * display of posts and pagination management 
 */
class FrontPostController extends Constraints
{
	/**
	 * Displays the list of posts 
	 *
	 * @param $postModel
	 * @param int $currentPage contains the page number
	 *
	 * @return array  contains post data 
	 */
	public function displayPosts($postModel, int $currentPage)
	{
		// count number of row valide
		$countPosts = $postModel->countAllPost($valide = self::VALUE_POST_VALID);
		$numberPosts = $countPosts->rowCount();
		// take Limits for request SQL
		$paging = $this->paging(Router::POST_PER_PAGE, $numberPosts, $currentPage);

		$posts = $postModel->loadAllPost($valide, $paging['startLimit'], Router::POST_PER_PAGE);

		$this->render('blog_posts.twig', $_SESSION, [], $posts, [], $paging);
	}

	/**
	 * Displays a post
	 *
	 * @param PostModel $postModel
	 * @param $commentModel
	 * @param string $idPost contains post id
	 * @param int $currentPage contains the page number
	 *
	 * @return array contains post data
	 */
	public function displayPost(PostModel $postModel, $commentModel, string $idPost, int $currentPage)
	{
		// load the post
		$post = $postModel->loadPost($idPost);

		// if post not valide display a error message
		if ($post['publish'] == self::POST_STATUS_WAITING) {
			$_SESSION['error'] = 'L\'article est en attente de validation';
			header('location:Articles-Page1');
			exit;
		}

		// load comments for this post
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost);
		// count number of row
		$numberComments = $comments->rowCount();
		// take Limits for request SQL
		$paging = $this->paging(Router::COMMENT_PER_PAGE, $numberComments, $currentPage);
		// load comments with limit
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost, $paging['startLimit'], Router::COMMENT_PER_PAGE);
		// display post and comments 
		$this->render('post.twig', $_SESSION, $post, [], $comments, $paging);
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
	 * @param $templateName Template name to render
	 * @param array $session user session
	 * @param $post contains post data
	 * @param $posts contains posts data 
	 * @param $comments contains comment data
	 * @param array $paging contains the data of the number of pages 
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render($templateName, array $session, $post = [], $posts = [], $comments = [], array $paging)
	{
		echo $this->twig->render($templateName, ['SESSION' => $session, 'post' => $post, 'posts' => $posts, 'comments' => $comments, 'paging' => $paging]);
	}
}
