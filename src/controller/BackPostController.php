<?php

namespace Projet5\controller;

use Projet5\model\PostModel;

/**
 * Manage postings, updates and deletions
 */
class BackPostController extends SessionController
{
	/**
	 * adding a new post
	 *
	 * @param PostModel $postModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function addPost(PostModel $postModel)
	{
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('homepage.twig', $_SESSION);
			return;
		}

		// The form is not submitted, posting the post form
		if (count($_POST) === 0) {
			$this->render('insert_post.twig', $_SESSION);
			return;
		}

		// The form is submitted, control
		$title = (isset($_POST['title'])) ? $_POST['title'] : "";
		$chapo = (isset($_POST['chapo'])) ? $_POST['chapo'] : "";
		$contents = (isset($_POST['contents'])) ? $_POST['contents'] : "";
		$id_user = (isset($_SESSION['IdConnectedUser'])) ? $_SESSION['IdConnectedUser'] : "";
		$errors = [];

		// Constraints
		$this->checkTitle($title, $errors);

		$this->checkChapo($chapo, $errors);

		$this->checkContents($contents, $errors);

		// insert post if control ok
		if (empty($errors)) {
			$postModel->insertPost([
				'title' => $title,
				'chapo' => $chapo,
				'contents' => $contents,
				'id_user' => $id_user
			]);

			$_SESSION['success'] = self::MESSAGE_VALID_OK . ' envoyé, il est maintenant en attente de validation par un administrateur';
			header('location:admin-waiting-posts');
			exit;
		}

		// form information in a table for simplicity with twig
		$form = [
			'title' => $title,
			'chapo' => $chapo,
			'contents' => $contents,
			'id_user' => $id_user
		];

		// display the form with errors and datas form
		$this->render('insert_post.twig', $_SESSION, $errors, $form);
	}

	/**
	 * modification of a post
	 *
	 * @param string $idPost contains post id
	 * @param PostModel $postModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function editPost(string $idPost, PostModel $postModel)
	{
		// load Post with id
		$post = $postModel->loadPost($idPost);

		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('homepage.twig', $_SESSION);
			return;
		}

		// The form is not submitted, posting the post form
		if (count($_POST) === 0) {
			$this->render('insert_post.twig', $_SESSION, [], [], $post);
			return;
		}

		// The form is submitted, control
		$title = (isset($_POST['title'])) ? $_POST['title'] : "";
		$chapo = (isset($_POST['chapo'])) ? $_POST['chapo'] : "";
		$contents = (isset($_POST['contents'])) ? $_POST['contents'] : "";
		$errors = [];

		// Constraints
		$this->checkTitle($title, $errors);

		$this->checkChapo($chapo, $errors);

		$this->checkContents($contents, $errors);

		// if no error, update the post
		if (empty($errors)) {
			$postModel->updatePost($idPost, [
				'title' => $title,
				'chapo' => $chapo,
				'contents' => $contents
			]);
			$_SESSION['success'] = self::MESSAGE_VALID_OK . ' mis à jour';
			header('location:Article-page1');
			exit;
		}

		// form information in a table for simplicity with twig
		$form = [
			'title' => $title,
			'chapo' => $chapo,
			'contents' => $contents,
			'id_post' => $idPost
		];

		// display the post with error and datas form
		$this->render('insert_post.twig', $_SESSION, $errors, $form);
	}

	/**
	 * delete a post
	 *
	 * @param string $idPost contains post id
	 * @param PostModel $postModel
	 * 
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function deletePost(string $idPost, PostModel $postModel)
	{
		// load Post with id
		$post = $postModel->loadPost($idPost);

		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('homepage.twig', $_SESSION);
			return;
		}

		// Not delete post if form is cancel and redirect
		if (isset($_POST['cancel'])) {
			header('location:Article-page1');
			exit;
		}

		// delete post if form is submit and redirect
		if (isset($_POST['idDeletePost'])) {
			$postModel->deletePostWithId($_POST['idDeletePost']);
			$_SESSION['success'] = self::MESSAGE_VALID_OK . ' supprimé';
			header('location:Articles-Page1');
			exit;
		}

		// display the confirm delete message
		$this->render('delete_post.twig', $_SESSION, [], [], $post);
	}

	/**
	 * render Template.
	 *
	 * @param string $templateName Template name to render
	 * @param array $session user session
	 * @param array $error error information to display
	 * @param array $form content of the completed form
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render(string $templateName, array $session, array $errors = [], array $form = [], array $post = [])
	{
		echo $this->twig->render($templateName, ['SESSION' => $session, 'error' => $errors, 'form' => $form, 'post' => $post]);
	}
}
