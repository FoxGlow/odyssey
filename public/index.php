<?php
/**
 * Entry point
 * 
 * @author Hugolin Mariette
 */

/**
 * -------------------------------------------------------------------------+
 * DEFINING PROJECT ROOT                                                    |
 * -------------------------------------------------------------------------+
 * 
 * This is the absolute path to the root of the project.
 * 
 */
define('ROOT', dirname(__DIR__));

/**
 * -------------------------------------------------------------------------+
 * AUTOLOADER REGISTERING                                                   |
 * -------------------------------------------------------------------------+
 * 
 * Here is called the composer internal autoloader which is good, because it
 * is PSR-0 and PSR-4 compatible.
 * 
 */
require_once ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * -------------------------------------------------------------------------+
 * LOADING ENVIRONMENT VARIABLES                                            |
 * -------------------------------------------------------------------------+
 * 
 * Dotenv is used to access easily to the env variables sets in the .env
 * file located at the root. The best way to access these variables for you
 * is the Config class.
 * 
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT);
$dotenv->load();
$dotenv->required(['APP_DEBUG']); // TO COMPLETE

/**
 * -------------------------------------------------------------------------+
 * REGISTER THE PRETTY HANDLER (if debug mode is true)                      |
 * -------------------------------------------------------------------------+
 * 
 * This is a beautiful error handler framework for PHP called whoops.
 *  
 */
if (getenv('APP_DEBUG') === "true") {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

/**
 * -------------------------------------------------------------------------+
 * APPLICATION                                                              |
 * -------------------------------------------------------------------------+
 * 
 * Creates application.
 * 
 */
$app = new Core\Application;

/**
 * -------------------------------------------------------------------------+
 * ROUTER                                                                   |
 * -------------------------------------------------------------------------+
 * 
 * FastRoute is used to manages routes easily, you can add routes in the 
 * routes.php configuration file.
 * 
 */
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r)
{
    require_once ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.php';
});

// Fetch method and URI from somewhere
$http_method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatch and give handle to application
$route_info = $dispatcher->dispatch($http_method, $uri);
switch ($route_info[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        $app->notFound();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowed_methods = $route_info[1];
        // ... 405 Method Not Allowed
        $app->methodNotAllowed($allowed_methods);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $route_info[1];
        $vars = $route_info[2];
        $app->found($handler, $vars);
        break;
}
