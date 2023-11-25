<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

//$app = new \Slim\Slim();

$app->get('/', function($request, $response, array $args)
{
    $response->getBody()->write("Funciona root!");
    return $response;
});

$app->run();