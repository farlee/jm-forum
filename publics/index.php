<?php

/*
 * Backend Index
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

/**
 * Include composer autoloader
 */
require APP_PATH .DIRECTORY_SEPARATOR. "vendor/autoload.php";

try {

    /**
     * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
     */
    $di = new FactoryDefault();

    $application = new Application($di);

    $application->registerModules(array(
        'frontend' => array(
            'className' => 'Modules\Frontend\Module',
            'path' => '../apps/frontend/Module.php'
        ),
        'backend' => array(
            'className' => 'Modules\Backend\Module',
            'path' => '../apps/backend/Module.php'
        )
    ));

    echo $application->handle()->getContent();

} catch (Exception $e) {

    /**
     * Log the exception
     */
    $logger = new Logger(APP_PATH . '/apps/common/logs/error.log');
    $logger->error($e->getMessage());
    $logger->error($e->getTraceAsString());

    /**
     * Show an static error page
     */
    $response = new Response();
    $response->redirect('505.html');
    $response->send();

}
