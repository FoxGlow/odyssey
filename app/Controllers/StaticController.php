<?php
/**
 * Controller for static pages
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use Core\Controller\BaseController;

class StaticController extends BaseController {

    public function home() {
        echo $this->container->get('twig')->render('/pages/home.html.twig');
    }

    public function gettingStarted() {
        // TODO
    }

    public function credits() {
        // TODO
    }

}