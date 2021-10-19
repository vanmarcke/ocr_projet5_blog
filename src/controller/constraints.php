<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

/**
 * Constraints, contains and defines the different values of the constraints and error messages
 */
class Constraints extends TwigController
{
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
     * @param string $pseudo contains the pseudo sent by the user
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
     * @param string $pseudo contains the pseudo sent by the user
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
     * @param string $email contains the email sent by the user
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
     * @param string $password contains of the password sent by the user 
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
     * @param string $password contains the pseudo sent by the user
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

    protected function setErrorMessage(string $key, string $message, &$errors)
    {
        $errors[$key] = $message;
    }
}
