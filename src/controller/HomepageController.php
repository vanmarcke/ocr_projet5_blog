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
			$this->render('homepage.twig', $_SESSION);
		}
	}

	/**
	 * Get error404
	 *
	 */
	public function error404()
	{
		$this->render('error_404.twig', $_SESSION);
	}

	/**
	 * Get error500
	 *
	 */
	public function error500()
	{
		$this->render('error_500.twig', $_SESSION);
	}


	/**
	 * render Template
	 *
	 * @param $templateName Template name to render
	 * @param array $session user session	
	 * @throws LoaderError
	 * @throws RuntimeError
	 * @throws SyntaxError
	 */
	private function render($templateName, array $session)
	{
		echo $this->twig->render($templateName, ['SESSION' => $session]);
	}
}
