<?php
/**
 * Created by PhpStorm.
 * User: Lukasz
 * Date: 22/11/2016
 * Time: 09:54
 */

use Generator\Middleware\AuthMiddleware;
use Generator\Middleware\GuestMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('',function(){

    $this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $this->post('/auth/signup', 'AuthController:postSignUp');

    $this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $this->post('/auth/signin', 'AuthController:postSignIn');

    $this->get('/auth/password/forgot', 'PasswordController:getForgotPassword')->setName('auth.password.forgot');
    $this->post('/auth/password/forgot', 'PasswordController:postForgotPassword');


})->add(new GuestMiddleware($container));

$app->group('',function(){
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');

    $this->get('/generator', 'GeneratorController:index')->setName('generator');
    $this->get('/generator/{part}', 'GeneratorController:getLevel')->setName('generator.level');
    $this->get('/generator/{part}/{level}', 'GeneratorController:getEquipment')->setName('generator.equipment');
})->add(new AuthMiddleware($container));

