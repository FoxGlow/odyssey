<?php
/**
 * Class to design a Service
 * 
 * @author Hugolin Mariette
 */

namespace Core\Container;

class Service {

    /**
     * The service identifier
     * @var string
     */
    private $id;

    /**
     * The service callable
     * @var callable
     */
    private $callable;

    /**
     * Creates a new Dependency object
     * @param string $id the identifier to access this service
     * @param callable $c the callable to build the service
     */
    public function __construct(string $id, callable $c) {
        $this->id = $id;
        $this->callable = $c;
    }

    /**
     * Gets the identifier of this service
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * Gets the callable to build the service
     * @return callable
     */
    public function getCallable(): callable {
        return $this->callable;
    }
}
