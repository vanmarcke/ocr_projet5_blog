<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Manage login, registration and logout of a user 
 */
class UserController extends TwigController
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
        $error = [];

        // control
        $email = (isset($_POST["email"])) ? $_POST["email"] : "";
        $password = (isset($_POST["password"])) ? $_POST["password"] : "";

        if (!preg_match('/^[[:print:]]+\z/', $email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'L\'adresse email n\'est pas renseigné ou invalide.';
        }

        if (!preg_match('/^[[:print:]]+\z/', $password) || strlen($password) < 8) {
            $error['password'] = 'Le mot de passe n\'est pas renseigné ou invalide , minimun 8 caractères.';
        }

        // load user if control ok
        if (empty($error)) {
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
                header('location:Accueil');
                exit;
                // or create a error message
            } else {
                $error['connexion'] = 'Mot de passe ou email incorrect.';
            }
        }

        // form information in a table for simplicity with twig
        $form = [
            "email" => $email,
            "password" => $password
        ];
        // display the form with errors and datas form        
        echo $this->render('connexion.twig', $error, $form, $_SESSION);
    }

    /**
     * register user
     *
     * @param  mixed $userModel
     * @return void
     */
    public function register($userModel)
    {

        // The form is not submitted, posting the registration form
        if (count($_POST) === 0) {
            echo $this->twig->render('register.twig');
            return;
        }

        // The form is submit, form processing

        $pseudo = (isset($_POST["pseudo"])) ? $_POST["pseudo"] : "";
        $email = (isset($_POST["email"])) ? $_POST["email"] : "";
        $password = (isset($_POST["password"])) ? $_POST["password"] : "";
        $confirm_password = (isset($_POST["confirm_password"])) ? $_POST["confirm_password"] : "";

        if (!preg_match('/^[[:print:]]+\z/', $pseudo)) {
            $error['pseudo'] = 'Le pseudo n\'est pas renseigné ou invalide.';
        }
        if (strlen($pseudo) < 3 || strlen($pseudo) > 20) {
            $error['pseudoSize'] = 'Le pseudo doit faire entre 3 et 20 caractères';
        }
        if (!preg_match('/^[[:print:]]+\z/', $email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'L\'adresse email n\'est pas renseigné ou invalide.';
        }
        if (!preg_match('/^[[:print:]]+\z/', $password) || strlen($password) < 8) {
            $error['password'] = 'Le mot de passe n\'est pas renseigné ou invalide, minimum 8 caractères';
        }
        if ($password !== $confirm_password) {
            $error['confirm_password'] = 'Le mot de passe de confirmation n\'est pas identique.';
        }

        // form information in a table for simplicity with twig
        $form = [
            "pseudo" => $pseudo,
            "email" => $email,
            "password" => $password,
            "confirm_password" => $confirm_password
        ];

        // if no error, 
        if (empty($error)) {
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
                $error['sql'] = 'le pseudo ou l\'email existe déjà';
            }
        }
        // display the form with errors and datas form       
        echo $this->render('register.twig', $error, $form, $_SESSION);
    }

    /**
     * deconnexion user
     *
     * @return void
     */
    public function deconnexion()
    {
        unset($_SESSION['IdConnectedUser']);
        $_SESSION = [];
        $_SESSION['success'] = 'Vous êtes déconnecté';
        header("Location:Accueil");
        exit;
    }

    /**
     * render shortcut for controllers.
     *
     * @param  string $templateName
     * @param  array $error
     * @param  array $form
     * @param  array $session
     * @return void
     */
    private function render(string $templateName, array $error, array $form, array $session)
    {
        $this->twig->render($templateName, ['error' => $error, 'form' => $form, 'SESSION' => $session]);
    }
}
