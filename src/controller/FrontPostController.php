<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * display of posts and pagination management 
 */
class FrontPostController extends TwigController
{
	/**
	 * Displays the list of posts 
	 *
	 * @param object $postModel
	 * @param int $currentPage contains the page number
	 *
	 * @return array
	 */
	public function displayPosts(object $postModel, int $currentPage)
	{
		// count number of row valide
		$valide = 'valid';
		$countPosts = $postModel->countAllPost($valide);
		$numberPosts = $countPosts->rowCount();
		// take Limits for request SQL
		$paging = $this->paging(POST_PER_PAGE, $numberPosts, $currentPage);

		$posts = $postModel->loadAllPost($valide, $paging['startLimit'], POST_PER_PAGE);

		echo $this->twig->render('blog_posts.twig', [
			'SESSION' => $_SESSION,
			'posts' => $posts,
			'paging' => $paging
		]);
	}

	/**
	 * Displays a post
	 *
	 * @param object $postModel
	 * @param object $commentModel
	 * @param string $idPost contains post id
	 * @param int $currentPage contains the page number
	 *
	 * @return array
	 */
	public function displayPost(object $postModel, object $commentModel, string $idPost, int $currentPage)
	{
		// load the post
		$post = $postModel->loadPost($idPost);


		// if post not valide display a error message
		if ($post['publish'] == 'waiting') {
			$_SESSION['error'] = 'L\'article est en attente de validation par un administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// load comments for this post
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost);
		// count number of row
		$numberComments = $comments->rowCount();
		// take Limits for request SQL
		$paging = $this->paging(COMMENT_PER_PAGE, $numberComments, $currentPage);
		// load comments with limit
		$comments = $commentModel->loadAllCommentsWithIdPost($idPost, $paging['startLimit'], COMMENT_PER_PAGE);
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
