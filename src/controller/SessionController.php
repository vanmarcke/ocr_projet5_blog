<?php

namespace Projet5\controller;

use Exception;
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

		try {
			// exit if not login
			if (!isset($_SESSION['IdConnectedUser'])) {
				header('location:Connexion');
				throw new Exception($_SESSION['error'] = 'Vous n\'êtes pas connecté');
			}
			// exit if not valide
			if ($_SESSION['rankConnectedUser'] == 'pending') {
				header('location:Accueil');
				throw new Exception($_SESSION['error'] = 'Votre compte n\'a pas encore été validé par un administrateur');
			}
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
