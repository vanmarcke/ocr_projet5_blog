<?php

namespace Projet5\model;

use PDO;
use Projet5\service\DatabaseService;

/**
 * User read and insert
 */
class UserModel extends DatabaseService
{
    /**
     * loadUser
     *
     * @param  int $id
     * @return void
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
     * @param  string $email
     * @return void
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
     * @return void
     */
    public function loadPendingUsers()
    {
        $req = $this->getDb()->prepare('SELECT * FROM `bpf_users` WHERE `rank`= "pending" ');
        $req->execute();
        return $req;
    }

    /**
     * insert user with datas table
     *
     * @param  array $datas
     * @return void
     */
    public function insert(array $datas)
    {
        $req = $this->getDb()->prepare('INSERT INTO bpf_users(pseudo, email, password, rank) VALUES(:pseudo, :email, :password, :rank)');
        $req->bindValue(':pseudo', $datas['pseudo']);
        $req->bindValue(':email', $datas['email']);
        $req->bindValue(':password', password_hash($datas['password'], PASSWORD_DEFAULT));
        $req->bindValue(':rank', 'pending');
        $req->execute();
    }
}
