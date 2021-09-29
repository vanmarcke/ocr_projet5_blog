<?php

namespace Projet5\controller;

class TwigController{

	protected $twig;
	
	/**
	 * Instantiating the loader and template engine 
	 *
	 * @return void
	 */
	public function __construct(){
		// twig
		$loader = new \Twig\Loader\FilesystemLoader('public/view');
		$twig = new \Twig\Environment($loader, [
		    'cache' => false //__DIR__ .'/tmp'
		]);
		$this->twig = $twig;
	}
}
