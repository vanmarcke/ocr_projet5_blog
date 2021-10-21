<?php

namespace Projet5\controller;

use Projet5\controller\Constraints;

/**
 * Manage login, registration and logout of a user 
 */
class UserController extends Constraints
{
    /**
     * connexion user
     *
     * @param  object $userModel
     * @return void
     */
    public function connexion(object $userModel)
    {
        // The form is not submitted, posting the connexion form
        if (count($_POST) === 0) {
            echo $this->twig->render('connexion.twig', ['SESSION' => $_SESSION]);
            return;
        }
        // unset session for security and inialise $error
        unset($_SESSION['IdConnectedUser']);
        unset($_SESSION['pseudoConnectedUser']);
        unset($_SESSION['rankConnectedUser']);
        $errors = [];

        // control
        $email = (isset($_POST["email"])) ? $_POST["email"] : "";
        $password = (isset($_POST["password"])) ? $_POST["password"] : "";

        // Constraints
        $this->checkEmail($email, $errors);

        $this->checkPassword($password, $errors);

        // load user if control ok
        if (empty($errors)) {
            $userDatas = $userModel->loadByEmail($email);

            // if password ok, load id user in the session and go homepage
            if (password_verify($password, $userDatas['password'])) {
                $_SESSION['IdConnectedUser'] = $userDatas['id'];
                $_SESSION['pseudoConnectedUser'] = $userDatas['pseudo'];
                $_SESSION['rankConnectedUser'] = $userDatas['rank'];
                $_SESSION['success'] = 'Vous êtes connecté';
                if ($_SESSION['rankConnectedUser'] == 'admin') {
                    header('location:Administration');
                    exit;
                }
                header('location:Articles-Page1');
                exit;
                // or create a error message
            } else {
                $this->setErrorMessage('connexion', 'Mot de passe ou email incorrect.', $errors);
            }
        }

        // form information in a table for simplicity with twig
        $form = [
            "email" => $email,
            "password" => $password
        ];

        // display the form with errors and datas form
        $this->render('connexion.twig', $errors, $form, $_SESSION);
    }

    /**
     * register user
     *
     * @param  Object $userModel
     * @return void
     */
    public function register(object $userModel)
    {
        // The form is not submitted, posting the registration form
        if (count($_POST) === 0) {
            $this->render('register.twig');
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

        // form information in a table for simplicity with twig
        $form = [
            "pseudo" => $pseudo,
            "email" => $email,
            "password" => $password,
            "confirm_password" => $confirm_password
        ];

        // if no error, 
        if (empty($errors)) {
            $userDatas = [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $password
            ];
            // regist in database and display connection
            try {
                $userModel->insert($userDatas);
                $_SESSION['success'] = 'Votre compte à été créé, cependant il doit être validé par un administrateur pour pouvoir écrire des commentaires';
                header('location:Connexion');
                exit;
                // or create a new error_sql message
            } catch (\Exception $e) {
                $this->setErrorMessage('sql', 'Le pseudo ou l\'email existe déjà', $errors);
            }
        }
        // display the form with errors and datas form
        $this->render('register.twig', $errors, $form, $_SESSION);
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
        header("Location:Accueil");
        exit;
    }

    /**
     * render Template.
     *
     * @param string $templateName Template name to render
     * @param array $error error information to display
     * @param array $form content of the completed form
     * @param array $session user session
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function render(string $templateName, array $errors = [], array $form = [], array $session = [])
    {
        echo $this->twig->render($templateName, ['error' => $errors, 'form' => $form, 'SESSION' => $session]);
    }
}
