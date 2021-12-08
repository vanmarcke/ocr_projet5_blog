<?php

namespace Projet5\model;

use PDO;
use Projet5\entity\Post;
use Projet5\service\DatabaseService;

/**
 * Read, insertion, upgrade and deletion of post
 */
class PostModel extends DatabaseService
{
    /**
     * load all posts , param valid is 'publish'
     *
     * @param string $valid return the result only if post is publish
     * @param int $startLimit returns the number of the start of the loop for each page
     * @param int $numberPerPage returns the number of posts per page and limits the number of posts to 30 in admin
     *
     * @return Post
     */
    public function loadAllPost(string $valid, int $startLimit = 0, int $numberPerPage = 30)
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_blog_posts.id, title, last_date_change, chapo, contents, bpf_users.pseudo
                    FROM `bpf_blog_posts` 
                    LEFT JOIN bpf_users ON bpf_blog_posts.id_bpf_users = bpf_users.id 
                    WHERE publish = :publish 
                    ORDER BY bpf_blog_posts.id 
                    DESC LIMIT :startLimit , :numberPerPage '
        );
        $req->bindValue(':publish', $valid);
        $req->bindValue(':startLimit', $startLimit, PDO::PARAM_INT);
        $req->bindValue(':numberPerPage', $numberPerPage, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, 'Projet5\entity\Post');
    }

    /**
     * count all posts , param valid is 'publish'
     *
     * @param string $valid defined the type of post to count
     *
     * @return int
     */
    public function countAllPost(string $valid): int
    {
        $req = $this->getDb()->prepare('SELECT id FROM `bpf_blog_posts` WHERE publish = :publish');
        $req->bindValue(':publish', $valid);
        $req->execute();
        return $req->rowCount();
    }

    /**
     * load post with id
     *
     * @param int $idPost load the content of the posts with their id 
     *
     * @return Post
     */
    public function loadPost(int $idPost): Post
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_blog_posts.id, title, last_date_change, chapo, contents, publish, bpf_users.pseudo 
            FROM bpf_blog_posts 
            LEFT JOIN bpf_users ON bpf_blog_posts.id_bpf_users = bpf_users.id 
            WHERE bpf_blog_posts.id = :idPost'
        );
        $req->bindValue(':idPost', $idPost);
        $req->execute();
        return $req->fetchObject('Projet5\entity\Post');
    }

    /**
     * insert a new post
     *
     * @param Post $post insertion of a new post in the database 
     *
     * @return array
     */
    public function insertPost(Post $post)
    {
        $req = $this->getDb()->prepare(
            'INSERT INTO bpf_blog_posts(title, last_date_change, chapo, contents, publish, id_bpf_users) 
            VALUES(:title, NOW(), :chapo, :contents, :publish, :id_user)'
        );
        $req->bindValue(':title', $post->getTitle());
        $req->bindValue(':chapo', $post->getChapo());
        $req->bindValue(':contents', $post->getContents());
        $req->bindValue(':publish', $post->getPublish());
        $req->bindValue(':id_user', $post->getUsers());
        $req->execute();
    }

    /**
     * edit a post
     *
     * @param int $idPost returns the id of the post to modify 
     * @param Post $post contains the modified data
     * 
     * @return array
     */
    public function updatePost(int $idPost, Post $post)
    {
        $req = $this->getDb()->prepare(
            'UPDATE bpf_blog_posts 
            SET title=:title, last_date_change=NOW(), chapo=:chapo, contents=:contents, id_bpf_users=:id_user 
            WHERE id=:idPost'
        );
        $req->bindValue(':title', $post->getTitle());
        $req->bindValue(':chapo', $post->getChapo());
        $req->bindValue(':contents', $post->getContents());
        $req->bindValue(':id_user', $post->getUsers());
        $req->bindValue(':idPost', $idPost);
        $req->execute();
    }

    /**
     * publish a post
     *
     * @param int $idPost returns the id of the publication to modify to publish
     * 
     * @return array
     */
    public function publishPostWithId(int $idPost)
    {
        $req = $this->getDb()->prepare('UPDATE bpf_blog_posts SET publish=:publish WHERE id=:idPost');
        $req->bindValue(':publish', 'valid');
        $req->bindValue(':idPost', $idPost);
        $req->execute();
    }

    /**
     * delete a post
     *
     * @param int $idPost returns the id of the post to delete
     */
    public function deletePostWithId(int $idPost)
    {
        $req = $this->getDb()->prepare('DELETE FROM bpf_blog_posts WHERE id=:idPost');
        $req->bindValue(':idPost', $idPost);
        $req->execute();
    }
}
