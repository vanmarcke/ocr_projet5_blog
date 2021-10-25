<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;
use Projet5\model\UserModel;

/**
 * Set the page to display first 
 */
class HomepageController extends TwigController
{	
	/**
	 * Get Homepage
	 *
	 * @param UserModel $userModel
	 */
	public function index(UserModel $userModel)
	{
		// load user datas if is connected
		if (isset($_SESSION['IdConnectedUser'])) {
			$userModel->loadUser($_SESSION['IdConnectedUser']);
		}

		// The form is not submitted, display the homepage
		if (count($_POST) === 0) {
			echo $this->twig->render('homepage.twig', ['SESSION' => $_SESSION]);
		}
	}
}
