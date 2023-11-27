<?php

require_once './db/AccesoDatos.php';
require_once './models/Cuenta.php';

class Consultar{

    // public static function consultarCuentaExistente($numeroDeCuenta, $tipoDeCuenta)
    // {
    //     $objAccesoDatos = AccesoDatos::obtenerInstancia();
    //     $consutla = $objAccesoDatos->prepararConsulta('SELECT (numreroDeCuenta, tipoDeCuenta) FROM tabla_cuentas WHERE (')
    // }


    public static function depositadoPorFecha($tipoDeCuenta, $fechaDeposito)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(importeDeposito) FROM tabla_depositos WHERE tipoDeCuenta = :tipoDeCuenta AND DATE(fechaDeposito) = :fechaDeposito");
        $consulta->bindValue(':tipoDeCuenta', $tipoDeCuenta, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDeposito', $fechaDeposito, PDO::PARAM_STR);
        $consulta->execute();
    
        return $consulta->fetchColumn();

    }

    public static function depositadoPorUsuario($dni)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT tabla_depositos.id,idCuenta,tabla_depositos.tipoDeCuenta,importeDeposito,fechaDeposito,tabla_cuentas.numeroDeDocumento FROM tabla_depositos JOIN tabla_cuentas ON tabla_cuentas.id = tabla_depositos.idCuenta WHERE tabla_cuentas.numeroDeDocumento = :numeroDeDocumento");
        $consulta->bindValue(':numeroDeDocumento', $dni, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        $consulta->execute();
        // var_dump($consulta->fetchColumn());
        return $consulta->fetchAll();
    }

    public static function depositadoPorDosFechas($fechaUno, $fechaDos)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT tabla_depositos.id, idCuenta, tabla_depositos.tipoDeCuenta, importeDeposito, fechaDeposito, tabla_cuentas.nombre FROM tabla_depositos JOIN tabla_cuentas ON tabla_cuentas.id = tabla_depositos.idCuenta WHERE fechaDeposito BETWEEN :fechaUno AND :fechaDos");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
        $consulta->execute();
        return $consulta->fetchAll();
    }

    public static function ObtenerDiaAnterior()
    {
        $date = date("d-m-y");
        $fechaDividida = explode('-',$date);
        $dia = $fechaDividida[0];
        $mes = $fechaDividida[1];
        $anio = $fechaDividida[2];
        $nuevoDate;
        
        if($dia == 1)
        {
            if($mes == 2 || $mes == 4 || $mes == 6 || $mes == 9 || $mes == 11)
            {
                $dia = 31;
                $mes = $mes - 1;
                $anio = $anio;
            }
            elseif($mes == 1)
            {
                $dia = 31;
                $mes = 12;
                $anio = $anio - 1; 
            }
            elseif($mes == 3)
            {
                $dia = 28;
                $mes -= 1;
            }
            else
            {
                $dia = 30;
                $mes -=1;
            }
        }
        else
        {
            $dia = $dia - 1;
            $mes = $mes;
            $anio = $anio; 
        }
        $nuevoDate = date("$dia-$mes-$anio");
        return $nuevoDate;
    }
}