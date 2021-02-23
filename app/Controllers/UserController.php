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
        $user_entity = new UserEntity;
        $res = $user_entity->login($mail_address, $password);
        if (!is_null($res)) {
            
        }
        else {
            // TODO
        }
    }

    public function register() {
        echo $this->container->get('twig')->render('/pages/register.html.twig');
    }

    public function create(string $mail_address, string $firstname, string $lastname, string $password, string $password_confirm) {
        $user_entity = new UserEntity;
        $res = $user_entity->register($firstname, $lastname, $mail_address, $password);
    }

}