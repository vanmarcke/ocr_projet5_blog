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
	// Set the number of pages for post and comment views 
	const POST_PER_PAGE = 4;
	const COMMENT_PER_PAGE = 5;

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
				/*Accueil*/
			case ($url == '' || $url[0] == 'accueil'): {
					$homepageController = new HomepageController();
					$homepageController->index($userModel);
					break;
				}
				/*Les Articles*/
			case (preg_match('#^articles?-page([0-9]+)$#', $url[0], $params)): {
					$currentPage = intval($params[1]);
					$postController = new FrontPostController();
					$postController->displayPosts($postModel, $currentPage);
					$url = '';
					break;
				}
				/*Un article-id with this comments*/
			case (preg_match('#^articles?-([0-9]+)-page([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$currentPage = intval($params[2]);
					$postController = new FrontPostController();
					$postController->displayPost($postModel, $commentModel, $idPost, $currentPage);
					break;
				}
				/*ajouter-un-commentaire-idPost*/
			case (preg_match('#^ajouter-un-commentaire-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$commentController = new CommentController();
					$commentController->insertComment($postModel, $commentModel, $idPost);
					break;
				}
				/*ajouter-un-article*/
			case ($url[0] == 'ajouter-un-article'): {
					$postController = new BackPostController();
					$postController->addPost($postModel);
					break;
				}
				/*supprimer-un-article*/
			case (preg_match('#^supprimer-article-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$postController = new BackPostController();
					$postController->deletePost($idPost, $postModel);
					break;
				}
				/*modifier-article-id*/
			case (preg_match('#^modifier-article-([0-9]+)$#', $url[0], $params)): {
					$idPost = $params[1];
					$postController = new BackPostController();
					$postController->editPost($idPost, $postModel);
					break;
				}
				/*connexion*/
			case ($url[0] == 'connexion'): {
					$userController = new UserController();
					$userController->connexion($userModel);
					break;
				}
				/*inscription*/
			case ($url[0] == 'inscription'): {
					$userController = new UserController();
					$userController->register($userModel);
					break;
				}
				/*deconnexion*/
			case ($url[0] == 'deconnexion'): {
					$userController = new UserController();
					$userController->disconnect();
					break;
				}
				/*administratrion*/
			case ($url[0] == 'administration'): {
					$adminController = new AdminController();
					$adminController->displayAllElements($userModel, $postModel, $commentModel);
					break;
				}
				/*admin-posts*/
			case ($url[0] == 'admin-waiting-posts'): {
					$adminController = new AdminController();
					$adminController->displayWaitingPosts($userModel, $postModel, $commentModel);
					break;
				}
				/*admin-users*/
			case ($url[0] == 'admin-pending-users'): {
					$adminController = new AdminController();
					$adminController->displayPendingUsers($userModel, $postModel, $commentModel);
					break;
				}
				/*admin-waiting-comments-*/
			case ($url[0] == 'admin-waiting-comments'): {
					$adminController = new AdminController();
					$adminController->displayInvalidComments($userModel, $postModel, $commentModel);
					break;
				}
				/*admin-refused-comments-*/
			case ($url[0] == 'admin-refused-comments'): {
					$adminController = new AdminController();
					$adminController->displayRefusedComments($userModel, $postModel, $commentModel);
					break;
				}
			default: {
					$_SESSION['error'] = 'Erreur 404 - Page non trouvé';
					$homepageController = new HomepageController();
					$homepageController->index($userModel);
					break;
				}
		}
	}

	// unset success variables after display
	public function unsetSuccessErrorVariables()
	{
		unset($_SESSION['success']);
		unset($_SESSION['error']);
	}
}
