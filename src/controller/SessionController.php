<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Check the validity of the session
 */
class SessionController extends TwigController
{
	/**
	 * redirection according to user status 
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		// exit if not login
		if (!isset($_SESSION['IdConnectedUser'])) {
			$_SESSION['error'] = 'Vous n\'êtes pas connecté';
			header('location:Connexion');
		}
		// exit if not valide
		if ($_SESSION['rankConnectedUser'] == 'pending') {
			$_SESSION['error'] = 'Votre compte n\'a pas encore été validé par un administrateur';
			header('location:Accueil');
			exit;
		}
	}
}
