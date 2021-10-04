<?php

namespace Projet5\model;

use PDOException;
use PDO;

/**
 * Define the database connection parameters 
 */
class DatabaseService
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
		} catch (PDOException $e) {
			echo '<b>Erreur de connexion à la base de données : <br> Ligne : ' . $e->getLine() . ' :</b> ' . $e->getMessage();
			exit;
		}
		return $this->bdd = $bdd;
	}
}
