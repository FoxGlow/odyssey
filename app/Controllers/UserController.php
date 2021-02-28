<?php
/**
 * Controller for user pages/action
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\UserEntity;
use Core\Controller\BaseController;

class UserController extends BaseController {

    public function login() {
        echo $this->container->get('twig')->render('/pages/login.html.twig');
    }

    public function authenticate(string $mail_address, string $password) {
        if (strlen($mail_address) == 0 || strlen($password) == 0) {
            echo $this->container->get('twig')->render('/pages/login.html.twig', [
                'error' => "Au moins l'un des champs est vide."
            ]);
        }
        else {
            $user_entity = new UserEntity;
            $res = $user_entity->login($mail_address, $password);
            if (!is_null($res)) {
                // TODO
            }
            else {
                echo $this->container->get('twig')->render('/pages/login.html.twig', [
                    'error' => "L'adresse mail ou le mot de passe est incorrect."
                ]); 
            }
        }
    }

    public function register() {
        echo $this->container->get('twig')->render('/pages/register.html.twig');
    }

    public function create(string $mail_address, string $firstname, string $lastname, string $password, string $password_confirm) {
        if (!filter_var($mail_address, FILTER_VALIDATE_EMAIL)) {
            echo $this->container->get('twig')->render('/pages/register.html.twig', [
                'error' => "L'adresse mail est invalide."
            ]);
        }
        elseif (strlen($mail_address) == 0 || strlen($firstname) == 0 || strlen($lastname) == 0 || strlen($password) == 0 || strlen($password_confirm) == 0) {
            echo $this->container->get('twig')->render('/pages/register.html.twig', [
                'error' => "Au moins l'un des champs est vide."
            ]);
        }
        elseif ($password !== $password_confirm) {
            echo $this->container->get('twig')->render('/pages/register.html.twig', [
                'error' => "L'un des mots de passe ne correspond pas."
            ]);
        }
        else {
            $user_entity = new UserEntity;
            $res = $user_entity->register($firstname, $lastname, $mail_address, $password);
            // TODO
        }
    }

}