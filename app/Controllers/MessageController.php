<?php
/**
 * Message controller
 * 
 * @author Hugolin Mariette
 */

namespace App\Controllers;

use App\Entities\MessageEntity;

class MessageController extends AppController {

    public function post(string $message, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');

        $message_entity = new MessageEntity;
        $res = $message_entity->add($projectId, $message, $this->sessionGet('userId'));
        
        $this->redirect('/project/view/' . $projectId);
    }

    public function delete(int $messageId, int $projectId) {
        $this->redirectIfUserNotAuth('/user/login');
        if (!$this->isUserAssociatedTo($projectId))
            $this->redirect('/project/list');
        
        $message_entity = new MessageEntity;
        $message = $message_entity->get($messageId);
        if ($this->isUserLeaderOf($projectId) || 
            $this->sessionGet('userId') == $message['ref_utilisateur'])
                $res = $message_entity->delete($messageId);

        $this->redirect('/project/view/' . $projectId);
    }

}