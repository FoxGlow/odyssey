<?php

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

// Pour tester
$loader = new \Twig\Loader\FilesystemLoader(ROOT . '/app/Views');
$twig = new \Twig\Environment($loader, []);

echo $twig->render('template.html.twig');
