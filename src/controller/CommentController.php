<?php

namespace Projet5\controller;

use Exception;
use Projet5\entity\Comment;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;

/**
 * Managing the insertion of a comment
 */
class CommentController extends SessionController
{
    /**
     * Insert a comment
     *
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     * @param string       $idPost       Contains the id of the post to comment
     *
     * @return array
     */
    public function insertComment(PostModel $postModel, CommentModel $commentModel, string $idPost): array
    {
        // The form is submitted, control
        $contents = (isset($_POST['contentsA'])) ? $_POST['contentsA'] : "";
        $errors = [];

        // Constraints
        $this->checkComment($contents, $errors);

        try {
            // Insert the comment and redirect
            if (empty($errors)) {
                $comment = new Comment();
                $comment
                    ->setContents($contents)
                    ->setIdBlogPosts($idPost)
                    ->setIdUsers($_SESSION['IdConnectedUser']);

                $commentModel->insertComment($comment);

                if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
                    // Message and redirect on post if user
                    $_SESSION['success'] = 'Votre commentaire à été enregistré, 
                    il est en attente de validation par un administrateur';
                    header('location:Article-' . $idPost . '-Page1');
                    exit;
                } else {
                    // Message and redirect on post if admin
                    $_SESSION['success'] = 'Votre commentaire à été ajouté';
                    header('location:Article-' . $idPost . '-Page1');
                    exit;
                }
            } else {
                // Redirect on post with error
                $_SESSION['error'] = $errors['contents'];
                header('location:Article-' . $idPost . '-Page1');
                exit;
            }
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Render Template.
     *
     * @param string $templateName Template name to render
     * @param array  $session      User session
     * @param array  $errors       Error information to display
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    private function render(string $templateName, array $session, array $errors = []): void
    {
        echo $this->twig->render($templateName, ['SESSION' => $session, 'error' => $errors]);
    }
}
