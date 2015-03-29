<?php

/*
 * Application Loader
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
        'Jimi\Frontend' => $controllersDir,
        'Jimi\Models' => $modelsDir,
        'Jimi' => $libraryDir,
    )
);

$loader->register();
