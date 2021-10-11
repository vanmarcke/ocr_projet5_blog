<?php

namespace Projet5\service;

use PDO;

/**
 * Define the database connection parameters 
 */
class DatabaseService
{
	private $bdd; // objet PDO

	/**
	 * getDb
	 *
	 * @return mixed
	 */
	public function getDb() // méthode permettant d'instancier la class PDO
	{
		if (!$this->bdd) // seulement si $this->db n'est pas rempli, si il n'y a pas de connexion, alors on la construit
		{
			try 
			{
				// pour faire du test sur la classe '../app/config.xml'
				$xml = simplexml_load_file('app/config.xml'); // simplexml_load_file permet de convertir le fichier XML en objet SimpleXMLElement 
				// echo '<pre>'; print_r($xml); echo '</pre>';          

				try // on tente la connexion à la BDD
				{
					$this->bdd = new PDO("mysql:dbname=" . $xml->db . ";host=" . $xml->host, $xml->user, $xml->password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
				} catch (\PDOException $e) {
					die('Problème de connexion BDD, erreur : ' . $e->getMessage());
				}
			} catch (\Exception $e) {
				die('Problème de fichier XML, erreur : ' . $e->getMessage());
			}
		}
		return $this->bdd;
	}
}
