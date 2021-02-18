<?php

/**
 * -------------------------------------------------------------------------+
 * APPLICATION CONFIGURATION FILE                                           |
 * -------------------------------------------------------------------------+
 * 
 * Here are the different configurations needed in the application, you can
 * add yours if it's necessary, it is better than use define function to
 * create constants.
 * 
 */
return [

    /**
     * -------------------------------------------------------------------------+
     * APPLICATION CONFIGURATION                                                |
     * -------------------------------------------------------------------------+
     * 
     * It defines the state of the application (debug mode or not).
     * 
     */
    'app' => [
        'debug' => getenv('APP_DEBUG')
    ],

    
    /**
     * -------------------------------------------------------------------------+
     * APPLICATIONS PATHS                                                       |
     * -------------------------------------------------------------------------+
     * 
     * This contains the paths to the different folders in the application such
     * as the views, controllers and entities folders.
     * 
     */
    'paths' => [
        'views_dir' => ROOT . '/app/Views/',
        'controllers_dir' => ROOT . '/app/Controllers',
        'entities_dir' => ROOT . '/app/Entities',
        'assets_dir' => '/assets',
        'tmp_dir' => ROOT . '/tmp'
    ],


    /**
     * -------------------------------------------------------------------------+
     * DATABASE CONNECTION                                                      |
     * -------------------------------------------------------------------------+
     * 
     * It contains the database connection informations which are set in the
     * .env file located at the root of the project.
     * 
     */
    'db' => [
        'connection' => getenv('DB_CONNECTION'),
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'charset' => getenv('DB_CHARSET'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD')
    ]

];
