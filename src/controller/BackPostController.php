<?php

namespace Projet5\controller;

use Exception;
use Projet5\entity\Post;
use Projet5\model\PostModel;

/**
 * Manage postings, updates and deletions
 */
class BackPostController extends SessionController
{
    /**
     * Add a new post
     *
     * @param PostModel $postModel Read, insert, update and delete of posts
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     *
     * @return void
     */
    public function addPost(PostModel $postModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        // The form is not submitted, posting the post form
        if (count($_POST) === 0) {
            $this->render('insert_post.twig', $_SESSION);
            return;
        }

        // The form is submitted, control
        $title = (isset($_POST['titleA'])) ? $_POST['titleA'] : "";
        $chapo = (isset($_POST['chapoB'])) ? $_POST['chapoB'] : "";
        $contents = (isset($_POST['contents'])) ? $_POST['contents'] : "";
        $id_user = (isset($_SESSION['IdConnectedUser'])) ? $_SESSION['IdConnectedUser'] : "";
        $errors = [];

        // Constraints
        $this->checkTitle($title, $errors);

        $this->checkChapo($chapo, $errors);

        $this->checkContents($contents, $errors);

        // Form information in a table for simplicity with twig
        $form = [
            'title' => $title,
            'chapo' => $chapo,
            'contents' => $contents,
            'id_user' => $id_user
        ];

        try {
            // Insert post if control ok
            if (empty($errors)) {
                $post = new Post();
                $post
                    ->setTitle($title)
                    ->setChapo($chapo)
                    ->setContents($contents)
                    ->setPublish('waiting')
                    ->setUser($id_user);

                $postModel->insertPost($post);
                $_SESSION['success'] = self::MESSAGE_VALID_OK . ' envoyé, il est maintenant en attente de validation.';
                header('location:admin-waiting-posts');
                exit;
            }
            // Display the form with errors and datas form
            $this->render('insert_post.twig', $_SESSION, $errors, $form);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Modification of a post
     *
     * @param int       $idPost    Contains post id
     * @param PostModel $postModel Read, insert, update and delete of posts
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     *
     * @return void
     */
    public function editPost(int $idPost, PostModel $postModel): void
    {
        // Load Post with id
        $post = $postModel->loadPost($idPost);

        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        // The form is not submitted, posting the post form
        if (count($_POST) === 0) {
            $this->render('insert_post.twig', $_SESSION, [], [], $post);
            return;
        }

        // The form is submitted, control
        $title = (isset($_POST['titleA'])) ? $_POST['titleA'] : "";
        $chapo = (isset($_POST['chapoB'])) ? $_POST['chapoB'] : "";
        $contents = (isset($_POST['contents'])) ? $_POST['contents'] : "";
        $id_user = (isset($_SESSION['IdConnectedUser'])) ? $_SESSION['IdConnectedUser'] : "";
        $errors = [];

        // Constraints
        $this->checkTitle($title, $errors);

        $this->checkChapo($chapo, $errors);

        $this->checkContents($contents, $errors);

        // Form information in a table for simplicity with twig
        $form = [
            'title' => $title,
            'chapo' => $chapo,
            'contents' => $contents,
            'id_user' => $id_user,
            'id_post' => $idPost
        ];

        try {
            // Insert post if control ok
            if (empty($errors)) {
                $post = new Post();
                $post
                    ->setTitle($title)
                    ->setChapo($chapo)
                    ->setContents($contents)
                    ->setUser($id_user);

                $postModel->updatePost($idPost, $post);
                $_SESSION['success'] = self::MESSAGE_VALID_OK . ' mis à jour';
                header('location:Article-page1');
                exit;
            }
            // Display the post with error and datas form
            $this->render('insert_post.twig', $_SESSION, $errors, $form);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Delete a post
     *
     * @param string    $idPost    Contains post id
     * @param PostModel $postModel Read, insert, update and delete of posts
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     *
     * @return void
     */
    public function deletePost(string $idPost, PostModel $postModel): void
    {
        // Load Post with id
        $post = $postModel->loadPost($idPost);

        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Not delete post if form is cancel and redirect
            if (isset($_POST['cancel'])) {
                header('location:Article-page1');
                exit;
            }

            // Delete post if form is submit and redirect
            if (isset($_POST['idDeletePost'])) {
                $postModel->deletePostWithId($_POST['idDeletePost']);
                $_SESSION['success'] = self::MESSAGE_VALID_OK . ' supprimé';
                header('location:Articles-Page1');
                exit;
            }

            // Display the confirm delete message
            $this->render('delete_post.twig', $_SESSION, [], [], $post);
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
     * @param array  $form         Content of the completed form
     * @param array  $post         Contains the post data
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    private function render(
        string $templateName,
        array $session,
        array $errors = [],
        array $form = [],
        $post = []
    ): void {
        echo $this->twig->render(
            $templateName,
            ['SESSION' => $session,
            'error' => $errors,
            'form' => $form,
            'post' => $post]
        );
    }
}
