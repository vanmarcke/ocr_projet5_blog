<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Set the page to display first 
 */
class HomepageController extends TwigController
{
	/**
	 * Get Homepage
	 *
	 * @return void
	 */
	public function index($userModel)
	{

		// load userDatas if is connected
		if (isset($_SESSION['IdConnectedUser'])) {
			$userDatas = $userModel->loadUser($_SESSION['IdConnectedUser']);
		} else {
			$userDatas = [];
		}

		// The form is not submitted, display the homepage
		if (count($_POST) === 0) {
			echo $this->twig->render('homepage.twig', ['SESSION' => $_SESSION, 'userDatas' => $userDatas]);
		}
	}
}
