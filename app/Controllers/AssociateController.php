<?php
/**
 * Associate controller
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\AssociateEntity;
use App\Entities\UserEntity;

class AssociateController extends AppController {

    public function add(string $mail_address, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        $user_entity = new UserEntity;
        $userId = $user_entity->exists($mail_address);
        if (!is_null($userId)) {
            $associate_entity = new AssociateEntity;
            $associate_entity->add($userId['id_utilisateur'], $projectId);
        }
        $this->redirect('/project/view/' . $projectId);
    }

    public function delete(int $associateId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');

        $associate_entity = new AssociateEntity;
        $res = $associate_entity->delete($associateId, $projectId);

        $this->redirect('/project/view' . $projectId);
    }

}