<?php
/**
 * Associate entity
 * 
 * @author Hugolin Mariette, Abdelnor Ait Ali, Yuxuan Sun
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class AssociateEntity extends BaseEntity {

    public function add(int $userId, int $projectId) {
        $request = 'INSERT INTO associe(ref_utilisateur, ref_projet)
            VALUES (:userId, :projectId)';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function remove() {
        // TO DO
    }

}