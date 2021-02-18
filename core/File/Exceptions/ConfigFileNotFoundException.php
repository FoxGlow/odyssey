<?php
/**
 * The config file was not found
 * 
 * @author Hugolin Mariette
 */

namespace Core\File\Exceptions;

use Exception;

class ConfigFileNotFoundException extends Exception {
    public function __construct(string $config_file, int $code  = 0, Exception $previous = null) {
        $message = "The config file '{$config_file}' was not found";
        parent::__construct($message, $code, $previous);
    }
}