<?php

namespace Projet5\entity;

class Post
{
    private $id,
        $title,
        $last_date_change,
        $chapo,
        $contents,
        $publish,
        $id_bpf_users;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getLastDateChange()
    {
        return $this->last_date_change;
    }

    public function setLastDateChange($lastDateChange)
    {
        $this->last_date_change = $lastDateChange;
    }

    public function getChapo()
    {
        return $this->chapo;
    }

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function setContent($contents)
    {
        $this->contents = $contents;
    }

    public function getPublish()
    {
        return $this->publish;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    public function getUsers()
    {
        return $this->id_bpf_users;
    }

    public function setUser($idUsers)
    {
        $this->id_bpf_users = $idUsers;
    }
}
