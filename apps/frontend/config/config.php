<?php

/*
 * Frontend config
 */


return new \Phalcon\Config(array(

    'site' => array(
        'name'      => 'JIMI',
        'url'       => 'http://jimi.com',
        'project'   => 'jimi',
        'software'  => 'jimi-forum',
        'repo'      => 'https://github.com/farlee/jm-forum',
        //'docs'      => '',
    ),

    'database'    => array(
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'hr123',
        'dbname'   => 'jimi_forum',
        'charset'  => 'utf8'
    ),

    'application' => array(
        'controllersDir' => APP_PATH_FRONTEND . 'controllers/',
        'modelsDir'      => APP_PATH . '/apps/common/models/',
        'viewsDir'       => APP_PATH_FRONTEND . 'views/',
        'pluginsDir'     => APP_PATH . '/apps/common/plugins/',
        'libraryDir'     => APP_PATH . '/apps/common/library/',
        'development'    => array(
            'staticBaseUri' => '/',
            'baseUri'       => '/'
        ),
        'production'     => array(
            'staticBaseUri' => 'http://static.jimi.com/',
            'baseUri'       => '/'
        ),
        'debug'          => true
    ),

    'mandrillapp' => array(
        'secret' => ''
    ),

    'github'      => array(
        'clientId'     => '',
        'clientSecret' => '',
        'redirectUri'  => 'http://pforum.loc/login/oauth/access_token/'
    ),

    'amazonSns'   => array(
        'secret' => ''
    ),

    'smtp'        => array(
        'host'     => "",
        'port'     => 25,
        'security' => "tls",
        'username' => "",
        'password' => ""
    ),

    'beanstalk'   => array(
        'disabled' => true,
        'host'     => '127.0.0.1'
    ),

    'elasticsearch' => array(
        'index'    => 'phosphorum'
    ),
    
    'mail'     => array(
        'fromName'     => 'JiMiP',
        'fromEmail'    => 'jm@jimip.com',
    )
));
