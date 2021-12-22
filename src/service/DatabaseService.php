<?php

namespace Projet5\service;

use Exception;
use PDO;
use PDOException;
use Projet5\controller\Constraints;

/**
 * Define the database connection parameters
 */
class DatabaseService extends Constraints
{
    /**
     * Bdd
     *
     * @var object PDO
     */
    private $bdd;

    /**
     * GetDb PDOStatement
     *
     * @return object
     */
    public function getDb(): object
    {
        if (!$this->bdd) {
            try {
                $xml = simplexml_load_file('app/config.xml');

                try {
                    $this->bdd = new PDO(
                        "mysql:dbname=" .
                        $xml->db . ";host=" .
                        $xml->host,
                        $xml->user,
                        $xml->password,
                        array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
                    );
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
