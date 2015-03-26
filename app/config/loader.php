<?php

/*
 +------------------------------------------------------------------------+
 | Phosphorum                                                             |
 +------------------------------------------------------------------------+
 | Copyright (c) 2013-2014 Phalcon Team and contributors                  |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file docs/LICENSE.txt.                        |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
*/

$modelsDir      = $config->application->modelsDir;
$controllersDir = $config->application->controllersDir;
$libraryDir     = $config->application->libraryDir;

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(
    array(
       'Phosphorum\Models'        => $modelsDir,
       'Phosphorum\Controllers'   => $controllersDir,
       'Phosphorum'               => $libraryDir
    )
);

$loader->register();
