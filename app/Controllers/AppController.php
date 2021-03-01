<?php
/**
 * General application controller
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use Core\Controller\BaseController;

class AppController extends BaseController {

    public function notFound() {
        header("HTTP/1.0 404 Not Found");
        echo $this->container->get('twig')->render('404.html.twig');
    }

    public function methodNotAllowed() {
        header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
        echo $this->container->get('twig')->render('405.html.twig');
    }

    protected function bigBrother() : bool {
        if (isset($_SESSION['userId']))
            return true;
        return false;
    }

    protected function sessionSet(string $key, $value) : void {
        $_SESSION[$key] = $value;
    }

    protected function sessionGet(string $key) : mixed {
        return $_SESSION[$key];
    }

}