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

    public function delete(int $associateId, int $projectId) {
        $request = 'DELETE FROM associe 
            WHERE associe.ref_utilisateur = :associateId AND associe.ref_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':associateId', $associateId);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function getForProject(int $projectId) {
        $request = 'SELECT associe.ref_utilisateur, utilisateur.nom, utilisateur.prenom
            FROM associe
            LEFT JOIN utilisateur ON associe.ref_utilisateur = utilisateur.id_utilisateur
            LEFT JOIN projet ON associe.ref_projet = projet.id_projet
            WHERE projet.id_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if (!$res) return null;
        return $res;
    }

    public function associateTo(int $userId, int $projectId) {
        $request = 'SELECT ref_utilisateur FROM associe
                WHERE ref_utilisateur = :userId AND ref_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetch();
        if (!$res) return null;
        return $res;
    }

}