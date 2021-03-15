<?php
/**
 * Message entity
 * 
 * @author Hugolin Mariette, Abdelnor Ait Ali, Yuxuan Sun
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class MessageEntity extends BaseEntity {

    public function add(int $projectId, string $message, int $userId) {
        $request = 'INSERT INTO message(texte, date_, ref_utilisateur, ref_projet)
            VALUES(:message, NOW(), :userId, :projectId)';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function delete(int $messageId) {
        $request = 'DELETE FROM message WHERE message.id_message = :messageId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':messageId', $messageId);
        $res = $stmt->execute();
        return $res;
    }

    public function getForProject(int $projectId) {
        $request = 'SELECT message.id_message, message.texte, message.date_,
            utilisateur.id_utilisateur, utilisateur.nom, utilisateur.prenom
            FROM message
            JOIN utilisateur ON utilisateur.id_utilisateur = message.ref_utilisateur
            WHERE message.ref_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if (!$res) return null;
        return $res;
    }

}