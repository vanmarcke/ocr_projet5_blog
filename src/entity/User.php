<?php

namespace Projet5\entity;

class User
{
    private $id;
    private $pseudo;
    private $email;
    private $password;
    private $rank;

    /**
     * Method getId
     * 
     * Get value of idUser
     *
     * @return void
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Method setId
     * 
     * Set value of IdUser
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Method getPseudo
     * 
     * Get value of Pseudo
     *
     * @return void
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Method setPseudo
     * 
     * Set value of Pseudo
     *
     * @param string $pseudo
     *
     * @return void
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Method getEmail
     * 
     * Get value of Email
     *
     * @return void
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Method setEmail
     * 
     * Set value of Email
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Method getPassword
     * 
     * Get value of Password
     *
     * @return void
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Method setPassword
     * 
     * Set value of Password
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Method getRank
     * 
     * Get value of Rank
     *
     * @return void
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Method setRank
     * 
     * Set value of Rank
     *
     * @param string $rank
     *
     * @return void
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    }
}
