<?php

namespace Projet5\controller;

use Exception;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;
use Projet5\model\UserModel;

/**
 * management of validations by admin 
 */
class AdminController extends SessionController
{
	/**
	 * retrieve information awaiting validation by admin 
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function displayAllElements(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load pending users
		$pendingUsers = $userModel->loadPendingUsers();
		// load invalide posts
		$invalidePosts = $postModel->loadAllPost($valide = 'waiting');
		// load invalide comments
		$invalideComments = $commentModel->loadInvalidComments();
		// load the refused comments
		$refuseComments = $commentModel->loadRefuseComments();

		// display 
		echo $this->twig->render('admin.twig', [
			'SESSION' => $_SESSION,
			'pendingUsers' => $pendingUsers,
			'invalidePosts' => $invalidePosts,
			'invalideComments' => $invalideComments,
			'refuseComments' => $refuseComments
		]);
	}

	/**
	 * retrieve posts pending administrator validation 
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function displayWaitingPosts(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load invalide posts
		$invalidePosts = $postModel->loadAllPost($valide = 'waiting');

		// display 
		echo $this->twig->render('admin_waiting_posts.twig', [
			'SESSION' => $_SESSION,
			'invalidePosts' => $invalidePosts
		]);
	}

	/**
	 * retrieve users awaiting validation by the admin
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function displayPendingUsers(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load pending users
		$pendingUsers = $userModel->loadPendingUsers();

		// display 
		echo $this->twig->render('admin_pending_users.twig', [
			'SESSION' => $_SESSION,
			'pendingUsers' => $pendingUsers
		]);
	}

	/**
	 * retrieve information awaiting validation by admin 
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function displayInvalidComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		$invalideComments = $commentModel->loadInvalidComments();

		// display 
		echo $this->twig->render('admin_waiting_comments.twig', [
			'SESSION' => $_SESSION,
			'invalideComments' => $invalideComments
		]);
	}

	/**
	 * retrieve information awaiting validation by admin 
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	public function displayRefusedComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load the refused comments
		$refuseComments = $commentModel->loadRefuseComments();

		// display 
		echo $this->twig->render('admin_refused_comments.twig', [
			'SESSION' => $_SESSION,
			'refuseComments' => $refuseComments
		]);
	}

	/**
	 * Allows the validation or deletion of elements awaiting validation 
	 *
	 * @param UserModel $userModel
	 * @param PostModel $postModel
	 * @param CommentModel $commentModel
	 *
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 * @throws Exception
	 */
	private function controleForms(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		try {
			// valide user if form is submit
			if (isset($_POST['idValidateUser'])) {
				$userModel->validateUserWithId($_POST['idValidateUser']);
				new Exception($_SESSION['success'] = 'L\'utilisateur a été validé');
				header('location:admin-pending-users');
				exit;
			}

			// delete user if form is submit
			if (isset($_POST['idDeleteUser'])) {
				$userModel->deleteUserWithId($_POST['idDeleteUser']);
				new Exception($_SESSION['success'] = 'L\'utilisateur a été supprimé');
				header('location:admin-pending-users');
				exit;
			}

			// valide post if form is submit
			if (isset($_POST['idPublishPost'])) {
				$postModel->publishPostWithId($_POST['idPublishPost']);
				new Exception($_SESSION['success'] = 'L\'article a été validé');
				header('location:admin-waiting-posts');
				exit;
			}

			// delete post if form is submit
			if (isset($_POST['idDeletePost'])) {
				$postModel->deletePostWithId($_POST['idDeletePost']);
				new Exception($_SESSION['success'] = 'L\'article a été supprimé');
				header('location:admin-waiting-posts');
				exit;
			}

			// valide comment if form is submit
			if (isset($_POST['idPublishComment'])) {
				$commentModel->publishCommentWithId($_POST['idPublishComment']);
				new Exception($_SESSION['success'] = 'Le commentaire a été validé');
				header('location:admin-waiting-comments');
				exit;
			}

			// delete comment if form is submit
			if (isset($_POST['idDeleteComment'])) {
				$commentModel->deleteCommentWithId($_POST['idDeleteComment']);
				new Exception($_SESSION['success'] = 'Le commentaire a été supprimé');
				header('location:admin-waiting-comments');
				exit;
			}

			// refuse comment if form is submit
			if (isset($_POST['idRefuseComment'])) {
				$commentModel->refuseCommentWithId($_POST['idRefuseComment']);
				new Exception($_SESSION['success'] = 'Le commentaire a été refusé');
				header('location:admin-waiting-comments');
				exit;
			}
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
