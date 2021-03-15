<?php
/**
 * Controller for static pages
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

class StaticController extends AppController {

    public function home() {
        echo $this->container->get('twig')->render('/pages/home.html.twig');
    }

    public function gettingStarted() {
        echo $this->container->get('twig')->render('/pages/getting-started.html.twig');
    }

    public function credits() {
        echo $this->container->get('twig')->render('/pages/credits.html.twig');
    }

}