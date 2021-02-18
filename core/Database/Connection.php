<?php
/**
 * Class to design a database connection (PDO)
 * 
 * @author Hugolin Mariette
 */

namespace Core\Database;

use Core\File\Config;

class Connection {
    /**
     * @var null|PDO
     */
    private static $database_instance = null;

    /**
     * Returns the Connection instance and creates it if it does not already exist
     * @return PDO
     */
    public static function getInstance() : \PDO {
        if (is_null(self::$database_instance)) {
            $db_type = Config::get('db.type');
            $db_host = Config::get('db.host');
            $db_name = Config::get('db.name');
            $db_charset = Config::get('db.charset');
            $db_username = Config::get('db.username');
            $db_password = Config::get('db.password');
            try {
                self::$database_instance = new \PDO($db_type . ':host=' . $db_host . 
                    ';dbname=' . $db_name . ';charset=' . $db_charset, 
                    $db_username, $db_password, array(
                        \PDO::ATTR_EMULATE_PREPARES => false,
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                    ));
            }
            catch (\Exception $e) {
                // TODO
            }
        }
        return self::$database_instance;
    }
}
