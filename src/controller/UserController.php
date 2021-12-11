<?php

namespace Projet5\controller;

use Exception;
use Projet5\controller\Constraints;
use Projet5\entity\User;
use Projet5\model\UserModel;

/**
 * Manage login, registration and logout of a user 
 */
class UserController extends Constraints
{
    /**
     * Connexion user
     *
     * @param UserModel $userModel Read, insert, update and delete users
     * 
     * @return void
     */
    public function connexion(UserModel $userModel)
    {
        // The form is not submitted, posting the connexion form
        if (count($_POST) === 0) {
            $this->render('connexion.twig', $_SESSION);
            return;
        }
        // Unset session for security and initialise $error
        unset($_SESSION['IdConnectedUser']);
        unset($_SESSION['pseudoConnectedUser']);
        unset($_SESSION['rankConnectedUser']);
        $errors = [];

        // Control
        $email = (isset($_POST["email"])) ? $_POST["email"] : "";
        $password = (isset($_POST["password"])) ? $_POST["password"] : "";

        // Constraints
        $this->checkEmail($email, $errors);

        $this->checkPassword($password, $errors);

        try {
            // Load user if control ok
            if (empty($errors)) {
                $userDatas = $userModel->loadByEmail($email);

                // If password ok, load id user in the session and go homepage blog
                if (password_verify($password, $userDatas['password'])) {
                    $_SESSION['IdConnectedUser'] = $userDatas['id'];
                    $_SESSION['pseudoConnectedUser'] = $userDatas['pseudo'];
                    $_SESSION['rankConnectedUser'] = $userDatas['rank'];
                    $_SESSION['success'] = 'Hello ' . $_SESSION['pseudoConnectedUser'] . ', vous êtes connecté';
                    if ($_SESSION['rankConnectedUser'] == 'admin') {
                        header('location:Administration');
                        exit;
                    }
                    header('location:Articles-Page1');
                    exit;
                    // Or create a error message
                } else {
                    $this->setErrorMessage('connexion', 'Mot de passe ou email incorrect.', $errors);
                }
            }
            // Form information in a table for simplicity with twig
            $form = [
                "email" => $email,
                "password" => $password
            ];

            // Display the form with errors and datas form
            $this->render('connexion.twig', $_SESSION, $errors, $form);
        } catch (Exception $e) {
            $this->render('error_500.twig', $_SESSION, []);
        }
    }

    /**
     * Register user
     *
     * @param UserModel $userModel Read, insert, update and delete users
     * 
     * @return void
     */
    public function register(UserModel $userModel)
    {
        // The form is not submitted, posting the registration form
        if (count($_POST) === 0) {
            $this->render('register.twig', $_SESSION);
            return;
        }

        // The form is submit, form processing
        $pseudo = (isset($_POST["pseudo"])) ? $_POST["pseudo"] : "";
        $email = (isset($_POST["email"])) ? $_POST["email"] : "";
        $password = (isset($_POST["password"])) ? $_POST["password"] : "";
        $confirm_password = (isset($_POST["confirm_password"])) ? $_POST["confirm_password"] : "";
        $errors = [];

        // Constraints
        $this->checkPseudo($pseudo, $errors);

        $this->checkPseudoSize($pseudo, $errors);

        $this->checkEmail($email, $errors);

        $this->checkPassword($password, $errors);

        $this->checkConfirmPassword($password, $confirm_password, $errors);

        // Form information in a table for simplicity with twig
        $form = [
            "pseudo" => $pseudo,
            "email" => $email,
            "password" => $password,
            "confirm_password" => $confirm_password
        ];

        // If no error, 
        if (empty($errors)) {
            $user = new User();
            $user
                ->setPseudo($pseudo)
                ->setEmail($email)
                ->setPassword($password)
                ->setRank('pending');

            try {
                // Save to database and display connection
                $userModel->insert($user);
                $_SESSION['success'] = 'Votre compte à été créé, cependant il doit être validé par un administrateur pour pouvoir écrire des commentaires';
                $this->render('connexion.twig', $_SESSION, $errors, $form);
                return;
                // Or create a new error_sql message
            } catch (Exception $e) {
                $this->setErrorMessage('sql', 'Le pseudo ou l\'email existe déjà', $errors);
            }
        }
        // Display the form with errors and datas form
        $this->render('register.twig', $_SESSION, $errors, $form);
    }

    /**
     * Disconnect user
     *
     * @return void
     */
    public function disconnect()
    {
        $_SESSION = [];
        $_SESSION['success'] = 'Vous êtes déconnecté';
        $this->render('homepage.twig', $_SESSION);
        return;
    }

    /**
     * Render Template.
     *
     * @param string $templateName Template name to render
     * @param array $error error information to display
     * @param array $form content of the completed form
     * @param array $session user session
     * 
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * 
     * @return void
     */
    private function render(string $templateName, array $session, array $errors = [], array $form = [])
    {
        echo $this->twig->render($templateName, ['SESSION' => $session, 'error' => $errors, 'form' => $form]);
    }
}
