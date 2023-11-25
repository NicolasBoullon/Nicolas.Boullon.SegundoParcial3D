<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/AjusteController.php';
require_once './controllers/ConsultarController.php';
require_once './controllers/CuentaController.php';
require_once './controllers/DepositoController.php';
require_once './controllers/AjusteController.php';
require_once './controllers/RetiroController.php';


$app = AppFactory::create();

//$app = new \Slim\Slim();

$app->get('/', function($request, $response, array $args)
{
    $response->getBody()->write("Funciona root!");
    return $response;
});


$app->group('/cuenta', function (RouteCollectorProxy $group)
{
    $group->post('/crearCuenta', CuentaController::class . ':CargarCuenta');
    // $group->post('/altaProducto', CuentaController::class . ':AltaProducto');
    // $group->delete('/bajaProducto', CuentaController::class . ':BajaProducto');
    // $group->put('/modificarProducto', CuentaController::class . ':ModificarProducto');
});

$app->run();