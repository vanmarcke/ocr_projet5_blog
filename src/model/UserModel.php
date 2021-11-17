<?php

namespace Projet5\model;

use PDO;
use PDOException;
use Projet5\service\DatabaseService;

/**
 * Reading, inserting, updating and deleting users 
 */
class UserModel extends DatabaseService
{
    /**
     * loadUser
     *
     * @param  int $idUser User identifier
     * @return array of user informations
     */
    public function loadUser(int $idUser)
    {
        try {
            $req = $this->getDb()->prepare('SELECT * FROM `bpf_users` WHERE `id`= :id;');
            $req->execute(['id' => $idUser]);
            $userDatas = $req->fetch(PDO::FETCH_ASSOC);
            return $userDatas;
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }

    /**
     * Return id users with email
     *
     * @param  string $email User identifier
     * @return array of user informations
     */
    public function loadByEmail(string $email)
    {
        try {
            $req = $this->getDb()->prepare('SELECT id FROM bpf_users WHERE email = :email');
            $req->bindValue(':email', $email);
            $req->execute();
            $row = $req->fetch(PDO::FETCH_ASSOC);
            return $this->loadUser($row['id']);
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }

    /**
     * Return all pending users
     *
     * @return array list of pending users 
     */
    public function loadPendingUsers()
    {
        try {
            $req = $this->getDb()->prepare('SELECT * FROM `bpf_users` WHERE `rank`= "pending" ');
            $req->execute();
            return $req;
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }

    /**
     * insert user with datas table
     *
     * @param  array $datas
     * @return array list of data to insert in the database 
     */
    public function insert(array $datas)
    {
        try {
            $req = $this->getDb()->prepare(
                'INSERT INTO bpf_users(pseudo, email, password, rank) 
            VALUES(:pseudo, :email, :password, :rank)'
            );
            $req->bindValue(':pseudo', $datas['pseudo']);
            $req->bindValue(':email', $datas['email']);
            $req->bindValue(':password', password_hash($datas['password'], PASSWORD_DEFAULT));
            $req->bindValue(':rank', 'pending');
            $req->execute();
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }

    /**
     * validate a new user
     *
     * @param  int $idUser User identifier
     * @return array of user informations
     */
    public function validateUserWithId(int $idUser)
    {
        try {
            $req = $this->getDb()->prepare('UPDATE bpf_users SET rank=:rank WHERE id=:idUser');
            $req->bindValue(':rank', 'registered');
            $req->bindValue(':idUser', $idUser);
            $req->execute();
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }

    /**
     * delete a user
     *
     * @param  int $idUser User identifier
     * @return array of user informations
     */
    public function deleteUserWithId(int $idUser)
    {
        try {
            $req = $this->getDb()->prepare('DELETE FROM bpf_users WHERE id=:idUser');
            $req->bindValue(':idUser', $idUser);
            $req->execute();
        } catch (PDOException $e) {
            header('location:error-500');
        }
    }
}
