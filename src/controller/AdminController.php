<?php

namespace Projet5\controller;

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
			[],
			$pendingUsers,
			$invalidePosts,
			$invalideComments,
			$refuseComments,
			$_SESSION
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
	 */
	public function displayWaitingPosts(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load invalide posts
		$invalidePosts = $postModel->loadAllPost($valide = self::POST_STATUS_WAITING);

		// display 
		$this->render('admin_waiting_posts.twig', [], [], $invalidePosts, [], [], $_SESSION);
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
	 */
	public function displayPendingUsers(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load pending users
		$pendingUsers = $userModel->loadPendingUsers();

		// display 
		$this->render('admin_pending_users.twig', [], $pendingUsers, [], [], [], $_SESSION);
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
	 */
	public function displayInvalidComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load invalide comments
		$invalideComments = $commentModel->loadInvalidComments();

		// display 
		$this->render('admin_waiting_comments.twig', [], [], [], $invalideComments, [], $_SESSION);
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
	 */
	public function displayRefusedComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the article page
		$this->redirectNoAdmin();

		// controle if a POST variable exist and execute
		$this->controleForms($userModel, $postModel, $commentModel);

		// load the refused comments
		$refuseComments = $commentModel->loadRefuseComments();

		// display 
		$this->render('admin_refused_comments.twig', [], [], [], [], $refuseComments, $_SESSION);
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
	 */
	private function controleForms(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		switch (true) {
				// valide user if form is submit
			case (isset($_POST['idValidateUser'])): {
					$userModel->validateUserWithId($_POST['idValidateUser']);
					$_SESSION['success'] = self::USER . self::VALID;
					header('location:admin-pending-users');
				}

				// delete user if form is submit
			case (isset($_POST['idDeleteUser'])): {
					$userModel->deleteUserWithId($_POST['idDeleteUser']);
					$_SESSION['success'] = self::USER . self::SUPPR;
					header('location:admin-pending-users');
				}

				// valide post if form is submit
			case (isset($_POST['idPublishPost'])): {
					$postModel->publishPostWithId($_POST['idPublishPost']);
					$_SESSION['success'] = self::POST . self::VALID;
					header('location:admin-waiting-posts');
				}

				// delete post if form is submit
			case (isset($_POST['idDeletePost'])): {
					$postModel->deletePostWithId($_POST['idDeletePost']);
					$_SESSION['success'] = self::POST . self::SUPPR;
					header('location:admin-waiting-posts');
				}

				// valide comment if form is submit
			case (isset($_POST['idPublishComment'])): {
					$commentModel->publishCommentWithId($_POST['idPublishComment']);
					$_SESSION['success'] = self::COMM . self::VALID;
					header('location:admin-waiting-comments');
				}

				// delete comment if form is submit
			case (isset($_POST['idDeleteComment'])): {
					$commentModel->deleteCommentWithId($_POST['idDeleteComment']);
					$_SESSION['success'] = self::COMM . self::SUPPR;
					header('location:admin-waiting-comments');
				}

				// refuse comment if form is submit
			case (isset($_POST['idRefuseComment'])): {
					$commentModel->refuseCommentWithId($_POST['idRefuseComment']);
					$_SESSION['success'] = self::COMM . self::REFU;
					header('location:admin-waiting-comments');
				}
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
			'SESSION' => $session
		]);
	}
}
