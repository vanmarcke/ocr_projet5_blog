<?php

namespace Projet5\model;

use PDO;
use Projet5\entity\Comment;
use Projet5\service\DatabaseService;

/**
 * Reading, inserting, updating and deleting comments 
 */
class CommentModel extends DatabaseService
{
    /**
     * load comments for one post
     *
     * @param int $idPost return the id of the comment
     *
     * @return Comment
     */
    public function loadAllCommentsWithIdPost(int $idPost)
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE id_bpf_blog_posts=:idPost ORDER BY bpf_comments.id DESC'
        );
        $req->bindValue(':idPost', $idPost);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, 'Projet5\entity\Comment');
    }

    /**
     * load comments with waiting status
     *
     * @return Comment
     */
    public function loadInvalidComments()
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE publish = "waiting"'
        );
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, 'Projet5\entity\Comment');
    }

    /**
     * load comments with denied status
     *
     * @return Comment
     */
    public function loadRefuseComments()
    {
        $req = $this->getDb()->prepare(
            'SELECT bpf_comments.id, contents, date_comment, publish, bpf_users.pseudo 
            FROM `bpf_comments` LEFT JOIN bpf_users ON bpf_comments.id_bpf_users = bpf_users.id 
            WHERE publish = "refused"'
        );
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, 'Projet5\entity\Comment');
    }

    /**
     * insert a new comment 
     *
     * @param Comment $comment insertion of a new comment in the database
     * 
     * @return array
     */
    public function insertComment(Comment $comment)
    {
        $req = $this->getDb()->prepare(
            'INSERT INTO bpf_comments(contents, publish, id_bpf_blog_posts, id_bpf_users) 
            VALUES(:contents, :publish, :id_blog_post, :id_user)'
        );
        $req->bindValue(':contents', $comment->getContents());
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $req->bindValue(':publish', 'waiting');
            $req->bindValue(':id_blog_post', $comment->getIdBlogPosts());
            $req->bindValue(':id_user', $comment->getIdUsers());
            $req->execute();
        } else {
            $req->bindValue(':publish', 'valid');
            $req->bindValue(':id_blog_post', $comment->getIdBlogPosts());
            $req->bindValue(':id_user', $comment->getIdUsers());
            $req->execute();
        }
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
        $req = $this->getDb()->prepare('UPDATE bpf_comments SET publish=:publish WHERE id=:idComment');
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
        $req = $this->getDb()->prepare('DELETE FROM bpf_comments WHERE id=:idComment');
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
        $req = $this->getDb()->prepare('UPDATE bpf_comments SET publish=:publish WHERE id=:idComment');
        $req->bindValue(':publish', 'refused');
        $req->bindValue(':idComment', $idComment);
        $req->execute();
    }
}
