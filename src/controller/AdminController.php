<?php

namespace Projet5\controller;

use Exception;

/**
 * management of validations by admin 
 */
class AdminController extends SessionController
{
	/**
	 * retrieve information awaiting validation by admin 
	 *
	 * @param object $userModel
	 * @param object $postModel
	 * @param object $commentModel
	 *
	 * @return array
	 */
	public function display(object $userModel, object $postModel, object $commentModel)
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
	 * Allows the validation or deletion of elements awaiting validation 
	 *
	 * @param object $userModel
	 * @param object $postModel
	 * @param object $commentModel
	 *
	 * @return array
	 */
	private function controleForms(object $userModel, object $postModel, object $commentModel)
	{
		try {
			// valide user if form is submit
			if (isset($_POST['idValidateUser'])) {
				$userModel->validateUserWithId($_POST['idValidateUser']);
				throw new Exception($_SESSION['success'] = 'L\'utilisateur a été validé');
			}

			// delete user if form is submit
			if (isset($_POST['idDeleteUser'])) {
				$userModel->deleteUserWithId($_POST['idDeleteUser']);
				throw new Exception($_SESSION['success'] = 'L\'utilisateur a été supprimé');
			}

			// valide post if form is submit
			if (isset($_POST['idPublishPost'])) {
				$postModel->publishPostWithId($_POST['idPublishPost']);
				throw new Exception($_SESSION['success'] = 'L\'article a été validé');
			}

			// delete post if form is submit
			if (isset($_POST['idDeletePost'])) {
				$postModel->deletePostWithId($_POST['idDeletePost']);
				throw new Exception($_SESSION['success'] = 'L\'article a été supprimé');
			}

			// valide comment if form is submit
			if (isset($_POST['idPublishComment'])) {
				$commentModel->publishCommentWithId($_POST['idPublishComment']);
				throw new Exception($_SESSION['success'] = 'Le commentaire a été validé');
			}

			// delete comment if form is submit
			if (isset($_POST['idDeleteComment'])) {
				$commentModel->deleteCommentWithId($_POST['idDeleteComment']);
				throw new Exception($_SESSION['success'] = 'Le commentaire a été supprimé');
			}

			// refuse comment if form is submit
			if (isset($_POST['idRefuseComment'])) {
				$commentModel->refuseCommentWithId($_POST['idRefuseComment']);
				throw new Exception($_SESSION['success'] = 'Le commentaire a été refusé');
			}
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
