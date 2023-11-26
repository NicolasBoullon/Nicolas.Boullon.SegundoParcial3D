<?php

// require_once './models/Consultar.php';
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
                $payload = json_encode(array("Aviso!" => "Se encontro la cuenta solicitada."));
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



}