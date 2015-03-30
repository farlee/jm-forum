<?php

/*
 * Route Settings
 */

//$router = new Phalcon\Mvc\Router(false);
$router = new Phalcon\Mvc\Router();

/*
 * Define a default route;
 * This next 5 commented groups of rules are needed only when $router is 'new' with 'false':
 *     $router = new Phalcon\Mvc\Router(false);
$router->add(
    "/:controller/:action/:params",
    array(
        "controller" => 1,
        "action" => 2,
        "params" => 3,
    )
);
 */

//$router->setDefaultModule('backend');
//$router->setDefaultNamespace('Jimi\Backend'); //Have set in 'dispatcher' service.
//$router->setDefaultController('index');
//$router->setDefaultAction('index');

/*
 * If you need the default action to omit the action in url. please specify each as follow
 * Do not forget the slash / at the beginning.
$router->add(
    '/welcome',
    array(
        'controller' => 'welcome',
        'action'     => 'index'
    )
);
 */

/*
 * When application is accessed without any route, the ‘/’ route is used.
$router->add(
    '/',
    array(
        'controller' => 'index',
        'action'     => 'index'
    )
);
 */

/*
 * Or set a 404 paths, the rule above would only matches to the home page;
 * This rule only effective when the $route was 'new' with 'false';
 * The 404 error has been catch in the service event: dispatcher:beforeException
$router->notFound(array(
    "controller" => "index",
    "action" => "r404"
));
 */

// Defined the special rules below





return $router;
