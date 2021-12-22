<?php

namespace Projet5\controller;

use Exception;
use Projet5\model\UserModel;

/**
 * Set the page to display first
 */
class HomepageController extends Constraints
{
    /**
     * Get Homepage
     *
     * @param UserModel $userModel Read, insert, update and delete users
     *
     * @return void
     */
    public function index(UserModel $userModel): void
    {
        try {
            // load user datas if is connected
            if (isset($_SESSION['IdConnectedUser'])) {
                $userModel->loadUser($_SESSION['IdConnectedUser']);
            }
            // The form is not submitted, display the homepage
            if (count($_POST) === 0) {
                $this->render('homepage.twig', $_SESSION);
            }
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Get error404
     *
     * @return void
     */
    public function error404(): void
    {
        $this->render('error_404.twig', $_SESSION);
    }

    /**
     * Get error500
     *
     * @return void
     */
    public function error500(): void
    {
        $this->render('error_500.twig', $_SESSION);
    }


    /**
     * Render Template
     *
     * @param string $templateName Template name to render
     * @param array  $session      User session
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    private function render(string $templateName, array $session): void
    {
        echo $this->twig->render($templateName, ['SESSION' => $session]);
    }
}
