<?php

require_once './models/Consultar.php';
require_once './models/Cuenta.php';

class ConsultarController
{

    public function ConsultarCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $existeTipoDeCuenta = FALSE;
        $existeNumeroDeCuenta = FALSE;
        $id = (int)$parametros['id'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $arrayCuentas = Cuenta::obtenerTodasCuentas();
        
        foreach ($arrayCuentas as $value) 
        {
            if($value->tipoDeCuenta == $tipoDeCuenta && $value->id == $id)
            {
                $saldoCuenta = $value->saldo;
                $nombre = $value->nombre;
                $apellido = $value->apellido;
                $payload = json_encode(array("Aviso!" => "Se encontro la cuenta solicitada. Tipo de cuenta: $tipoDeCuenta - Saldo: $saldoCuenta - Nombre: $nombre $apellido"));
                $response->getBody()->write($payload);
                return $response;       
            }
            elseif($value->tipoDeCuenta != $tipoDeCuenta && $value->id == $id)
            {
                $existeNumeroDeCuenta = TRUE;
            }
        }
    
        if($existeNumeroDeCuenta)
        {
            $payload = json_encode(array("Error!" => "No existe el tipo de cuenta:$tipoDeCuenta, pero si existe el numero de cuenta:$id!"));
        }
        else
        {
            $payload = json_encode(array("Error!" => "No existe esa combinacion de Numero de cuenta y Tipo de cuenta!"));
        }

    
        $response->getBody()->write($payload);
        return $response;
    }

    public function ConsultarDepositadosPorFecha($request,$response,$args)//a
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $fecha = 0;
        if(!isset($parametros['fecha']))
        {
            $fecha = Consultar::ObtenerDiaAnterior();
        }
        else{
            $fecha = $parametros['fecha'];
        }

        $listado = Consultar::depositadoPorFecha($tipoDeCuenta,$fecha);
        if($listado == NULL)
        {
            $payload = json_encode(array("Aviso!" => "No se han encontrados depositos en la fecha: $fecha con el tipo de cuenta $tipoDeCuenta"));

        }
        else{
            $payload = json_encode(array("Total deposito el dia de la fecha $fecha:" => $listado));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); // esto es para indicar que el body tiene una respuesta de tipo json
    }

    public function ConsultarDepositosUsuario($request,$response,$args)//b
    {
        $parametros = $request->getQueryParams();
        $dni = $parametros['numeroDeDocumento'];

        $listado = Consultar::depositadoPorUsuario($dni);
        if(count($listado) <= 0)
        {
            $payload = json_encode(array("Error" => "No se han encontrados depositos con ese numeroDeDocumento"));

        }
        else{

            $payload = json_encode(array("Total depositos del usuario:" => $listado));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarDepositosEntreDosFechas($request,$response,$args)//c
    {
        $parametros = $request->getQueryParams();
        $fechaUno = $parametros['fechaUno'];
        $fechaDos = $parametros['fechaDos'];

        $listado = Consultar::depositadoPorDosFechas($fechaUno,$fechaDos);

        $payload = json_encode(array("Depositos entre las dos fechas" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarDepositosTipoDeCuenta($request,$response,$args)
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $listado = Consultar::obtenerPorTipoDeCuenta($tipoDeCuenta);
        
        
        $payload = json_encode(array("Depositos por tipo" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarDepositosTipoDeMoneda($request,$response,$args)
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $listado = Consultar::obtenerPorTipoDeMoneda($tipoDeCuenta);
        
        
        $payload = json_encode(array("Depositos por moneda" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    //---------------------------------------------------------------------------

    public function ConsultarRetirosPorFecha($request,$response,$args)//a
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $fecha = 0;
        if(!isset($parametros['fecha']))
        {
            $fecha = Consultar::ObtenerDiaAnterior();
        }
        else{
            $fecha = $parametros['fecha'];
        }

        $listado = Consultar::retiradoPorFecha($tipoDeCuenta,$fecha);
        if($listado == NULL)
        {
            $payload = json_encode(array("Aviso!" => "No se han encontrados retiros en la fecha: $fecha con el tipo de cuenta $tipoDeCuenta"));

        }
        else{
            $payload = json_encode(array("Total retiros el dia de la fecha $fecha:" => $listado));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); // esto es para indicar que el body tiene una respuesta de tipo json
    }

    public function ConsultarRetirosUsuario($request,$response,$args)//b
    {
        $parametros = $request->getQueryParams();
        $dni = $parametros['numeroDeDocumento'];

        $listado = Consultar::retiradoPorUsuario($dni);
        if(count($listado) <= 0)
        {
            $payload = json_encode(array("Error" => "No se han encontrados retiros con ese numeroDeDocumento"));

        }
        else{

            $payload = json_encode(array("Total retiros del usuario:" => $listado));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarRetirosEntreDosFechas($request,$response,$args)//c
    {
        $parametros = $request->getQueryParams();
        $fechaUno = $parametros['fechaUno'];
        $fechaDos = $parametros['fechaDos'];

        $listado = Consultar::retiradoPorDosFechas($fechaUno,$fechaDos);

        $payload = json_encode(array("Retiros entre las dos fechas" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarRetirosTipoDeCuenta($request,$response,$args)
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $listado = Consultar::obtenerPorTipoDeCuentaRetiro($tipoDeCuenta);
        
        
        $payload = json_encode(array("Retiros por tipo" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarRetirosTipoDeMoneda($request,$response,$args)
    {
        $parametros = $request->getQueryParams();
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $listado = Consultar::obtenerPorTipoDeMonedaRetiro($tipoDeCuenta);
        
        
        $payload = json_encode(array("Retiros por moneda" => $listado));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json'); 
    }

    public function ConsultarDepositosyRetirosPorUsuario($request,$response,$args)
    {
        $param = $request->getQueryParams();

        $dni = $param['numeroDeDocumento'];

        $lista = Consultar::obtenerRetirosDepositosPorUsuario($dni);
        if(count($lista) <= 2)
        {
            $payload = json_encode(array("ERROR" => "No existen transacciones con ese dni"));

        }else{

            $payload = json_encode(array("Depositos y retiros por usuarios" => $lista));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}