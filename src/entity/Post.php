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
     * @return object
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Method setId
     * 
     * Set value of IdPost
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
     * Method getTitle
     * 
     * Get value of Title
     *
     * @return object
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Method setTitle
     * 
     * Set value of Title
     *
     * @param string $title
     *
     * @return object
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Method getLastDateChange
     * 
     * Get value of LastDateChange
     *
     * @return object
     */
    public function getLastDateChange()
    {
        return $this->last_date_change;
    }

    /**
     * Method setLastDateChange
     * 
     * Set value of LasDateChange
     *
     * @param string $lastDateChange
     *
     * @return object
     */
    public function setLastDateChange($lastDateChange)
    {
        $this->last_date_change = $lastDateChange;
        return $this;
    }

    /**
     * Method getChapo
     * 
     * Get value of Chapo
     *
     * @return object
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Method setChapo
     * 
     * Set value of Chapo
     *
     * @param string $chapo
     *
     * @return object
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * Method getContents
     * 
     * Get value of Contents
     *
     * @return object
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Method setContents
     * 
     * Set value of Contents
     *
     * @param string $contents
     *
     * @return object
     */
    public function setContents($contents)
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
     * @param string $publish flag value expected : 'valid' or 'waiting'
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
     * @return object
     */
    public function getUsers()
    {
        return $this->id_bpf_users;
    }

    /**
     * Method setUser
     * 
     * Set value of IdUsers
     *
     * @param int $idUsers
     *
     * @return object
     */
    public function setUser($idUsers)
    {
        $this->id_bpf_users = $idUsers;
        return $this;
    }
}
