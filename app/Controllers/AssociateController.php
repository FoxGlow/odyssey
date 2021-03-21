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
        if(!$this->isUserLeaderOf($projectId))
            $this->redirect('/project/view/' . $projectId);
        
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
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');

        $associate_entity = new AssociateEntity;
        $associate = $associate_entity->associateTo($associateId, $projectId);
        // Verify that leader can't delete himself
        if (!is_null($associate) && $this->isUserLeaderOf($projectId) && $this->sessionGet('userId') != $associate['ref_utilisateur'])
            $associate_entity->delete($associateId, $projectId);
        // Verify user delete himself only
        elseif (!is_null($associate) && !$this->isUserLeaderOf($projectId) && $this->sessionGet('userId') == $associate['ref_utilisateur'])
            $associate_entity->delete($associateId, $projectId);

        $this->redirect('/project/view/' . $projectId);
    }

}