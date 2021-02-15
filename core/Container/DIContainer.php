<?php
/**
 * 
 * Dependency Injection Container
 * 
 * @author Hugolin Mariette
 * 
 */

namespace Core\Nugget\Container;

use Psr\Container\ContainerInterface;
use Core\Container\Service;
use Core\Container\Exceptions\IdNotFoundException;

class DIContainer implements ContainerInterface {

    /**
     * Contains all the services
     * @var array
     */
    private $registry = [];

    /**
     * Contains the instances
     * @var array
     */
    private $instances = [];

    /**
     * Load services from a php config file
     * @param string $f_path the file path
     */
    public function load(string $f_path): self {
        $config = require($f_path);
        foreach ($config as $id => $callable) {
            $this->registry[$id] = new Service($id, $callable);
        }
        return $this;
    }

    /**
     * Creates an instance of the service
     * @param string $id identifier of the entry to look for
     * @param callable $c a callable to instantiate the class
     */
    public function set($id, callable $c): void {
        $this->instances[$id] = $c;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     * @param string $id Identifier of the entry to look for.
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     * @return mixed Entry.
     */
    public function get($id) {
        if (!$this->has($id)) throw new IdNotFoundException($id);
        if (!isset($this->instances[$id])) {
            $this->set($id, $this->registry[$id]->getCallable());
        }
        return $this->instances[$id]($this);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has($id) {
        if (array_key_exists($id, $this->registry)) return true;
        return false;
    }

}
