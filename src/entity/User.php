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
     * @return object
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
     * @return object
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Method getPseudo
     * 
     * Get value of Pseudo
     *
     * @return object
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
     * @return object
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * Method getEmail
     * 
     * Get value of Email
     *
     * @return object
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
     * @return object
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Method getPassword
     * 
     * Get value of Password
     *
     * @return object
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
     * @return object
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Method getRank
     * 
     * Get value of Rank
     *
     * @return object
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
     * @return object
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
        return $this;
    }
}
