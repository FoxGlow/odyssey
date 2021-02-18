<?php
/**
 * Class to design application kernel (currently depends on FastRoute router)
 * 
 * @author Hugolin Mariette
 */

namespace Core;

use ReflectionMethod;
use Core\File\Config;

class Application {
    public function notFound() {
        // TODO
    }

    public function methodNotAllowed($allowed_methods) {
        // TODO
    }

    public function found($handler, $vars) {
        /**
         * -------------------------------------------------------------------------+
         * CONFIG FILE                                                              |
         * -------------------------------------------------------------------------+
         * 
         * This loads the config file.
         * 
         */
        Config::load(ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

        /**
         * -------------------------------------------------------------------------+
         * DEPENDANCY INJECTION CONTAINER                                           |
         * -------------------------------------------------------------------------+
         * 
         * By default it uses our own implementation of dependancy injection
         * container, but it follows the PSR-11 standard so you can use an other
         * implementation if you want. It loads services defined in the services.php
         * file located in the config folder at the root of the project.
         * 
         */
        $container = new \Core\Container\DIContainer;
        $container->load(Config::get('paths.config_dir') . '/services.php');

        // Controller creation
        list($controller_name, $action) = explode('#', $handler);
        $controller_name = ucfirst($controller_name);
        $controller_name = "\\App\\Controllers\\{$controller_name}Controller";
        $controller = new $controller_name($container);
        $method = new ReflectionMethod($controller, $action);
        $param_arr = array();
        foreach ($method->getParameters() as $param) {
            $param_arr[] = $vars[$param->getName()];
        }
        call_user_func_array([$controller, $action], $param_arr);
    }
}