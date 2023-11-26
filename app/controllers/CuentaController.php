<?php

require_once "./models/Cuenta.php";

class CuentaController{

    public function CargarCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
    
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $tipoDeDocumento = $parametros['tipoDeDocumento'];
        $numeroDeDocumento = $parametros['numeroDeDocumento'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $saldo = $parametros['saldo'];
        $email = $parametros['email'];
    
        $cuenta = new Cuenta();
        $cuenta->nombre = $nombre;
        $cuenta->apellido = $apellido;
        $cuenta->tipoDeDocumento = $tipoDeDocumento;
        $cuenta->numeroDeDocumento = $numeroDeDocumento;
        $cuenta->tipoDeCuenta = $tipoDeCuenta;
        $cuenta->saldo = $saldo;
        $cuenta->email = $email;
    
        $cuenta->crearCuenta();
        $payload = json_encode(array("mensaje" => "Cuenta creada con exito"));
    
        $response->getBody()->write($payload);
        return $response;
    }
    
    // public function TraerMesas($request,$response,$args)
    // {
    //     $lista = Mesa::obtenerTodasMesas();
    //     $payload = json_encode(array("listaMesas"=> $lista));
    
    //     $response->getBody()->write($payload);
    //     return $response->withHeader('Content-Type', 'application/json');
    // }
    
    // public function AltaMesa($request,$response,$args)
    // {
    //     $parametros = $request->getParsedBody();
    //     $id = $parametros['id'];
    
    //     Mesa::darDeAltaMesa($id);
    //     $payload = json_encode(array('Aviso!'=> 'Se ha dado de alta la mesa'));
    //     $response->getBody()->write($payload);
    //     return $response->withHeader('Content-Type', 'application/json');
    // }
    
    // public function BajaMesa($request,$response,$args)
    // {
    //     $parametros = $request->getBody();
    //     $param = json_decode($parametros);
    //     $id = $param->id;
    
    //     Mesa::darDeBajaMesa($id);
    //     $payload = json_encode(array('Aviso!' => 'Se ha dado de baja la mesa'));
    //     $response->getBody()->write($payload);
    //     return $response->withHeader('Content-Type', 'application/json');
    // }
    
    // public function ModificarMesa($request,$response,$args)
    // {
    //     $parametros = $request->getBody();
    //     $param = json_decode($parametros);
    //     // var_dump($param);
    //     $id = $param->id;
    //     $estado = $param->estado;
    //     $identificador = $param->identificador;
    
    //     Mesa::modificarMesa($id,$estado,$identificador);
    //     $payload = json_encode(array('Aviso!' => 'Se ha modificado la mesa'));
    //     $response->getBody()->write($payload);
    //     return $response->withHeader('Content-Type', 'application/json');
    // }


}