<?php
/**
 * The key was not found
 * 
 * @author Hugolin Mariette
 */

namespace Core\File\Exceptions;

use Exception;

class KeyNotFoundException extends Exception {
    public function __construct(string $key, int $code  = 0, Exception $previous = null) {
        $message = "The key '{$key}' was not found";
        parent::__construct($message, $code, $previous);
    }
}