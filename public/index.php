<?php

/*
 * Frontend Index
*/

use Phalcon\Http\Response;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Logger\Adapter\File as Logger;

error_reporting(E_ALL);

if (!isset($_GET['_url'])) {
    $_GET['_url'] = '/';
}

define('APP_PATH', realpath('..'));
define('APP_PATH_FRONTEND', realpath('..').'/apps/frontend/');

/**
 * Read the configuration
 */
$config = include APP_PATH_FRONTEND. "config/config.php";

/**
 * Include the loader
 */
require APP_PATH_FRONTEND.  "config/loader.php";

/**
 * Include composer autoloader
 */
require APP_PATH.DIRECTORY_SEPARATOR. "vendor/autoload.php";

try {

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    require APP_PATH_FRONTEND . "config/services.php";

    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (Exception $e) {

    /**
     * Log the exception
     */
    $logger = new Logger(APP_PATH_FRONTEND . 'logs/error.log');
    $logger->error($e->getMessage());
    $logger->error($e->getTraceAsString());

    /**
     * Show an static error page
     */
    $response = new Response();
    $response->redirect('505.html');
    $response->send();

}
