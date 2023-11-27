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
        $email = $parametros['email'];
        if(isset($_POST['saldo']))
        {
            $saldo = $parametros['saldo'];
        }
        else
        {
            $saldo = 0;
        }

        try{

            if(Cuenta::ValidarDatosDeCuenta($tipoDeDocumento,$numeroDeDocumento,$email,$tipoDeCuenta,$saldo))
            {
                $response = $handler->handle($request);
            }
            else
            {
                throw new Exception();
            }

        } catch(Exception $e){
            $response = new Response();
            $payload = json_encode(array('AVISO!' => 'Error con los parametros ingresados'));
            $response->getBody()->write($payload);
        }
        return $response->withHeader('Content-Type','application/json');
    }

    public static function VerificarCuenta(Request $request, RequestHandler $handler): Response
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $e = false;
        $arrayCuentas = Cuenta::obtenerTodasCuentas();
        try{
            foreach ($arrayCuentas as $value) 
            {
                if($value->tipoDeCuenta == $tipoDeCuenta && $value->id == $id)
                {
                    $e = true;
                    $response = $handler->handle($request);    
                }
            }

            if(!$e)
            {
                throw new Exception();
            }
        }
        catch(Exception $e){
            $response = new Response();
            $payload = json_encode(array('AVISO!' => 'Error con los datos de cuenta ingresados'));
            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type','application/json');
    }

    public static function VerificarDatosDeposito(Request $request, RequestHandler $handler): Response{
 
        $parametros = $request->getParsedBody();

        $importeADepositar = (float)$parametros['importeDepositar'];
        try{
            if($importeADepositar > 0)
            {
                $response = $handler->handle($request);
            }
            else{
                throw new Exception();
            }
        } catch(Exception $e){
            $response = new Response();
            $payload = json_encode(array('AVISO!' => 'El deposito debe ser mayor a 0'));
            $response->getBody()->write($payload);
        }
        
        return $response->withHeader('Content-Type','application/json');
    }

    public static function VerificarDatosRetiro(Request $request, RequestHandler $handler): Response{
 
        $parametros = $request->getParsedBody();

        $importeARetirar = (float)$parametros['importeRetirar'];
        
        try{
            if($importeARetirar > 0)
            {
                $response = $handler->handle($request);
            }
            else{
                throw new Exception();
            }
        } catch(Exception $e){
            $response = new Response();
            $payload = json_encode(array('AVISO!' => 'El retiro debe ser mayor a 0'));
            $response->getBody()->write($payload);
        }
        
        return $response->withHeader('Content-Type','application/json');
    }

}