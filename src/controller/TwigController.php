<?php

namespace Projet5\controller;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Defining the location of branch views 
 */
class TwigController
{
	protected Environment $twig;

	/**
	 * Instantiating the loader and template engine
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// Twig
		$loader = new FilesystemLoader('view');
		$twig = new Environment($loader, [
			'debug' => true,
			'cache' => false //__DIR__ .'/tmp'
		]);
		$twig->addExtension(new DebugExtension());
		$this->twig = $twig;
	}
}
