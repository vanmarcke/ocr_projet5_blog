<?php

namespace Projet5\controller;

use Exception;
use Projet5\controller\Constraints;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;

/**
 * Display of posts and pagination management 
 */
class FrontPostController extends Constraints
{
	/**
	 * Displays the list of posts 
	 *
	 * @param PostModel $postModel   Read, insert, update and delete of posts
	 * @param int       $currentPage Contains the page number
	 *
	 * @return array
	 */
	public function displayPosts(PostModel $postModel, int $currentPage)
	{
		try {
			// Count number of row valid
			$numberPosts = $postModel->countAllPost($valid = self::VALUE_POST_VALID);
			// Take Limits for request SQL
			$paging = $this->paging(Router::POST_PER_PAGE, $numberPosts, $currentPage);

			$posts = $postModel->loadAllPost($valid, $paging['startLimit'], Router::POST_PER_PAGE);
			// Display posts
			$this->render('blog_posts.twig', $_SESSION, $paging, [], $posts, []);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
	}

	/**
	 * Displays a post
	 *
	 * @param PostModel    $postModel    Read, insert, update and delete of posts
	 * @param CommentModel $commentModel Read, insert, update and delete comments
	 * @param string       $idPost       Contains post id
	 *
	 * @return array
	 */
	public function displayPost(PostModel $postModel, CommentModel $commentModel, string $idPost)
	{
		try {
			// Load the post
			$post = $postModel->loadPost($idPost);
			// load comments for this post
			$comments = $commentModel->loadAllCommentsWithIdPost($idPost);

			// // if the post does not exist display an error message 		
			// if ($postModel->loadPost($idPost) == false) {
			// 	$this->render('error_404.twig', $_SESSION, []);
			// 	return;
			// }

			// If the post is waiting display an error message
			if ($post->getPublish() === self::POST_STATUS_WAITING) {
				$_SESSION['error'] = 'Cet article est en attente de validation';
				header('location:Articles-Page1');
				exit;
			}
			// Display post and comments
			$this->render('post.twig', $_SESSION, [], $post, [], $comments);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
	}

	/**
	 * Function returning an array with the $currentPage and the $totalPages.
	 *
	 * @param int $numberPerPage Contains the maximum number of posts or comments per page 
	 * @param int $numberRow     Contains the total number of posts or comments
	 * @param int $currentPage   Contains the current page
	 *
	 * @return array
	 */
	private function paging(int $numberPerPage, int $numberRow, int $currentPage = 1)
	{
		// Calcul total pages
		$totalPages = ceil($numberRow / $numberPerPage);

		// Calcul startlimit for request SQL
		$startLimit = intval(($currentPage - 1) * $numberPerPage);
		
		// Redirection if the page does not exist
		if ($currentPage > $totalPages) {
			$_SESSION['error'] = 'Cette page n\'existe pas !!!';
			header('location:Articles-Page1');
			exit;
		}

		return $paging = [
			'startLimit' => $startLimit,
			'currentPage' => $currentPage,
			'totalPages' => $totalPages
		];
	}

	/**
	 * Render Template
	 *
	 * @param string $templateName Template name to render
	 * @param array  $session      User session
	 * @param array  $paging       Contains the data of the number of pages 
	 * @param array  $post         Contains post data
	 * @param array  $posts        Contains posts data 
	 * @param array  $comments     Contains comment data
	 * 
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * 
	 * @return void
	 */
	private function render(string $templateName, array $session, array $paging, $post = [], array $posts = [], array $comments = [])
	{
		echo $this->twig->render($templateName, ['SESSION' => $session, 'paging' => $paging, 'post' => $post, 'posts' => $posts, 'comments' => $comments]);
	}
}
