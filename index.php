<?php

// Composer Autoloader
require_once('vendor/autoload.php');

// ROUTER
use Projet5\controller\Router;
$router = new Router();
$router->run();
