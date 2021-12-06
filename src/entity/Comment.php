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
     * @return void
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
     * @return void
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Method getContents
     * 
     * Get value of contents
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
     * Method getDateComment
     * 
     * Get value of DateComment
     *
     * @return void
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
     * @return void
     */
    public function setDateComment($dateComment)
    {
        $this->date_comment = $dateComment;
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
     * @param string $publish
     *
     * @return void
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     * Method getIdBlogPosts
     * 
     * Get value of IdBlogPosts
     *
     * @return void
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
     * @return void
     */
    public function setIdBlogPosts($idBlogPosts)
    {
        $this->id_bpf_blog_posts = $idBlogPosts;
    }

    /**
     * Method getIdUsers
     * 
     * Get value of IdUsers
     *
     * @return void
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
     * @return void
     */
    public function setIdUsers($idUsers)
    {
        $this->id_bpf_users = $idUsers;
    }
}
