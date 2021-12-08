<?php

namespace Projet5\entity;

/**
 * Comment
 */
class Comment
{
    private $id;
    private $contents;
    private $date_comment;
    private $publish;
    private $id_bpf_blog_posts;
    private $id_bpf_users;

    /**
     * Method getId
     * 
     * Get value of idComment
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
     * Set value of idComment
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
     * Method getContents
     * 
     * Get value of contents
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
     * Method getDateComment
     * 
     * Get value of DateComment
     *
     * @return object
     */
    public function getDateComment()
    {
        return $this->date_comment;
    }

    /**
     * Method setDateComment
     * 
     * Set value of DateComment
     *
     * @param string $dateComment
     *
     * @return object
     */
    public function setDateComment($dateComment)
    {
        $this->date_comment = $dateComment;
        return $this;
    }

    /**
     * Method getPublish
     * 
     * Get value of Publish
     *
     * @return object
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
     * @param string $publish
     *
     * @return object
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
        return $this;
    }

    /**
     * Method getIdBlogPosts
     * 
     * Get value of IdBlogPosts
     *
     * @return object
     */
    public function getIdBlogPosts()
    {
        return $this->id_bpf_blog_posts;
    }

    /**
     * Method setIdBlogPosts
     * 
     * Set value of idBlogPosts
     *
     * @param int $idBlogPosts
     *
     * @return object
     */
    public function setIdBlogPosts($idBlogPosts)
    {
        $this->id_bpf_blog_posts = $idBlogPosts;
        return $this;
    }

    /**
     * Method getIdUsers
     * 
     * Get value of IdUsers
     *
     * @return object
     */
    public function getIdUsers()
    {
        return $this->id_bpf_users;
    }

    /**
     * Method setIdUsers
     * 
     * Set value of idUsers
     *
     * @param int $idUsers
     *
     * @return object
     */
    public function setIdUsers($idUsers)
    {
        $this->id_bpf_users = $idUsers;
        return $this;
    }
}
