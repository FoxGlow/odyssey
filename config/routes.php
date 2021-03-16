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

// User pages
$r->addGroup('/user', function (FastRoute\RouteCollector $r) {
    $r->get('/login', 'user#login');
    $r->post('/login', 'user#authenticate');

    $r->get('/register', 'user#register');
    $r->post('/register', 'user#create');

    $r->get('/logout', 'user#logout');
});

// Project pages
$r->addGroup('/project', function (FastRoute\RouteCollector $r) {
    $r->get('/list', 'project#list');

    $r->get('/new', 'project#new');
    $r->post('/new', 'project#create');

    $r->get('/view/{projectId:\d+}', 'project#view');

    $r->get('/delete/{projectId:\d+}', 'project#delete');
});

$r->addGroup('/message', function (FastRoute\RouteCollector $r) {
    $r->post('/post', 'message#post');
    $r->get('/delete/{messageId:\d+}/{projectId:\d+}', 'message#delete');
});

$r->addGroup('/associate', function (FastRoute\RouteCollector $r) {
    $r->post('/add', 'associate#add');
    $r->get('/delete/{associateId:\d+}/{projectId:\d+}', 'associate#delete');
});
