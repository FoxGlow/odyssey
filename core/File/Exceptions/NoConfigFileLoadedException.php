<?php
/**
 * The config file wasn't loaded
 * 
 * @author Hugolin Mariette
 */

namespace Core\File\Exceptions;

use Exception;

class NoConfigFileLoadedException extends Exception {
    public function __construct(int $code  = 0, Exception $previous = null) {
        $message = "The config file was not loaded";
        parent::__construct($message, $code, $previous);
    }
}
