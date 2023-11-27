<?php

require_once './models/Cuenta.php';
require_once './db/AccesoDatos.php';

class CuentaController{

    public function CargarCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
    
        $nombre = $parametros['nombre'];
        $apellido = $parametros['apellido'];
        $tipoDeDocumento = $parametros['tipoDeDocumento'];
        $numeroDeDocumento = $parametros['numeroDeDocumento'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        
        if(isset($_POST['saldo']))
        {
            $saldo = $parametros['saldo'];
        }
        else
        {
            $saldo = 0;
        }
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

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $ultimoID = $objAccesoDatos->obtenerUltimoId();
        $archivo = $_FILES["archivo"]; 
        $archivo["name"] = "$ultimoID-$tipoDeCuenta.jpg";
        $nombre = $archivo["name"];
        $carpeta = "./ImagenesDeCuenta/2023/";
        if (!file_exists($carpeta)) {
            if (!mkdir($carpeta, 0777, true)) {
                echo json_encode(["Error" => "No se pudo crear la carpeta"]);
                return;
            }
        }
        $destino = "./ImagenesDeCuenta/2023/".$nombre;
        move_uploaded_file($archivo["tmp_name"],$destino);

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
    
    public function AltaCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $id = $parametros['id'];
    
        Cuenta::darDeAltaCuenta($id);
        $payload = json_encode(array('Aviso!'=> 'Se ha dado de alta la cuenta'));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function BajaCuenta($request,$response,$args)
    {
        $parametros = $request->getBody();
        $param = json_decode($parametros);
        $id = $param->id;
        $tipoDeCuenta = $param->tipoDeCuenta;
        $e = FALSE;
        $arrayCuentas = Cuenta::obtenerTodasCuentas();
        foreach ($arrayCuentas as $value) 
        {
            if($value->tipoDeCuenta == $tipoDeCuenta && $value->id == $id)
            {
                $e = true;
            }
        }

        if(!$e)
        {
            $payload = json_encode(array('Error!' => 'No hay ninguna cuenta con esos datos!'));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        Cuenta::darDeBajaCuenta($id);

        $carpeta = "./ImagenesBackupCuentas/2023/";
                
        if (!file_exists($carpeta)) {
            if (!mkdir($carpeta, 0777, true)) {
                echo json_encode(["Error" => "No se pudo crear la carpeta"]);
                return;
            }
        }
        
        $nombreDeArchivo = "$id-$tipoDeCuenta.jpg";
        $rutaOrigen = "./ImagenesDeCuenta/2023/" . $nombreDeArchivo;
        $rutaDestino = "./ImagenesBackupCuentas/2023/" . $nombreDeArchivo;
        if (rename($rutaOrigen, $rutaDestino)) {
            echo json_encode(["Aviso" => "Se movio"]);
        } else {
            echo json_encode(["Error" => "No se movio"]);
        }
        $payload = json_encode(array('Aviso!' => 'Se ha dado de baja la cuenta'));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
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