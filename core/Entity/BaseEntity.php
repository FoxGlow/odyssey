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
     * Creates a BaseEntity and initializes it's connection to database
     */
    public function __construct() {
        $this->db_connection = new Connection;
    }
}
