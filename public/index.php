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
 * is to use config() function or Config class (this is why Dotenv is not
 * defined by default in services configuration file).
 * 
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT);
$dotenv->load();
$dotenv->required(['APP_DEBUG']);

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

// To test web pages
$loader = new \Twig\Loader\FilesystemLoader(ROOT . '/app/Views');
$twig = new \Twig\Environment($loader, []);
echo $twig->render('pages/home.html.twig');
