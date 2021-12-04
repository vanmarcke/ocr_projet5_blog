<?php

namespace Projet5\model;

use PDO;
use Projet5\entity\User;
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
        $req = $this->getDb()->prepare('SELECT * FROM `bpf_users` WHERE `id`= :id;');
        $req->execute(['id' => $idUser]);
        $userDatas = $req->fetch(PDO::FETCH_ASSOC);
        return $userDatas;
    }

    /**
     * Return id users with email
     *
     * @param  string $email User identifier
     * @return array of user informations
     */
    public function loadByEmail(string $email)
    {
        $req = $this->getDb()->prepare('SELECT id FROM bpf_users WHERE email = :email');
        $req->bindValue(':email', $email);
        $req->execute();
        $row = $req->fetch(PDO::FETCH_ASSOC);
        return $this->loadUser($row['id']);
    }

    /**
     * Return all pending users
     *
     * @return User list of pending users 
     */
    public function loadPendingUsers()
    {
        $req = $this->getDb()->prepare('SELECT id, pseudo, email FROM `bpf_users` WHERE `rank`= "pending" ');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, 'Projet5\entity\User');
    }

    /**
     * insert user with datas table
     *
     * @param  User $user
     * @return array list of data to insert in the database 
     */
    public function insert(User $user)
    {
        $req = $this->getDb()->prepare(
            'INSERT INTO bpf_users(pseudo, email, password, rank) 
            VALUES(:pseudo, :email, :password, :rank)'
        );
        $req->bindValue(':pseudo', $user->getPseudo());
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':password', $user->getPassword());
        $req->bindValue(':rank', $user->getRank());
        $req->execute();
    }

    /**
     * validate a new user
     *
     * @param  int $idUser User identifier
     * @return array of user informations
     */
    public function validateUserWithId(int $idUser)
    {
        $req = $this->getDb()->prepare('UPDATE bpf_users SET rank=:rank WHERE id=:idUser');
        $req->bindValue(':rank', 'registered');
        $req->bindValue(':idUser', $idUser);
        $req->execute();
    }

    /**
     * delete a user
     *
     * @param  int $idUser User identifier
     * @return array of user informations
     */
    public function deleteUserWithId(int $idUser)
    {
        $req = $this->getDb()->prepare('DELETE FROM bpf_users WHERE id=:idUser');
        $req->bindValue(':idUser', $idUser);
        $req->execute();
    }
}
