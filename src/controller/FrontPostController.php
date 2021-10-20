<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

class FrontPostController extends TwigController{


	public function displayPosts(){

				echo $this->twig->render('blog_posts.twig', [
			'SESSION' => $_SESSION
		]);
	}	
}

