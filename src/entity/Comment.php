<?php

namespace Projet5\entity;

class Comment
{
    private $id,
        $contents,
        $date_comment,
        $publish,
        $id_bpf_blog_posts,
        $id_bpf_users;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    public function getDateComment()
    {
        return $this->date_comment;
    }

    public function setDateComment($dateComment)
    {
        $this->date_comment = $dateComment;
    }

    public function getPublish()
    {
        return $this->publish;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    public function getIdBlogPosts()
    {
        return $this->id_bpf_blog_posts;
    }

    public function setIdBlogPosts($idBlogPosts)
    {
        $this->id_bpf_blog_posts = $idBlogPosts;
    }

    public function getIdUsers()
    {
        return $this->id_bpf_users;
    }

    public function setIdUsers($idUsers)
    {
        $this->id_bpf_users = $idUsers;
    }
}
