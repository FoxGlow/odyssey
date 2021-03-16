<?php
/**
 * Advice entity
 * 
 * @author Hugolin Mariette
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class AdviceEntity extends BaseEntity {

    public function getRandomAdvice() {
        $request = 'SELECT * FROM conseil
            ORDER BY RAND() LIMIT 1';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->execute();
        $res = $stmt->fetch();
        if (!$res) return null;
        return $res;
    }

}