<?php
/**
 * Controller for user pages/action
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use Core\Controller\BaseController;

class UserController extends BaseController {

    public function login() {
        echo $this->container->get('twig')->render('/pages/login.html.twig');
    }

    public function authenticate() {
        // TODO
    }

    public function register() {
        echo $this->container->get('twig')->render('/pages/register.html.twig');
    }

    public function create() {
        //TODO
    }

}