<?php
/**
 * Project entity
 * 
 * @author Hugolin Mariette, Abdelnor Ait Ali, Yuxuan Sun
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class ProjectEntity extends BaseEntity {

    public function create(string $name, string $description, int $userId) {
        $request = 'INSERT INTO projet(nom, description, ref_chef)
                VALUES (:name, :description, :userId)';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':name', $name);    
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':userId', $userId);    
        $stmt->execute();
        return $this->db_connection::getInstance()->lastInsertId();
    }

    public function list(int $userId) {
        $request = 'SELECT projet.id_projet, projet.nom, projet.description, projet.ref_chef,
            utilisateur.id_utilisateur, COUNT(associe.ref_utilisateur) AS nb_collaborateurs,
            bpmn.id_bpmn, story_map.id_story_map, mcd.id_mcd, cvo.id_cvo, mcf.id_mcf
            FROM PROJET
            LEFT JOIN utilisateur ON utilisateur.id_utilisateur = projet.ref_chef
            LEFT JOIN associe ON associe.ref_projet = projet.id_projet
            LEFT JOIN bpmn ON bpmn.ref_projet = projet.id_projet
            LEFT JOIN story_map ON story_map.ref_projet = projet.id_projet
            LEFT JOIN mcd ON mcd.ref_projet = projet.id_projet
            LEFT JOIN cvo ON cvo.ref_projet = projet.id_projet
            LEFT JOIN mcf ON mcf.ref_projet = projet.id_projet
            WHERE associe.ref_utilisateur = :userId
            GROUP BY projet.id_projet, projet.nom, projet.description, projet.ref_chef,
            utilisateur.id_utilisateur, bpmn.id_bpmn, story_map.id_story_map, mcd.id_mcd,
            cvo.id_cvo, mcf.id_mcf';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        $res = $stmt->fetchAll();
        if (!$res) return null;
        return $res;
    }

    public function get(int $projectId) {
        $request = 'SELECT * FROM projet
            WHERE projet.id_projet = :projectId';
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':projectId', $projectId);
        $stmt->execute();
        $res = $stmt->fetch();
        if (!$res) return null;
        return $res;
    }

}