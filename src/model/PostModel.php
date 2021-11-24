<?php

namespace Projet5\model;

use PDO;
use PDOException;
use Projet5\service\DatabaseService;

/**
 * Read, insertion, upgrade and deletion of post
 */
class PostModel extends DatabaseService
{
    /**
     * load all posts , param valide is 'publish'
     *
     * @param string $valide return the result only if post is publish
     * @param int $startLimit returns the number of the start of the loop for each page
     * @param int $numberPerPage returns the number of posts per page and limits the number of posts to 30 in admin
     *
     * @return array
     */
    public function loadAllPost(string $valide, int $startLimit = 0, int $numberPerPage = 30)
    {

        try {
            $req = $this->getDb()->prepare(
                'SELECT bpf_blog_posts.id, title, last_date_change, chapo, contents, bpf_users.pseudo 
                    FROM `bpf_blog_posts` 
                    LEFT JOIN bpf_users ON bpf_blog_posts.id_bpf_users = bpf_users.id 
                    WHERE publish = :publish 
                    ORDER BY bpf_blog_posts.id 
                    DESC LIMIT :startLimit , :numberPerPage '
            );
            $req->bindValue(':publish', $valide);
            $req->bindValue(':startLimit', $startLimit, PDO::PARAM_INT);
            $req->bindValue(':numberPerPage', $numberPerPage, PDO::PARAM_INT);
            $req->execute();
            return $req;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * count all posts , param valide is 'publish'
     *
     * @param string $valide returns the number of post that is 'publish' 
     *
     * @return array
     */
    public function countAllPost(string $valide)
    {
        try {
            $req = $this->getDb()->prepare('SELECT id FROM `bpf_blog_posts` WHERE publish = :publish');
            $req->bindValue(':publish', $valide);
            $req->execute();
            return $req;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * load post with id
     *
     * @param int $idPost load the content of the posts with their id 
     *
     * @return array
     */
    public function loadPost(int $idPost)
    {
        try {
            $req = $this->getDb()->prepare(
                'SELECT bpf_blog_posts.id, title, last_date_change, chapo, contents, publish, bpf_users.pseudo 
            FROM bpf_blog_posts 
            LEFT JOIN bpf_users ON bpf_blog_posts.id_bpf_users = bpf_users.id 
            WHERE bpf_blog_posts.id = :idPost'
            );
            $req->bindValue(':idPost', $idPost);
            $req->execute();
            $row = $req->fetch(PDO::FETCH_ASSOC);
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * insert a new post
     *
     * @param array $datas insertion of a new post in the database 
     *
     * @return array
     */
    public function insertPost(array $datas)
    {
        $req = $this->getDb()->prepare(
            'INSERT INTO bpf_blog_posts(title, last_date_change, chapo, contents, publish, id_bpf_users) 
            VALUES(:title, NOW(), :chapo, :contents, :publish, :id_user)'
        );
        $req->bindValue(':title', $datas['title']);
        $req->bindValue(':chapo', $datas['chapo']);
        $req->bindValue(':contents', $datas['contents']);
        $req->bindValue(':publish', 'waiting');
        $req->bindValue(':id_user', $datas['id_user']);
        $req->execute();
    }

    /**
     * edit a post
     *
     * @param int $idPost returns the id of the post to modify 
     * @param array $datas contains the modified data
     * 
     * @return array
     */
    public function updatePost(int $idPost, array $datas)
    {
        $req = $this->getDb()->prepare(
            'UPDATE bpf_blog_posts 
            SET title=:title, last_date_change=NOW(), chapo=:chapo, contents=:contents, id_bpf_users=:id_user 
            WHERE id=:idPost'
        );
        $req->bindValue(':title', $datas['title']);
        $req->bindValue(':chapo', $datas['chapo']);
        $req->bindValue(':contents', $datas['contents']);
        $req->bindValue(':id_user', $datas['id_user']);
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
