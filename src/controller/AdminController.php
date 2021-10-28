<?php

namespace Projet5\controller;

use Exception;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;
use Projet5\model\UserModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load pending users
		$pendingUsers = $userModel->loadPendingUsers();
		// load invalide posts
		$invalidePosts = $postModel->loadAllPost($valide = self::POST_STATUS_WAITING);
		// load invalide comments
		$invalideComments = $commentModel->loadInvalidComments();
		// load the refused comments
		$refuseComments = $commentModel->loadRefuseComments();

		// display 
		$this->render(
			'admin.twig',
			$_SESSION,
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments
		);
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
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load invalide posts
		$invalidePosts = $postModel->loadAllPost($valide = self::POST_STATUS_WAITING);
		$pendingUsers = [];
		$invalideComments = [];
		$refuseComments = [];

		// display 
		$this->render(
			'admin_waiting_posts.twig',
			$_SESSION,
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments
		);
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
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load pending users
		$pendingUsers = $userModel->loadPendingUsers();
		$invalidePosts = [];
		$invalideComments = [];
		$refuseComments = [];

		// display 
		$this->render(
			'admin_pending_users.twig',
			$_SESSION,
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments
		);
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
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		$invalideComments = $commentModel->loadInvalidComments();
		$pendingUsers = [];
		$invalidePosts = [];
		$refuseComments = [];

		// display 
		$this->render(
			'admin_waiting_comments.twig',
			$_SESSION,
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments
		);
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
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load the refused comments
		$refuseComments = $commentModel->loadRefuseComments();
		$pendingUsers = [];
		$invalidePosts = [];
		$invalideComments = [];

		// display 
		$this->render(
			'admin_refused_comments.twig',
			$_SESSION,
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments
		);
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
		// valide user if form is submit
		if (isset($_POST['idValidateUser'])) {
			$userModel->validateUserWithId($_POST['idValidateUser']);
			$_SESSION['success'] = 'L\'utilisateur a été validé';
			header('location:admin-pending-users');
		}

		// delete user if form is submit
		elseif (isset($_POST['idDeleteUser'])) {
			$userModel->deleteUserWithId($_POST['idDeleteUser']);
			$_SESSION['success'] = 'L\'utilisateur a été supprimé';
			header('location:admin-pending-users');
		}

		// valide post if form is submit
		elseif (isset($_POST['idPublishPost'])) {
			$postModel->publishPostWithId($_POST['idPublishPost']);
			$_SESSION['success'] = 'L\'article a été validé';
			header('location:admin-waiting-posts');
		}

		// delete post if form is submit
		elseif (isset($_POST['idDeletePost'])) {
			$postModel->deletePostWithId($_POST['idDeletePost']);
			$_SESSION['success'] = 'L\'article a été supprimé';
			header('location:admin-waiting-posts');
		}

		// valide comment if form is submit
		elseif (isset($_POST['idPublishComment'])) {
			$commentModel->publishCommentWithId($_POST['idPublishComment']);
			$_SESSION['success'] = 'Le commentaire a été validé';
			header('location:admin-waiting-comments');
		}

		// delete comment if form is submit
		elseif (isset($_POST['idDeleteComment'])) {
			$commentModel->deleteCommentWithId($_POST['idDeleteComment']);
			$_SESSION['success'] = 'Le commentaire a été supprimé';
			header('location:admin-waiting-comments');
		}

		// refuse comment if form is submit
		elseif (isset($_POST['idRefuseComment'])) {
			$commentModel->refuseCommentWithId($_POST['idRefuseComment']);
			$_SESSION['success'] = 'Le commentaire a été refusé';
			header('location:admin-waiting-comments');
		}
	}

	/**
	 * render Template.
	 *
	 * @param string $templateName Template name to render
	 * @param array $error error information to display
	 *
	 * @param array $session user session
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render(
		string $templateName,
		array $errors = [],
		$pendingUsers = [],
		$invalidePosts = [],
		$invalideComments = [],
		$refuseComments = [],
		array $session = []
	) {
		echo $this->twig->render($templateName, [
			'error' => $errors,
			'pendingUsers' => $pendingUsers,
			'invalidePosts' => $invalidePosts,
			'invalideComments' => $invalideComments,
			'refuseComments' => $refuseComments,
			'SESSION' => $_SESSION
		]);
	}
}
