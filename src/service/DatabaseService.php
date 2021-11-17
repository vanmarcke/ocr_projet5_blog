<?php

namespace Projet5\service;

use Exception;
use PDO;
use PDOException;

/**
 * Define the database connection parameters 
 */
class DatabaseService
{
	/**
	 * bdd
	 *
	 * @var object PDO
	 */
	private $bdd;

	/**
	 * getDb
	 *
	 * @return object PDOStatement
	 */
	public function getDb()
	{
		if (!$this->bdd) {
			try {

				$xml = simplexml_load_file('app/config.xml');

				try {
					$this->bdd = new PDO("mysql:dbname=" . $xml->db . ";host=" . $xml->host, $xml->user, $xml->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
				} catch (PDOException $e) {
					header('location:error-500');
				}
			} catch (Exception $e) {
				header('location:error-500');
			}
		}
		return $this->bdd;
	}
}
