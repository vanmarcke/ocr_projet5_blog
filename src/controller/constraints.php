<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Constraints, contains and defines the different values of the constraints and error messages
 */
class Constraints extends TwigController
{
    // ***** start user constraints *****
    const MIN_VALUE_PSEUDO = 3;
    const MAX_VALUE_PSEUDO = 20;
    const MIN_VALUE_PASSWORD = 8;
    const REGEX_ALL_CHARACTERS = '/^[[:print:]]+\z/';
    const PSEUDO = 'Le pseudo ';
    const PASSWORD = 'Le mot de passe ';
    const INVALID = 'n\'est pas renseigné ou invalide';

    /**
     * checkPseudo
     *
     * @param string $pseudo contains the value of the pseudo sent by the user
     * @param array &$errors error information to display
     *
     * @return array return array with error message
     */
    protected function checkPseudo(string $pseudo, &$errors)
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $pseudo)) {
            $this->setErrorMessage('pseudo', self::PSEUDO . self::INVALID . '.', $errors);
        }
    }

    /**
     * checkPseudoSize
     *
     * @param string $pseudo contains the value of the pseudo sent by the user
     * @param array &$errors error information to display
     *
     * @return array return array with error message
     */
    protected function checkPseudoSize(string $pseudo, &$errors)
    {
        if (strlen($pseudo) < self::MIN_VALUE_PSEUDO || strlen($pseudo) > self::MAX_VALUE_PSEUDO) {
            $this->setErrorMessage('pseudoSize', self::PSEUDO . ' doit faire entre 3 et 20 caractères.', $errors);
        }
    }

    /**
     * checkEmail
     *
     * @param string $email contains the value of email sent by the user
     * @param array &$errors error information to display
     *
     * @return array return array with error message
     */
    protected function checkEmail(string $email, &$errors)
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage('email', 'L\'email ' . self::INVALID . '.', $errors);
        }
    }

    /**
     * checkPassword
     *
     * @param string $password contains the value of the password sent by the user 
     * @param array &$errors error information to display
     *
     */
    protected function checkPassword(string $password, &$errors)
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $password) || strlen($password) < self::MIN_VALUE_PASSWORD) {
            $this->setErrorMessage('password', self::PASSWORD . self::INVALID . ' , minimun 8 caractères.', $errors);
        }
    }

    /**
     * checkConfirmPassword
     *
     * @param string $password contains the value of the pseudo sent by the user
     * @param string $confirm_password contains confirmation of the password sent by the user 
     * @param array &$errors error information to display
     *
     */
    protected function checkConfirmPassword(string $password, $confirm_password, &$errors)
    {
        if ($password !== $confirm_password) {
            $this->setErrorMessage('confirm_password', self::PASSWORD . ' de confirmation n\'est pas identique.', $errors);
        }
    }
    // ***** end user constraints *****

    // ***** start post constraints *****
    const MIN_VALUE_POST = 1;
    const MAX_VALUE_TITLE = 100;
    const MAX_VALUE_CHAPO = 300;

    /**
     * checkTitle
     *
     * @param string $title contains the avlue of the title sent by the admin 
     * @param &$errors error information to display
     *
     * @return void
     */
    protected function checkTitle(string $title, &$errors)
    {
        if (strlen($title) < self::MIN_VALUE_POST || strlen($title) > self::MAX_VALUE_TITLE ) {
            $this->setErrorMessage('title', 'Le titre n\'est pas renseigné ou invalide. Maximum 100 caractères.', $errors);
        }
    }

    /**
     * checkChapo
     *
     * @param string $chapo contains the value of the chapo sent by the admin
     * @param &$errors error information to display
     *
     * @return void
     */
    protected function checkChapo(string $chapo, &$errors)
    {
        if (strlen($chapo) < self::MIN_VALUE_POST || strlen($chapo) > self::MAX_VALUE_CHAPO ) {
            $this->setErrorMessage('chapo', 'Le chapô n\'est pas renseigné ou invalide. Maximum 300 caractères', $errors);
        }
    }

    /**
     * checkContents
     *
     * @param string $contents contains the value of the content sent by the admin
     * @param &$errors errors information to display
     *
     * @return void
     */
    protected function checkContents(string $contents, &$errors)
    {
        if (strlen($contents) < self::MIN_VALUE_POST ) {
            $this->setErrorMessage('contents', 'Le contenu n\'est pas renseigné ou invalide.', $errors);
        }
    }
    // ***** end post constraints *****

    // ***** start comment constraints *****
    const MIN_VALUE_COMMENT = 1;
    const MAX_VALUE_COMMENT = 1000;
    
    /**
     * checkComment
     *
     * @param string $contents contains the comment value sent by the user
     * @param &$errors $errors information to display
     *
     * @return void
     */
    protected function checkComment(string $contents, &$errors)
    {
        if (strlen($contents) < self::MIN_VALUE_COMMENT || strlen($contents) > self::MAX_VALUE_COMMENT ) {
			$this->setErrorMessage('contents', 'Le commentaire n\'est pas renseigné ou invalide. Maximum 1000 caractères.', $errors);
		}
    }
    // ***** end comment constraints *****

    const USER_RIGHT_ADMIN = 'admin';
    const POST_STATUS_WAITING = 'waiting';
    const MESSAGE_NO_ADMIN = 'Cette page est réservé à l\'administrateur';
    
    /**
     * redirectNoAdmin redirect to blog page if user is not admin 
     *
     * @return string error message
     */
    protected function redirectNoAdmin()
    {        
        // If I do not follow admin, return to the article page 
		if ($_SESSION['rankConnectedUser'] !== self::USER_RIGHT_ADMIN) {
			$_SESSION['error'] = self::MESSAGE_NO_ADMIN;
			header('location:Articles-Page1');
			exit;
		}
    }

    /**
     * setErrorMessage
     *
     * @param string $key contains the reference key of the error
     * @param string $message contains the error message
     * @param &$errors $errors 
     *
     * @return array
     */
    protected function setErrorMessage(string $key, string $message, &$errors)
    {
        $errors[$key] = $message;
    }
}
