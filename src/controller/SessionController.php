<?php

namespace Projet5\controller;

use Exception;
use Projet5\controller\Constraints;

/**
 * Check the validity of the session
 */
class SessionController extends Constraints
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
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
