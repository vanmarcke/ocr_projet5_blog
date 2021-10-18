<?php

namespace Projet5\controller;

use Projet5\controller\TwigController;

class Constraints extends TwigController
{
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
        if (!preg_match('/^[[:print:]]+\z/', $pseudo)) {
            $errors['pseudo'] = 'Le pseudo n\'est pas renseigné ou invalide.';
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
        if (strlen($pseudo) < 3 || strlen($pseudo) > 20) {
            $errors['pseudoSize'] = 'Le pseudo doit faire entre 3 et 20 caractères';
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
        if (!preg_match('/^[[:print:]]+\z/', $email) && false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'L\'adresse email n\'est pas renseigné ou invalide.';
        }
    }

    /**
     * checkPassword
     *
     * @param string $password contains of the password sent by the user 
     * @param array &$errors error information to display
     *
     * @return array return array with error message 
     */
    protected function checkPassword(string $password, &$errors)
    {
        if (!preg_match('/^[[:print:]]+\z/', $password) || strlen($password) < 8) {
            $errors['password'] = 'Le mot de passe n\'est pas renseigné ou invalide , minimun 8 caractères.';
        }
    }

    /**
     * checkConfirmPassword
     *
     * @param string $password contains the pseudo sent by the user
     * @param string $confirm_password contains confirmation of the password sent by the user 
     * @param array &$errors error information to display
     *
     * @return array return array with error message
     */
    protected function checkConfirmPassword(string $password, $confirm_password, &$errors)
    {
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Le mot de passe de confirmation n\'est pas identique.';
        }
    }
}
