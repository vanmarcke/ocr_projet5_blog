<?php

namespace Projet5\entity;

class User
{
    private int $id;
    private string $pseudo;
    private string $email;
    private string $password;
    private string $rank;

    /**
     * Method getId
     *
     * Get value of idUser
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Method setId
     *
     * Set value of IdUser
     *
     * @param int $id Expected value : IdUser
     *
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Method getPseudo
     *
     * Get value of Pseudo
     *
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Method setPseudo
     *
     * Set value of Pseudo
     *
     * @param string $pseudo Expected value : pseudo User
     *
     * @return User
     */
    public function setPseudo(string $pseudo): User
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    /**
     * Method getEmail
     *
     * Get value of Email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Method setEmail
     *
     * Set value of Email
     *
     * @param string $email Expected value : email User
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Method getPassword
     *
     * Get value of Password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Method setPassword
     *
     * Set value of Password
     *
     * @param string $password Expected value : password User
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Method getRank
     *
     * Get value of Rank
     *
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * Method setRank
     *
     * Set value of Rank
     *
     * @param string $rank Flag value expected : 'pending' or 'registered'
     *
     * @return User
     */
    public function setRank(string $rank): User
    {
        $this->rank = $rank;
        return $this;
    }
}
