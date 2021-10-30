<?php

namespace Projet5\controller;

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
	 * @param PostModel $postModel
	 * @param int $currentPage contains the page number
	 *
	 * @return array  contains post data 
	 */
	public function displayPosts(PostModel $postModel, int $currentPage)
	{
		// count number of row valide
		$countPosts = $postModel->countAllPost($valide = self::VALUE_POST_VALID);
		$numberPosts = $countPosts->rowCount();
		// take Limits for request SQL
		$paging = $this->paging(Router::POST_PER_PAGE, $numberPosts, $currentPage);

		$posts = $postModel->loadAllPost($valide, $paging['startLimit'], Router::POST_PER_PAGE);

		echo $this->twig->render('blog_posts.twig', [
			'SESSION' => $_SESSION,
			'posts' => $posts,
			'paging' => $paging
		]);
	}

	/**
	 * Displays a post
	 *
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 * @param string $idPost contains post id
	 * @param int $currentPage contains the page number
	 *
	 * @return array contains post data
	 */
	public function displayPost(PostModel $postModel, CommentModel $commentModel, string $idPost, int $currentPage)
	{
		// load the post
		$post = $postModel->loadPost($idPost);


		// if post not valide display a error message
		if ($post['publish'] == self::POST_STATUS_WAITING) {
			$_SESSION['error'] = 'L\'article est en attente de validation par un administrateur';
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
		echo $this->twig->render('post.twig', [
			'SESSION' => $_SESSION,
			'post' => $post,
			'comments' => $comments,
			'paging' => $paging
		]);
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
}
