<?php
/**
 * General application controller
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\AssociateEntity;
use App\Entities\ProjectEntity;
use Core\Controller\BaseController;

class AppController extends BaseController {

    public function notFound() : void {
        header("HTTP/1.0 404 Not Found");
        echo $this->container->get('twig')->render('404.html.twig');
        exit();
    }

    public function methodNotAllowed() : void {
        header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
        echo $this->container->get('twig')->render('405.html.twig');
        exit();
    }

    protected function redirect(string $pathname) : void {
        header('Location: ' . $pathname);
        exit();
    }

    protected function isUserAuth() : bool {
        if (isset($_SESSION['userId']))
            return true;
        return false;
    }

    protected function redirectIfUserAuth(string $pathname) : void {
        if ($this->isUserAuth())
            $this->redirect($pathname);
    }

    protected function redirectIfUserNotAuth(string $pathname) : void {
        if (!$this->isUserAuth())
            $this->redirect($pathname);
    }

    protected function isUserLeaderOf(int $projectId) : bool {
        $project_entity = new ProjectEntity;
        if (is_null($project_entity->leaderOf($this->sessionGet('userId'), $projectId)))
            return false;
        return true;
    }

    protected function isUserAssociatedTo(int $projectId) : bool {
        $associate_entity = new AssociateEntity;
        if (is_null($associate_entity->associateTo($this->sessionGet('userId'), $projectId)))
            return false;
        return true;
    }

    protected function sessionSet(string $key, $value) : void {
        $_SESSION[$key] = $value;
    }

    protected function sessionGet(string $key) {
        return $_SESSION[$key];
    }

}