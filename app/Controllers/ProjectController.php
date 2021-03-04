<?php
/**
 * Controller for project pages/actions
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\AssociateEntity;
use App\Entities\ProjectEntity;

class ProjectController extends AppController {

    public function new() {
        $this->redirectIfUserNotAuth('/user/login');
        echo $this->container->get('twig')->render('/pages/project/new.html.twig');
    }

    public function create(string $name, string $description) {
        $this->redirectIfUserNotAuth('/user/login');

        // At least one field is empty
        if (strlen($name) == 0 || strlen($description) == 0) {
            echo $this->container->get('twig')->render('/pages/project/new.html.twig', [
                'error' => "Au moins l'un des champs est vide."
            ]);
        }
        // Everything is okay
        else {
            $project_entity = new ProjectEntity;
            $projectId = $project_entity->create($name, $description, $this->sessionGet('userId'));

            $associate_entity = new AssociateEntity;
            $res = $associate_entity->add($this->sessionGet('userId'), $projectId);
            
            echo $this->container->get('twig')->render('/pages/project/success-create.html.twig');
        }
    }

    public function list() {
        $this->redirectIfUserNotAuth('/user/login');
        $project_entity = new ProjectEntity;
        $projects = $project_entity->list($this->sessionGet('userId'));
        echo $this->container->get('twig')->render('/pages/project/list.html.twig', [
            'projects' => $projects
        ]);
    }

    public function view(int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        
        // TO DO : vérifier si l'utilisateur est associé à ce projet ou non
        $project_entity = new ProjectEntity;
        $associate_entity = new AssociateEntity;
        $project = $project_entity->get($projectId);
        //$associates = $associate_entity->getForProject($projectId);
        echo $this->container->get('twig')->render('/pages/project/view.html.twig', [
            'project' => $project,
            'associates' => null // TO CHANGE
        ]);
    }

    public function delete(int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        // TO DO
    }

}