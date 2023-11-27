<?php

require_once './models/Modificar.php';

class ModificarController
{

    public static function ModificarCuenta($request,$response,$args)
    {
        $param = $request->getBody();
        $parametros = json_decode($param);
        $id = $parametros->id;
        $nombre = $parametros->nombre;
        $apellido = $parametros->apellido;
        $tipoDeDocumento = $parametros->tipoDeDocumento;
        $numeroDeDocumento = $parametros->numeroDeDocumento;
        $email = $parametros->email;
        $tipoDeCuenta = $parametros->tipoDeCuenta;

        if(!Cuenta::ValidarDatosDeCuenta($tipoDeDocumento,$numeroDeDocumento,$email,$tipoDeCuenta,1))
        {
            $payload = json_encode(array('ERROR!' => "Los parametros ingresados son erroneos"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        Modificar::modCuenta($id,$nombre,$apellido,$numeroDeDocumento,$email);

        $payload = json_encode(array('Aviso!' => "Se ha modificado la cuenta exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


}