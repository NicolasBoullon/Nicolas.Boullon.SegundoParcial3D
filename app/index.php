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

require_once './middleware/ValidarMiddleware.php';

$app = AppFactory::create();

//$app = new \Slim\Slim();

$app->get('/', function($request, $response, array $args)
{
    $response->getBody()->write("Funciona root!");
    return $response;
});


$app->group('/cuenta', function (RouteCollectorProxy $group)
{
    $group->post('/crearCuenta', CuentaController::class . ':CargarCuenta')
    ->add(\ValidarMiddleware::class . ':validarParametrosCuenta');
    $group->post('/altaCuenta', CuentaController::class . ':AltaCuenta');
    $group->delete('/bajaCuenta', CuentaController::class . ':BajaCuenta');
    // $group->put('/modificarProducto', CuentaController::class . ':ModificarProducto');
});

$app->group('/movimientos', function (RouteCollectorProxy $group)
{
    $group->post('/depositar', DepositoController::class . ':DepositarCuenta')
        ->add(\ValidarMiddleware::class . ':VerificarDatosDeposito');
       
    $group->post('/retirar', RetiroController::class . ':RetirarCuenta')
    ->add(\ValidarMiddleware::class . ':VerificarDatosRetiro');

})->add(\ValidarMiddleware::class . ':VerificarCuenta');


$app->group('/consultas', function (RouteCollectorProxy $group)
{
    $group->post('/consultarCuenta', ConsultarController::class . ':ConsultarCuenta');
    

});




$app->run();