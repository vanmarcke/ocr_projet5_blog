<?php

namespace Projet5\entity;

/**
 * Post
 */
class Post
{
    private $id;
    private $title;
    private $last_date_change;
    private $chapo;
    private $contents;
    private $publish;
    private $id_bpf_users;

    /**
     * Method getId
     * 
     * Get value of idPost
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
     * Set value of IdPost
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
     * Method getTitle
     * 
     * Get value of Title
     *
     * @return void
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
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Method getLastDateChange
     * 
     * Get value of LastDateChange
     *
     * @return void
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
     * @return void
     */
    public function setLastDateChange($lastDateChange)
    {
        $this->last_date_change = $lastDateChange;
    }

    /**
     * Method getChapo
     * 
     * Get value of Chapo
     *
     * @return void
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
     * @return void
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    /**
     * Method getContents
     * 
     * Get value of Contents
     *
     * @return void
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
     * @return void
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * Method getPublish
     * 
     * Get value of Publish
     *
     * @return void
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Method setPublish
     * 
     * Set value of Publish
     *
     * @param $publish
     *
     * @return string void
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     * Method getUsers
     * 
     * Get value of idUsers
     *
     * @return void
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
     * @return void
     */
    public function setUser($idUsers)
    {
        $this->id_bpf_users = $idUsers;
    }
}
