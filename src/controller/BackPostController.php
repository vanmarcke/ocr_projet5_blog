<?php

namespace Projet5\controller;

/**
 * Manage postings, updates and deletions
 */
class BackPostController extends SessionController
{
	/**
	 * adding a new post
	 *
	 * @param object $postModel
	 *
	 * @return array
	 */
	public function addPost(object $postModel)
	{
		// The form is not submitted, posting the post form
		if (count($_POST) === 0) {
			echo $this->twig->render('insert_post.twig', ['SESSION' => $_SESSION, 'add' => 'add']);
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

			$_SESSION['success'] = 'L\'article à bien été envoyé, il est maintenant en attente de validation par un administrateur';
			header('location:Administration');
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
		$this->render('insert_post.twig', $errors, $form, $_SESSION, ['add' => 'add']);
	}

	/**
	 * modification of a post
	 *
	 * @param string $idPost contains post id
	 * @param object $postModel
	 *
	 * @return array
	 */
	public function editPost(string $idPost, object $postModel)
	{
		// load Post with id
		$post = $postModel->loadPost($idPost);

		// if the user wants to modify an article
		if ($post['pseudo'] !== $_SESSION['pseudoConnectedUser']) {
			$_SESSION['error'] = 'Vous n\'avez pas les droits pour modifier cet article';
			header('location:Articles-Page1');
			exit;
		}
		// The form is not submitted, posting the post form
		if (count($_POST) === 0) {
			echo $this->twig->render('insert_post.twig', ['SESSION' => $_SESSION, 'post' => $post, 'edit' => 'edit']);
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
			$_SESSION['success'] = 'L\'article à été mis à jour';
			header('location:Article-' . $post['id'] . '-page1');
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
		// echo $this->twig->render('insert_post.twig', ['error' => $error, 'SESSION' => $_SESSION, 'form' => $form, 'edit' => 'edit']);
		$this->render('insert_post.twig', $errors, $form, $_SESSION, ['edit' => 'edit']);
	}

	/**
	 * delete a post
	 *
	 * @param string $idPost contains post id
	 * @param object $postModel
	 */
	public function deletePost(string $idPost, object $postModel)
	{
		// load Post with id
		$post = $postModel->loadPost($idPost);

		// if the user wants to delete an article
		if ($post['pseudo'] !== $_SESSION['pseudoConnectedUser']) {
			$_SESSION['error'] = 'Vous n\'avez pas les droits pour supprimer cet article';
			header('location:Articles-Page1');
			exit;
		}

		// Not delete post if form is cancel and redirect
		if (isset($_POST['cancel'])) {
			header('location:Article-page1');
			exit;
		}

		// delete post if form is submit and redirect
		if (isset($_POST['idDeletePost'])) {
			$postModel->deletePostWithId($_POST['idDeletePost']);
			$_SESSION['success'] = 'L\'article à été supprimé';
			header('location:Articles-Page1');
			exit;
		}

		// display the confirm delete message
		echo $this->twig->render('delete_post.twig', ['SESSION' => $_SESSION, 'post' => $post]);
	}

	/**
     * render Template.
     *
     * @param string $templateName Template name to render
     * @param array $error error information to display
     * @param array $form content of the completed form
     * @param array $session user session
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function render(string $templateName, array $errors = [], array $form = [], array $session = [])
    {
        echo $this->twig->render($templateName, ['error' => $errors, 'form' => $form, 'SESSION' => $_SESSION, 'add' => 'add', 'edit' => 'edit']);
    }
}
