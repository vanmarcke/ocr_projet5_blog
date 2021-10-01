<?php

namespace Projet5\controller;

use Projet5\controller\HomepageController;

/**
 * Defined the different routes to the controllers 
 */
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
