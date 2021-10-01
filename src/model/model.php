<?php

namespace Projet5\model;

use Exception;
use PDO;

/**
 * Define the database connection parameters 
 */
class Model
{
	protected $bdd;

	/**
	 * DataBase connexion
	 *
	 * @param  mixed $dataBase
	 * @return void
	 */
	public function __construct($dataBase)
	{
		try {
			$bdd = new PDO("mysql:host=" . $dataBase['dbServer'] . ";dbname=" . $dataBase['dbName'] . ";charset=utf8", $dataBase['dbUser'], $dataBase['dbPass'], array(PDO::ATTR_PERSISTENT => true));

			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			die('*********** Erreur de connexion à la BDD ! ***********');
		}
		$this->bdd = $bdd;
	}
}
