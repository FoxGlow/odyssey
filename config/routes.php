<?php

/**
 * -------------------------------------------------------------------------+
 * ROUTE DEFINITIONS                                                        |
 * -------------------------------------------------------------------------+
 * 
 * Here you can define routes.
 *  
 */
// Static pages
$r->get('/[index]', 'static#home');
$r->get('/getting-started', 'static#gettingStarted');
$r->get('/credits', 'static#credits');

// User
$r->addGroup('/user', function (FastRoute\RouteCollector $r) {
    $r->get('/login', 'user#login');
    $r->get('/register', 'user#register');
    $r->post('/login', 'user#authenticate');
    $r->post('/register', 'user#create');
});
