<?php
/**
 * Class to design a base Controller
 * 
 * @author Hugolin Mariette
 */

namespace Core\Controller;

use Psr\Container\ContainerInterface;

class BaseController {
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Creates a BaseController
     * @param ContainerInterface $container a psr-11 container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
}
