<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

$diContainer = new Infinum\Framework\DependencyInjectionContainer();

$diContainer->router = new Infinum\Framework\Router();
$diContainer->geoLocation = new Infinum\Service\GeoLocation("AIzaSyDsMAGgfdkYsLCMLaPYpHSfs1JdQO_4AuA");
$diContainer->tokenGenerator = new Infinum\Service\TokenGenerator();

$db = new PDO('sqlite:../db/sqlite.db');

$diContainer->cityRepository = new Infinum\Repository\City($db);
$diContainer->userRepository = new Infinum\Repository\User($db);

$diContainer->router->addRoutes([
    ['POST', '/user/login', 'Infinum\Controller\User::loginAction'],
    ['POST', '/user/register', 'Infinum\Controller\User::registerAction'],
    ['GET', '/cities', 'Infinum\Controller\Cities::getAction'],
    ['POST', '/cities', 'Infinum\Controller\Cities::postAction'],
    ['POST', '/favorites', 'Infinum\Controller\Favorites::postAction'],
    ['DELETE', '/favorites/:cityId', 'Infinum\Controller\Favorites::deleteAction']
]);

try {

    $route = $diContainer->router->getMatchedRoute();

    $controller = $route->controller;
    $action = $route->action;
    $arguments = $route->arguments;

    call_user_func_array(array(new $controller($diContainer), $action), $arguments);

} catch (Exception $e) {
    echo $e->getMessage();
}