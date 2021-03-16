<?php
/**
 * File entity
 * 
 * @author Hugolin Mariette
 */

namespace App\Entities;

use Core\Entity\BaseEntity;

class FileEntity extends BaseEntity {

    private $categories = ['mcf', 'mcd', 'cvo', 'bpmn', 'story_map'];

    public function importFile(string $category, string $name, string $content, int $projectId) {
        if (!in_array($category, $this->categories)) return null;
        $request = "INSERT INTO {$category}(fichier, nom, ref_projet) 
                VALUES(:content, :name, :projectId)";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':projectId', $projectId);
        $res = $stmt->execute();
        return $res;
    }

    public function delete(string $category, int $fileId) {
        if (!in_array($category, $this->categories)) return null;
        $request = "DELETE FROM {$category} WHERE id_{$category} = :fileId";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':fileId', $fileId);
        $res = $stmt->execute();
        return $res;
    }

    public function getFile(string $category, int $fileId) {
        if (!in_array($category, $this->categories)) return null;
        $request = "SELECT fichier, nom FROM {$category}
                WHERE id_{$category} = :fileId";
        $stmt = $this->db_connection::getInstance()->prepare($request);
        $stmt->bindValue(':fileId', $fileId);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    public function exist() {

    }

}