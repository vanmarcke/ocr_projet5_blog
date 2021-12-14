<?php

namespace Projet5\entity;

/**
 * Comment
 */
class Comment
{
    private int $id;
    private string $contents;
    private string $date_comment;
    private string  $publish;
    private int $id_bpf_blog_posts;
    private int $id_bpf_users;

    /**
     * Method getId
     * 
     * Get value of idComment
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
     * Set value of idComment
     *
     * @param int $id expected value : IdComment
     *
     * @return Comment
     */
    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Method getContents
     * 
     * Get value of contents
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
     * @param string $contents expected value : content of a comment 
     *
     * @return Comment
     */
    public function setContents(String $contents): Comment
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * Method getDateComment
     * 
     * Get value of DateComment
     *
     * @return string
     */
    public function getDateComment(): string
    {
        return $this->date_comment;
    }

    /**
     * Method setDateComment
     * 
     * Set value of DateComment
     *
     * @param string $dateComment expected value: date of a comment
     *
     * @return Comment
     */
    public function setDateComment(string $dateComment): Comment
    {
        $this->date_comment = $dateComment;
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
     * Set value of Publish
     *
     * @param string $publish flag value expected : 'valid', 'waiting' or 'refused'
     *
     * @return Comment
     */
    public function setPublish(string $publish): Comment
    {
        $this->publish = $publish;
        return $this;
    }

    /**
     * Method getIdBlogPosts
     * 
     * Get value of IdBlogPosts
     *
     * @return int
     */
    public function getIdBlogPosts(): int
    {
        return $this->id_bpf_blog_posts;
    }

    /**
     * Method setIdBlogPosts
     * 
     * Set value of idBlogPosts
     *
     * @param int $idBlogPosts expected value: id of a Blog Post 
     *
     * @return Comment
     */
    public function setIdBlogPosts(int $idBlogPosts): Comment
    {
        $this->id_bpf_blog_posts = $idBlogPosts;
        return $this;
    }

    /**
     * Method getIdUsers
     * 
     * Get value of IdUsers
     *
     * @return int
     */
    public function getIdUsers(): int
    {
        return $this->id_bpf_users;
    }

    /**
     * Method setIdUsers
     * 
     * Set value of idUsers
     *
     * @param int $idUsers expected value: idUser
     *
     * @return Comment
     */
    public function setIdUsers(int $idUsers): Comment
    {
        $this->id_bpf_users = $idUsers;
        return $this;
    }
}
