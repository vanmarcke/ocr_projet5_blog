<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Set the page to display first 
 */
class HomepageController extends TwigController{
	
	/**
	 * Get Homepage
	 *
	 * @return void
	 */
	public function index(){
	        echo $this->twig->render('homepage.twig');
	    }
	}
