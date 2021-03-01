<?php
/**
 * Class to design application kernel (currently conceived for FastRoute router)
 * 
 * @author Hugolin Mariette
 */

namespace Core;

use App\Controllers\AppController;
use ReflectionMethod;
use Core\File\Config;

class Application {

    /**
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    public function __construct() { 
        /*
         * This loads the config file.
         */
        Config::load(ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

        /**
         * By default it uses our own implementation of dependancy injection
         * container, but it follows the PSR-11 standard so you can use an other
         * implementation if you want. It loads services defined in the services.php
         * file located in the config folder at the root of the project.
         */
        $this->container = new \Core\Container\DIContainer;
        $this->container->load(Config::get('paths.config_dir') . '/services.php');
    }

    public function notFound() {
        $app_controller = new AppController($this->container);
        $app_controller->notFound();
    }

    public function methodNotAllowed($allowed_methods) {
        $app_controller = new AppController($this->container);
        $app_controller->methodNotAllowed();
    }

    public function found($handler, $vars) {
        // Controller creation
        list($controller_name, $action) = explode('#', $handler);
        $controller_name = ucfirst($controller_name);
        $controller_name = "\\App\\Controllers\\{$controller_name}Controller";
        $controller = new $controller_name($this->container);
        $method = new ReflectionMethod($controller, $action);
        $param_arr = array();
        foreach ($method->getParameters() as $param) {
            $param_arr[] = $vars[$param->getName()];
        }
        call_user_func_array([$controller, $action], $param_arr);
    }
}