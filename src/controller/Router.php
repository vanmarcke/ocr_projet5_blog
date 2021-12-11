<?php

namespace Projet5\controller;

use Projet5\controller\HomepageController;
use Projet5\controller\UserController;
use Projet5\controller\FrontPostController;
use Projet5\controller\AdminController;
use Projet5\controller\BackPostController;
use Projet5\controller\CommentController;

use Projet5\model\UserModel;
use Projet5\model\PostModel;
use Projet5\model\CommentModel;


/**
 * Defined the different routes to the controllers 
 */
class Router
{
	// Set the number of pages for post views
	const POST_PER_PAGE = 4;

	/**
	 * Execute the route to home page 
	 *
	 * @return array
	 */
	public function run()
	{
		// Models variables
		$userModel = new UserModel();
		$postModel = new PostModel();
		$commentModel = new CommentModel();

		// ROUTER
		$url = '';
		if (isset($_GET['url'])) {
			$url = explode('/', strtolower($_GET['url']));
		}
		switch (true) {
				// Home
			case ($url == '' || $url[0] == 'accueil'): {
					$homepageController = new HomepageController();
					$homepageController->index($userModel);
					break;
				}
				// Posts
			case (preg_match('#^articles?-page([0-9]+)$#', $url[0], $params)): {
					$currentPage = intval($params[1]);
					$postController = new FrontPostController();
					$postController->displayPosts($postModel, $currentPage);
					break;
				}
				// Post-id with this comments
			case (preg_match('#^articles?-([0-9]+)-page([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$currentPage = intval($params[2]);
					$postController = new FrontPostController();
					$postController->displayPost($postModel, $commentModel, $idPost, $currentPage);
					break;
				}
				// Add a comment idPost
			case (preg_match('#^ajouter-un-commentaire-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$commentController = new CommentController();
					$commentController->insertComment($postModel, $commentModel, $idPost);
					break;
				}
				// Add a post
			case ($url[0] == 'ajouter-un-article'): {
					$postController = new BackPostController();
					$postController->addPost($postModel);
					break;
				}
				// Delete a post
			case (preg_match('#^supprimer-article-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$postController = new BackPostController();
					$postController->deletePost($idPost, $postModel);
					break;
				}
				// Edit a post -id
			case (preg_match('#^modifier-article-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$postController = new BackPostController();
					$postController->editPost($idPost, $postModel);
					break;
				}
				// Connection
			case ($url[0] == 'connexion'): {
					$userController = new UserController();
					$userController->connexion($userModel);
					break;
				}
				// Registration
			case ($url[0] == 'inscription'): {
					$userController = new UserController();
					$userController->register($userModel);
					break;
				}
				// Disconnection
			case ($url[0] == 'deconnexion'): {
					$userController = new UserController();
					$userController->disconnect();
					break;
				}
				// Administratrion
			case ($url[0] == 'administration'): {
					$adminController = new AdminController();
					$adminController->displayAllElements($userModel, $postModel, $commentModel);
					break;
				}
				// Admin-posts
			case ($url[0] == 'admin-waiting-posts'): {
					$adminController = new AdminController();
					$adminController->displayWaitingPosts($userModel, $postModel, $commentModel);
					break;
				}
				// Admin-users
			case ($url[0] == 'admin-pending-users'): {
					$adminController = new AdminController();
					$adminController->displayPendingUsers($userModel, $postModel, $commentModel);
					break;
				}
				// Admin-waiting-comments
			case ($url[0] == 'admin-waiting-comments'): {
					$adminController = new AdminController();
					$adminController->displayInvalidComments($userModel, $postModel, $commentModel);
					break;
				}
				// Admin-refused-comments
			case ($url[0] == 'admin-refused-comments'): {
					$adminController = new AdminController();
					$adminController->displayRefusedComments($userModel, $postModel, $commentModel);
					break;
				}
				// error-404
			case ($url[0] == 'error-404'): {
					$homepageController = new HomepageController();
					$homepageController->error404();
					break;
				}
				// error-500
			case ($url[0] == 'error-500'): {
					$homepageController = new HomepageController();
					$homepageController->error500();
					break;
				}
			default: {
					$homepageController = new HomepageController();
					$homepageController->error404();
					break;
				}
		}
	}

	// Unset success variables after display
	public function unsetSuccessErrorVariables()
	{
		unset($_SESSION['success']);
		unset($_SESSION['error']);
	}
}
