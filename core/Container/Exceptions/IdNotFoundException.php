<?php
/**
 * The id was not found
 * 
 * @author Hugolin Mariette <hugolinma@gmail.com>
 */

namespace Core\Container\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class IdNotFoundException extends Exception implements NotFoundExceptionInterface {
    public function __construct(string $id, int $code  = 0, Exception $previous = null) {
        $message = "The identifier '{$id}' was not found";
        parent::__construct($message, $code, $previous);
    }
}
