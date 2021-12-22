<?php

namespace Projet5\entity;

/**
 * Post
 */
class Post
{
    private int $id;
    private string $title;
    private string $last_date_change;
    private string $chapo;
    private string $contents;
    private string $publish;
    private int $id_bpf_users;

    /**
     * Method getId
     *
     * Get value of idPost
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
     * Set value of IdPost
     *
     * @param int $id Expected value : IdPost
     *
     * @return Post
     */
    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Method getTitle
     *
     * Get value of Title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Method setTitle
     *
     * Set value of Title
     *
     * @param string $title Expected value : Title
     *
     * @return Post
     */
    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Method getLastDateChange
     *
     * Get value of LastDateChange
     *
     * @return string
     */
    public function getLastDateChange(): string
    {
        return $this->last_date_change;
    }

    /**
     * Method setLastDateChange
     *
     * Set value of LasDateChange
     *
     * @param string $lastDateChange Expected value : update date of post
     *
     * @return Post
     */
    public function setLastDateChange(string $lastDateChange): Post
    {
        $this->last_date_change = $lastDateChange;
        return $this;
    }

    /**
     * Method getChapo
     *
     * Get value of Chapo
     *
     * @return string
     */
    public function getChapo(): string
    {
        return $this->chapo;
    }

    /**
     * Method setChapo
     *
     * Set value of Chapo
     *
     * @param string $chapo Expected value : Chapo of the post (post subtitle)
     *
     * @return Post
     */
    public function setChapo(string $chapo): Post
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * Method getContents
     *
     * Get value of Contents
     *
     * @return string
     */
    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * Method setContents
     *
     * Set value of Contents
     *
     * @param string $contents Expected value : content of the post
     *
     * @return Post
     */
    public function setContents(string $contents): Post
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * Method getPublish
     *
     * Get value of Publish
     *
     * @return string
     */
    public function getPublish(): string
    {
        return $this->publish;
    }

    /**
     * Method setPublish
     *
     * Get value of  Publish
     *
     * @param string $publish Flag value expected : 'valid' or 'waiting'
     *
     * @return Post
     */
    public function setPublish(string $publish): Post
    {
        $this->publish = $publish;
        return $this;
    }

    /**
     * Method getUsers
     *
     * Get value of idUsers
     *
     * @return int
     */
    public function getUsers(): int
    {
        return $this->id_bpf_users;
    }

    /**
     * Method setUser
     *
     * Set value of IdUsers
     *
     * @param int $idUsers Expected value : IdUser
     *
     * @return Post
     */
    public function setUser(int $idUsers): Post
    {
        $this->id_bpf_users = $idUsers;
        return $this;
    }
}
