<?php

namespace Projet5\model;

use PDO;
use Projet5\service\DatabaseService;

/**
 * Reading, inserting, updating and deleting comments 
 */
class CommentModel extends DatabaseService
{
    /**
     * load comments for one post
     *
     * @param string $idPost return the id of the comment
     * @param int $startLimit returns the number of the start of the loop for each page
     * @param int $numberPerPage returns the number of comments per page and limit the number of comments to 50 in admin
     *
     * @return array
     */
    public function loadAllCommentsWithIdPost(string $idPost, int $startLimit = 0, int $numberPerPage = 50)
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE id_bpf_blog_posts=:idPost ORDER BY bpf_comments.id 
            DESC LIMIT :startLimit , :numberPerPage'
        );
        $req->bindValue(':idPost', $idPost);
        $req->bindValue(':startLimit', $startLimit, PDO::PARAM_INT);
        $req->bindValue(':numberPerPage', $numberPerPage, PDO::PARAM_INT);
        $req->execute();
        return $req;
    }

    /**
     * load comments with waiting status
     *
     * @return array
     */
    public function loadInvalidComments()
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE publish = "waiting"'
        );
        $req->execute();
        return $req;
    }

    /**
     * load comments with denied status
     *
     * @return array
     */
    public function loadRefuseComments()
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE publish = "refused"'
        );
        $req->execute();
        return $req;
    }

    /**
     * insert a new comment 
     *
     * @param array $datas insertion of a new comment in the database
     * 
     * @return array
     */
    public function insertComment(array $datas)
    {
        $req = $this->getDb()->prepare(
            'INSERT INTO bpf_comments(contents, publish, id_bpf_blog_posts, id_bpf_users) 
            VALUES(:contents, :publish, :id_blog_post, :id_user)'
        );
        $req->bindValue(':contents', $datas['contents']);
        $req->bindValue(':publish', 'waiting');
        $req->bindValue(':id_blog_post', $datas['id_blog_post']);
        $req->bindValue(':id_user', $datas['id_user']);
        $req->execute();
    }

    /**
     * validate a new comment     
     *
     * @param int $idComment returns the id of the comment to modify to publish
     * 
     * @return array
     */
    public function publishCommentWithId(int $idComment)
    {
        $req = $this->getDb()->prepare('UPDATE bpf_Comments SET publish=:publish WHERE id=:idComment');
        $req->bindValue(':publish', 'valid');
        $req->bindValue(':idComment', $idComment);
        $req->execute();
    }

    /**
     * delete a comment
     *
     * @param int $idComment returns the id of the comment to delete
     */
    public function deleteCommentWithId(int $idComment)
    {
        $req = $this->getDb()->prepare('DELETE FROM bpf_Comments WHERE id=:idComment');
        $req->bindValue(':idComment', $idComment);
        $req->execute();
    }

    /**
     * decline a comment
     *
     * @param int $idComment returns the id of the comment to modify to refuse
     * 
     * @return array
     */
    public function refuseCommentWithId(int $idComment)
    {
        $req = $this->getDb()->prepare('UPDATE bpf_Comments SET publish=:publish WHERE id=:idComment');
        $req->bindValue(':publish', 'refused');
        $req->bindValue(':idComment', $idComment);
        $req->execute();
    }
}
