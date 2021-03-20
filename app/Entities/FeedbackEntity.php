<?php
/**
 * Feedback entity
 * 
 * @author Hugolin Mariette
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class FeedbackEntity extends BaseEntity {

    private $types = ['flow', 'activity'];

    public function add(string $type, string $message, int $coverage, int $projectId) {
        if (!in_array($type, $this->types)) return null;
        $request = "INSERT INTO feedback(type, message, taux_de_couverture, ref_projet) 
                VALUES(:type, :message, :coverage, :projectId)";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':coverage', $coverage);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function getForProject($projectId) {
        $request = 'SELECT type, message, taux_de_couverture FROM feedback
                WHERE ref_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;
    }

    public function delete(string $type, int $projectId) {
        if (!in_array($type, $this->types)) return null;
        $request = "DELETE FROM feedback WHERE type = :type AND ref_projet = :projectId";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function exist(string $type, int $projectId) {
        if (!in_array($type, $this->types)) return null;
        $request = "SELECT id_feedback FROM feedback
                WHERE type = :type AND ref_projet = :projectId";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

}
