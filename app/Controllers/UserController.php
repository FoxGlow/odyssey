<?php
/**
 * Controller for user pages/actions
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\UserEntity;

class UserController extends AppController {

    public function login() {
        $this->redirectIfUserAuth('/');
        echo $this->container->get('twig')->render('/pages/login.html.twig');
    }

    public function authenticate(string $mail_address, string $password) {
        $this->redirectIfUserAuth('/');

        // At least one field is empty
        if (strlen($mail_address) == 0 || strlen($password) == 0) { 
            echo $this->container->get('twig')->render('/pages/login.html.twig', [
                'error' => "Au moins l'un des champs est vide."
            ]);
        }
        // All fields are filled
        else {
            $user_entity = new UserEntity;
            $res = $user_entity->login($mail_address, $password);
            // Mail address and password are correct
            if (!is_null($res)) {
                $this->sessionSet('userId', $res['id_utilisateur']);
                $this->sessionSet('mail', $res['mail']);
                $this->sessionSet('lastname', $res['nom']);
                $this->sessionSet('firstname', $res['prenom']);
                $this->redirect('/project/list');
            }
            // Incorrect mail address and/or password
            else {
                echo $this->container->get('twig')->render('/pages/login.html.twig', [
                    'error' => "L'adresse mail ou le mot de passe est incorrect."
                ]); 
            }
        }
    }

    public function register() {
        $this->redirectIfUserAuth('/');
        echo $this->container->get('twig')->render('/pages/register/register.html.twig');
    }

    public function create(string $mail_address, string $firstname, string $lastname, string $password, string $password_confirm) {
        $this->redirectIfUserAuth('/');

        // Invalid mail address
        if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
            echo $this->container->get('twig')->render('/pages/register/register.html.twig', [
                'error' => "L'adresse mail est invalide."
            ]);
        }
        // At least one field is empty
        elseif (strlen($mail_address) == 0 || strlen($firstname) == 0 || strlen($lastname) == 0 || strlen($password) == 0 || strlen($password_confirm) == 0) {
            echo $this->container->get('twig')->render('/pages/register/register.html.twig', [
                'error' => "Au moins l'un des champs est vide."
            ]);
        }
        // The password and it's confirmation are not the same
        elseif ($password !== $password_confirm) {
            echo $this->container->get('twig')->render('/pages/register/register.html.twig', [
                'error' => "L'un des mots de passe ne correspond pas."
            ]);
        }
        // Everything is okay
        else {
            $user_entity = new UserEntity;
            $res = $user_entity->register($firstname, $lastname, $mail_address, $password);
            echo $this->container->get('twig')->render('/pages/register/success.html.twig');
        }
    }

    public function logout() {
        $this->redirectIfUserNotAuth('/user/login');
        session_destroy();
        $this->redirect('/');
    }

}