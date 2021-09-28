<?php

namespace Projet5\controller;

use Projet5\controller\HomepageController;

class Router{

	public function run(){

		// ROUTER

			$homepageController = new HomepageController();
			$homepageController->index();	
	}

}

