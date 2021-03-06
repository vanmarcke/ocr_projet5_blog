<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Constraints, contains and defines the different values of the constraints and errors messages
 */
class Constraints extends TwigController
{
    // ***** Start user constraints *****
    protected const MIN_VALUE_PSEUDO = 3;
    protected const MAX_VALUE_PSEUDO = 20;
    protected const MIN_VALUE_PASSWORD = 8;
    protected const REGEX_ALL_CHARACTERS = '/^[[:print:]]+\z/';
    protected const PSEUDO = 'Le pseudo ';
    protected const PASSWORD = 'Le mot de passe ';
    protected const INVALID = 'n\'est pas renseigné ou invalide';
    protected const USER = 'L\'utilisateur a été ';
    protected const VALID = 'validé';
    protected const SUPPR = 'supprimé';

    /**
     * CheckPseudo
     *
     * @param string $pseudo  Contains the value of the pseudo sent by the user
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function checkPseudo(string $pseudo, array &$errors): void
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $pseudo)) {
            $this->setErrorMessage('pseudo', self::PSEUDO . self::INVALID . '.', $errors);
        }
    }

    /**
     * CheckPseudoSize
     *
     * @param string $pseudo  Contains the value of the pseudo sent by the user
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function checkPseudoSize(string $pseudo, array &$errors): void
    {
        if (strlen($pseudo) < self::MIN_VALUE_PSEUDO || strlen($pseudo) > self::MAX_VALUE_PSEUDO) {
            $this->setErrorMessage('pseudoSize', self::PSEUDO . ' doit faire entre 3 et 20 caractères.', $errors);
        }
    }

    /**
     * CheckEmail
     *
     * @param string $email   Contains the value of email sent by the user
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function checkEmail(string $email, array &$errors): void
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage('email', 'L\'email ' . self::INVALID . '.', $errors);
        }
    }

    /**
     * CheckPassword
     *
     * @param string $password Contains the value of the password sent by the user
     * @param array  &$errors  Error information to display
     *
     * @return void
     */
    protected function checkPassword(string $password, array &$errors): void
    {
        if (!preg_match(self::REGEX_ALL_CHARACTERS, $password) || strlen($password) < self::MIN_VALUE_PASSWORD) {
            $this->setErrorMessage('password', self::PASSWORD . self::INVALID . ' , minimun 8 caractères.', $errors);
        }
    }

    /**
     * CheckConfirmPassword
     *
     * @param string $password         Contains the value of the pseudo sent by the user
     * @param string $confirm_password Contains confirmation of the password sent by the user
     * @param array  &$errors          Error information to display
     *
     * @return void
     */
    protected function checkConfirmPassword(string $password, string $confirm_password, array &$errors): void
    {
        if ($password !== $confirm_password) {
            $this->setErrorMessage('confirm_password', self::PASSWORD .
            ' de confirmation n\'est pas identique.', $errors);
        }
    }
    // ***** End user constraints *****

    // ***** Start post constraints *****
    protected const MIN_VALUE_POST = 1;
    protected const MAX_VALUE_TITLE = 100;
    protected const MAX_VALUE_CHAPO = 300;
    protected const VALUE_POST_VALID = 'valid';
    protected const POST = 'L\'article a été ';

    /**
     * CheckTitle
     *
     * @param string $title   Contains the value of the title sent by the admin
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function checkTitle(string $title, array &$errors): void
    {
        if (strlen($title) < self::MIN_VALUE_POST || strlen($title) > self::MAX_VALUE_TITLE) {
            $this->setErrorMessage('title', 'Le titre n\'est pas renseigné ou invalide. 
            Maximum 100 caractères.', $errors);
        }
    }

    /**
     * CheckChapo
     *
     * @param string $chapo   Contains the value of the chapo sent by the admin
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function checkChapo(string $chapo, array &$errors): void
    {
        if (strlen($chapo) < self::MIN_VALUE_POST || strlen($chapo) > self::MAX_VALUE_CHAPO) {
            $this->setErrorMessage('chapo', 'Le chapô n\'est pas renseigné ou invalide. 
            Maximum 300 caractères', $errors);
        }
    }

    /**
     * CheckContents
     *
     * @param string $contents Contains the value of the content sent by the admin
     * @param array &$errors   Error information to display
     *
     * @return void
     */
    protected function checkContents(string $contents, array &$errors): void
    {
        if (strlen($contents) < self::MIN_VALUE_POST) {
            $this->setErrorMessage('contents', 'Le contenu n\'est pas renseigné ou invalide.', $errors);
        }
    }
    // ***** End post constraints *****

    // ***** Start comment constraints *****
    protected const MIN_VALUE_COMMENT = 1;
    protected const MAX_VALUE_COMMENT = 1000;
    protected const COMM = 'Le commentaire a été ';
    protected const REFU = 'refusé';

    /**
     * CheckComment
     *
     * @param string $contents Contains the comment value sent by the user
     * @param array  &$errors  Error information to display
     *
     * @return void
     */
    protected function checkComment(string $contents, array &$errors): void
    {
        if (strlen($contents) < self::MIN_VALUE_COMMENT || strlen($contents) > self::MAX_VALUE_COMMENT) {
            $this->setErrorMessage('contents', 'Le commentaire n\'est pas renseigné ou invalide. 
            Maximum 1000 caractères.', $errors);
        }
    }
    // ***** End comment constraints *****

    protected const USER_RIGHT_ADMIN = 'admin';
    protected const POST_STATUS_WAITING = 'waiting';
    protected const MESSAGE_VALID_OK = 'L\'article à bien été';

    /**
     * IsAdmin checks if admin is true otherwise returns an error if admin is false
     *
     * @param string $rankUser Contains the value 'admin'
     *
     * @return bool
     */
    protected function isAdmin(string $rankUser): bool
    {
        if ($rankUser === self::USER_RIGHT_ADMIN) {
            return true;
        }
        return false;
    }

    /**
     * SetErrorMessage
     *
     * @param string $key     Contains the reference key of the error
     * @param string $message Contains the error message
     * @param array  &$errors Error information to display
     *
     * @return void
     */
    protected function setErrorMessage(string $key, string $message, array &$errors): void
    {
        $errors[$key] = $message;
    }
}
