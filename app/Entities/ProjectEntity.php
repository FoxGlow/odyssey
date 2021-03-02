<?php
/**
 * Project entity
 * 
 * @author Hugolin Mariette
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
            utilisateur.id_utilisateur, utilisateur.nom, utilisateur.prenom, utilisateur.mail,
            COUNT(associe.ref_utilisateur) AS nb_collaborateur,
            (CASE WHEN id_bpmn IS NULL THEN \'0\' ELSE id_bpmn END) AS bpmn,
            (CASE WHEN id_cvo IS NULL THEN \'0\' ELSE id_cvo END) AS cvo,
            (CASE WHEN id_mcd IS NULL THEN \'0\' ELSE id_mcd END) AS mcd,
            (CASE WHEN id_story_map IS NULL THEN \'0\' ELSE id_story_map END) AS story_map,
            (CASE WHEN id_mcf IS NULL THEN \'0\' ELSE id_mcf END) AS mcf
            FROM PROJET
            LEFT JOIN utilisateur ON utilisateur.id_utilisateur = projet.ref_chef
            LEFT JOIN associe ON associe.ref_projet = projet.id_projet
            LEFT JOIN bpmn ON bpmn.ref_projet = projet.id_projet
            LEFT JOIN story_map ON story_map.ref_projet = projet.id_projet
            LEFT JOIN mcd ON mcd.ref_projet = projet.id_projet
            LEFT JOIN cvo ON cvo.ref_projet = projet.id_projet
            LEFT JOIN mcf ON mcf.ref_projet = projet.id_projet
            GROUP BY id_projet';
            $stmt = $this->db_connection::getInstance()->prepare($request);
            $stmt->bindValue(':userId', $userId);
            $stmt->execute();
            $res = $stmt->fetchAll();
            if (!$res) return null;
            return $res;
    }

}