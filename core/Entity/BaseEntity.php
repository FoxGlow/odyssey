<?php
/**
 * Class to design a base Entity
 * 
 * @author Hugolin Mariette
 */

namespace Core\Entity;

use Core\Database\Connection;

class BaseEntity {
    /**
     * @var \Core\Database\Connection
     */
    protected $db_connection;

    /**
     * Creates a BaseEntity
     * @param Connection $db_connection the connection to database
     */
    public function __construct(Connection $db_connection) {
        $this->db_connection = $db_connection;
    }
}
