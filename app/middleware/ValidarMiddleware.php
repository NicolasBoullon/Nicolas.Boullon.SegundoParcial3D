<?php
// require_once './jwt/AutentificadorJwt.php';
require_once './models/Cuenta.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class ValidarMiddleware
{
    
    public static function validarParametrosCuenta(Request $request, RequestHandler $handler): Response{
        $parametros = $request->getParsedBody();
        
        $tipoDeDocumento = $parametros['tipoDeDocumento'];
        $numeroDeDocumento = $parametros['numeroDeDocumento'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $saldo = $parametros['saldo'];
        $email = $parametros['email'];

        try{

            Cuenta::ValidarDatosDeCuenta($tipoDeDocumento,$numeroDeDocumento,$email,$tipoDeCuenta,$saldo);
            $response = $handler->handle($request);

        } catch(Exception $e){
            $response = new Response();
            $payload = json_encode(array('AVISO!' => 'Error con los parametros ingresados'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type','application/json');
    }

}