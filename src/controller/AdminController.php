<?php

namespace Projet5\controller;



class AdminController extends SessionController
{

	public function display()
	{
		// If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== 'admin') {
			$_SESSION['error'] = 'Cette page est réservé à l\'administrateur';
			header('location:Articles-Page1');
			exit;
		}		
		

		// display 
		echo $this->twig->render('admin.twig', [
			'SESSION' => $_SESSION
		]);
	}
	
}
