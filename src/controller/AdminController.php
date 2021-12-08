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
	 */
	public function displayAllElements(UserModel $userModel, PostModel $postModel, CommentModel $commentModel)
	{
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('error_404.twig', $_SESSION);
			return;
		}

		try {
			// controle if a POST variable exist and execute
			$this->controleForms($userModel, $postModel, $commentModel);

			// load pending users
			$pendingUsers = $userModel->loadPendingUsers();
			// load invalid posts        
			$invalidPosts = $postModel->loadAllPost($valid = self::POST_STATUS_WAITING);
			// load invalid comments        
			$invalidComments = $commentModel->loadInvalidComments();
			// load the refused comments        
			$refuseComments = $commentModel->loadRefuseComments();

			// display 
			$this->render(
				'admin.twig',
				$_SESSION,
				[],
				$pendingUsers,
				$invalidPosts,
				$invalidComments,
				$refuseComments
			);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
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
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('error_404.twig', $_SESSION);
			return;
		}

		try {
			// controle if a POST variable exist and execute
			$this->controleForms($userModel, $postModel, $commentModel);

			// load invalid posts
			$invalidPosts = $postModel->loadAllPost($valid = self::POST_STATUS_WAITING);

			// display 
			$this->render('admin_waiting_posts.twig', $_SESSION, [], [], $invalidPosts, [], []);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
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
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('error_404.twig', $_SESSION);
			return;
		}

		try {
			// controle if a POST variable exist and execute
			$this->controleForms($userModel, $postModel, $commentModel);

			// load pending users
			$pendingUsers = $userModel->loadPendingUsers();

			// display 
			$this->render('admin_pending_users.twig', $_SESSION, [], $pendingUsers, [], [], []);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
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
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('error_404.twig', $_SESSION);
			return;
		}

		try {
			// controle if a POST variable exist and execute
			$this->controleForms($userModel, $postModel, $commentModel);

			// load invalid comments
			$invalidComments = $commentModel->loadInvalidComments();

			// display 
			$this->render('admin_waiting_comments.twig', $_SESSION, [], [], [], $invalidComments, []);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
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
		// If I do not follow admin, return to the home page
		if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
			$this->render('error_404.twig', $_SESSION);
			return;
		}

		try {
			// controle if a POST variable exist and execute
			$this->controleForms($userModel, $postModel, $commentModel);

			// load the refused comments
			$refuseComments = $commentModel->loadRefuseComments();

			// display 
			$this->render('admin_refused_comments.twig', $_SESSION, [], [], [], [], $refuseComments);
		} catch (Exception $e) {
			$this->render('error_500.twig', $_SESSION, []);
		}
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
				// valid user if form is submit
			case (isset($_POST['idValidateUser'])): {
					$userModel->validateUserWithId($_POST['idValidateUser']);
					$_SESSION['success'] = self::USER . self::VALID;
					break;
				}

				// delete user if form is submit
			case (isset($_POST['idDeleteUser'])): {
					$userModel->deleteUserWithId($_POST['idDeleteUser']);
					$_SESSION['success'] = self::USER . self::SUPPR;
					break;
				}

				// valid post if form is submit
			case (isset($_POST['idPublishPost'])): {
					$postModel->publishPostWithId($_POST['idPublishPost']);
					$_SESSION['success'] = self::POST . self::VALID;
					break;
				}

				// delete post if form is submit
			case (isset($_POST['idDeletePost'])): {
					$postModel->deletePostWithId($_POST['idDeletePost']);
					$_SESSION['success'] = self::POST . self::SUPPR;
					break;
				}

				// valid comment if form is submit
			case (isset($_POST['idPublishComment'])): {
					$commentModel->publishCommentWithId($_POST['idPublishComment']);
					$_SESSION['success'] = self::COMM . self::VALID;
					break;
				}

				// delete comment if form is submit
			case (isset($_POST['idDeleteComment'])): {
					$commentModel->deleteCommentWithId($_POST['idDeleteComment']);
					$_SESSION['success'] = self::COMM . self::SUPPR;
					break;
				}

				// refuse comment if form is submit
			case (isset($_POST['idRefuseComment'])): {
					$commentModel->refuseCommentWithId($_POST['idRefuseComment']);
					$_SESSION['success'] = self::COMM . self::REFU;
					break;
				}
		}
	}

	/**
	 * render Template.
	 *
	 * @param string $templateName Template name to render
	 * @param array $session user session
	 * @param array $error error information to display
	 * @param object $pendingUsers return pending user
	 * @param object $invalidPosts return pending post
	 * @param object $invalidComments return invalid comment 
	 * @param object $refuseComments return comment refused 
	 * 
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render(
		string $templateName,
		array $session,
		array $errors = [],
		$pendingUsers = [],
		$invalidPosts = [],
		$invalidComments = [],
		$refuseComments = []
	) {
		echo $this->twig->render($templateName, [
			'SESSION' => $session,
			'error' => $errors,
			'pendingUsers' => $pendingUsers,
			'invalidPosts' => $invalidPosts,
			'invalidComments' => $invalidComments,
			'refuseComments' => $refuseComments
		]);
	}
}
