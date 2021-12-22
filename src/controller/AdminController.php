<?php

namespace Projet5\controller;

use Exception;
use Projet5\model\CommentModel;
use Projet5\model\PostModel;
use Projet5\model\UserModel;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Management of validations by admin
 */
class AdminController extends SessionController
{
    /**
     * Retrieve information awaiting validation by admin
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function displayAllElements(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Controle if a POST variable exist and execute
            $this->controleForms($userModel, $postModel, $commentModel);

            // Load pending users
            $pendingUsers = $userModel->loadPendingUsers();
            // Load invalid posts
            $invalidPosts = $postModel->loadAllPost($valid = self::POST_STATUS_WAITING);
            // Load invalid comments
            $invalidComments = $commentModel->loadInvalidComments();
            // Load the refused comments
            $refuseComments = $commentModel->loadRefuseComments();

            // Display
            $this->render(
                'admin.twig',
                $_SESSION,
                [],
                $pendingUsers,
                $invalidPosts,
                $invalidComments,
                $refuseComments
            );
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Retrieve posts pending administrator validation
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function displayWaitingPosts(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Controle if a POST variable exist and execute
            $this->controleForms($userModel, $postModel, $commentModel);

            // Load invalid posts
            $invalidPosts = $postModel->loadAllPost($valid = self::POST_STATUS_WAITING);

            // Display
            $this->render('admin_waiting_posts.twig', $_SESSION, [], [], $invalidPosts, [], []);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Retrieve users awaiting validation by the admin
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function displayPendingUsers(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Controle if a POST variable exist and execute
            $this->controleForms($userModel, $postModel, $commentModel);

            // Load pending users
            $pendingUsers = $userModel->loadPendingUsers();

            // Display
            $this->render('admin_pending_users.twig', $_SESSION, [], $pendingUsers, [], [], []);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Retrieve information awaiting validation by admin
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function displayInvalidComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Controle if a POST variable exist and execute
            $this->controleForms($userModel, $postModel, $commentModel);

            // Load invalid comments
            $invalidComments = $commentModel->loadInvalidComments();

            // Display
            $this->render('admin_waiting_comments.twig', $_SESSION, [], [], [], $invalidComments, []);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Retrieve information awaiting validation by admin
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function displayRefusedComments(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        // If I do not follow admin, return to the home page
        if (!$this->isAdmin($_SESSION['rankConnectedUser'])) {
            $this->render('error_404.twig', $_SESSION);
            return;
        }

        try {
            // Controle if a POST variable exist and execute
            $this->controleForms($userModel, $postModel, $commentModel);

            // Load the refused comments
            $refuseComments = $commentModel->loadRefuseComments();

            // Display
            $this->render('admin_refused_comments.twig', $_SESSION, [], [], [], [], $refuseComments);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Allows the validation or deletion of elements awaiting validation
     *
     * @param UserModel    $userModel    Read, insert, update and delete users
     * @param PostModel    $postModel    Read, insert, update and delete of posts
     * @param CommentModel $commentModel Read, insert, update and delete comments
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    private function controleForms(UserModel $userModel, PostModel $postModel, CommentModel $commentModel): void
    {
        switch (true) {
                // Valid user if form is submit
            case (isset($_POST['idValidateUser'])): {
                    $userModel->validateUserWithId($_POST['idValidateUser']);
                    $_SESSION['success'] = self::USER . self::VALID;
                    break;
            }

                // Delete user if form is submit
            case (isset($_POST['idDeleteUser'])): {
                    $userModel->deleteUserWithId($_POST['idDeleteUser']);
                    $_SESSION['success'] = self::USER . self::SUPPR;
                    break;
            }

                // Valid post if form is submit
            case (isset($_POST['idPublishPost'])): {
                    $postModel->publishPostWithId($_POST['idPublishPost']);
                    $_SESSION['success'] = self::POST . self::VALID;
                    break;
            }

                // Delete post if form is submit
            case (isset($_POST['idDeletePost'])): {
                    $postModel->deletePostWithId($_POST['idDeletePost']);
                    $_SESSION['success'] = self::POST . self::SUPPR;
                    break;
            }

                // Valid comment if form is submit
            case (isset($_POST['idPublishComment'])): {
                    $commentModel->publishCommentWithId($_POST['idPublishComment']);
                    $_SESSION['success'] = self::COMM . self::VALID;
                    break;
            }

                // Delete comment if form is submit
            case (isset($_POST['idDeleteComment'])): {
                    $commentModel->deleteCommentWithId($_POST['idDeleteComment']);
                    $_SESSION['success'] = self::COMM . self::SUPPR;
                    break;
            }

                // Refuse comment if form is submit
            case (isset($_POST['idRefuseComment'])): {
                    $commentModel->refuseCommentWithId($_POST['idRefuseComment']);
                    $_SESSION['success'] = self::COMM . self::REFU;
                    break;
            }
        }
    }

    /**
     * Render Template.
     *
     * @param string $templateName    Template name to render
     * @param array  $session         User session
     * @param array  $errors          Error information to display
     * @param array  $pendingUsers    Return pending user
     * @param array  $invalidPosts    Return pending post
     * @param array  $invalidComments Return invalid comment
     * @param array  $refuseComments  Return comment refused
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
        array $pendingUsers = [],
        array $invalidPosts = [],
        array $invalidComments = [],
        array $refuseComments = []
    ): void {
        echo $this->twig->render($templateName, [
            'SESSION'         => $session,
            'error'           => $errors,
            'pendingUsers'    => $pendingUsers,
            'invalidPosts'    => $invalidPosts,
            'invalidComments' => $invalidComments,
            'refuseComments'  => $refuseComments
        ]);
    }
}
