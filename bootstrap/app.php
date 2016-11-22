<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 09:40
 */
session_start();
require __DIR__ .'/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new \Slim\App([

    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver'    => 'mysql',
            'host'      => getenv('DB_HOST'),
            'Validation'  => getenv('DB_DB'),
            'database'  => getenv('DB_DB'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => ''
        ]
    ]

]);



$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function($container) use ($capsule){
    return $capsule;
};

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/views',[
        'cache' => false
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

$container['validator'] = function($container){
    return new Generator\Validation\Validator;
};

$container['HomeController'] = function($container){
    return new \Generator\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    return new \Generator\Controllers\Auth\AuthController($container);
};

$app->add(new \Generator\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \Generator\Middleware\OldInputMiddleware($container));


require __DIR__.'/../app/routes.php';