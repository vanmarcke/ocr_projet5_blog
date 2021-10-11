<?php

namespace Projet5\controller;

use Projet5\controller\HomepageController;
use Projet5\controller\UserController;


use Projet5\model\UserModel;

/**
 * Defined the different routes to the controllers 
 */
class Router
{

	/**
	 * Execute the route to home page 
	 *
	 * @return void
	 */
	public function run()
	{

		// Configuration and global variables
		// require("src/config/database/config.php");

		// Models variables
		$userModel = new UserModel();

		// ROUTER
		$url = '';
		if (isset($_GET['url'])) {
			$url = explode('/', strtolower($_GET['url']));
		}
		/*Accueil*/
		if ($url == '' || $url[0] == 'accueil') {
			$homepageController = new HomepageController();
			$homepageController->index($userModel);

			/*connexion*/
		} elseif ($url[0] == 'connexion') {
			$userController = new UserController();
			$userController->connexion($userModel);

			/*inscription*/
		} elseif ($url[0] == 'inscription') {
			$userController = new UserController();
			$userController->register($userModel);

			/*deconnexion*/
		} elseif ($url[0] == 'deconnexion') {
			$userController = new UserController();
			$userController->deconnexion();
		} else {
			$_SESSION['error'] = 'Erreur 404 - Page non trouvé';
			$homepageController = new HomepageController();
			$homepageController->index($userModel);
		}
	}

	// unset success variables after display
	public function unsetSuccessErrorVariables()
	{

		unset($_SESSION['success']);
		unset($_SESSION['error']);
	}
}
