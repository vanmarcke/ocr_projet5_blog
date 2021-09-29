<?php

namespace Projet5\controller;

use Projet5\controller\HomepageController;

class Router{
	
	/**
	 * Execute the route to home page 
	 *
	 * @return void
	 */
	public function run(){
			$homepageController = new HomepageController();
			$homepageController->index();	
	}
}
