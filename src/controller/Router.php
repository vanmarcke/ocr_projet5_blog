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
		// Models variables
		$userModel = new UserModel();

		// ROUTER

		$url = '';
		if (isset($_GET['url'])) {
			$url = explode('/', strtolower($_GET['url']));
		}
		/*home page*/
		switch ($url[0]) {
			case '':
				$homepageController = new HomepageController();
				$homepageController->openHome($userModel);
				break;

				/*Accueil*/
			case 'accueil':
				$homepageController = new HomepageController();
				$homepageController->index($userModel);
				break;

				/*connexion*/
			case 'connexion':
				$userController = new UserController();
				$userController->connexion($userModel);
				break;

				/*inscription*/
			case 'inscription':
				$userController = new UserController();
				$userController->register($userModel);
				break;

				/*deconnexion*/
			case 'deconnexion':
				$userController = new UserController();
				$userController->deconnexion();
				break;

				/*redirect if page not found*/
			default;
				$_SESSION['error'] = 'Erreur 404 - Page non trouvé';
				$homepageController = new HomepageController();
				$homepageController->index($userModel);
				break;
		}
	}

	// unset success variables after display
	public function unsetSuccessErrorVariables()
	{
		unset($_SESSION['success']);
		unset($_SESSION['error']);
	}
}
