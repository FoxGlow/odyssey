<?php

use Psr\Container\ContainerInterface;

/**
 * -------------------------------------------------------------------------+
 * SERVICES CONFIGURATION FILE                                              |
 * -------------------------------------------------------------------------+
 * 
 * Here you can define your own services which will be instantiate in the
 * dependency injection container.
 * 
 */
return [

    /**
     * -------------------------------------------------------------------------+
     * TWIG RENDERER CONFIGURATION                                              |
     * -------------------------------------------------------------------------+
     * 
     * This creates a twig instance which point on the views path. It also add a
     * custom extension wich produces "inline" svg images.
     * 
     */
    'twigloader' => function () {
        return new \Twig\Loader\FilesystemLoader(Core\File\Config::get('paths.views_dir'));
    },
    
    'twig' => function (ContainerInterface $c) {
        $twig = new \Twig\Environment($c->get('twigloader'), []);
        $twig->addExtension(new \App\Twig\AppExtension);
        $twig->addGlobal('userId', $_SESSION['userId']);
        $twig->addGlobal('mail', $_SESSION['mail']);
        $twig->addGlobal('lastname', $_SESSION['lastname']);
        $twig->addGlobal('firstname', $_SESSION['firstname']);
        return $twig;
    }

];