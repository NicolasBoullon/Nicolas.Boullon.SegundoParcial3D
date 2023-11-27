<?php

require_once './db/AccesoDatos.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');

class Retiro
{
    public $id;
    public $idCuenta;
    public $tipoDeCuenta;
    public $importeRetiro;
    public $fechaRetiro;

    public  function crearRetiro()
    {               
        $fechaRetiro = date('Y-m-d H:i:s');
        // $ajuste = "retiro";

        $objAccesoADatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoADatos->prepararConsulta("INSERT INTO tabla_retiros (idCuenta,tipoDeCuenta,importeRetiro,fechaRetiro)  VALUES (:idCuenta,:tipoDeCuenta,:importeRetiro,:fechaRetiro)");
        $importe = $this->importeRetiro;
        $montoCadena = sprintf("%.2f", $importe);


        $consulta->bindValue(':idCuenta', $this->idCuenta, PDO::PARAM_INT);
        $consulta->bindValue(':tipoDeCuenta', $this->tipoDeCuenta, PDO::PARAM_STR);
        // $consulta->bindValue(':tipoDeAjuste', $ajuste, PDO::PARAM_STR);
        $consulta->bindValue(':importeRetiro', $montoCadena, PDO::PARAM_STR);
        $consulta->bindValue(':fechaRetiro', $fechaRetiro, PDO::PARAM_STR);
        $consulta->execute();
    }


    public static function retirarSaldo($id,$saldoARetirar)
    {
        $montoCadena = sprintf("%.2f", $saldoARetirar);
        $objAccesoADatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoADatos->prepararConsulta("UPDATE tabla_cuentas SET saldo = :saldo WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':saldo', $montoCadena, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function obtenerTodosRetiros()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, idCuenta,tipoDeCuenta,importeRetiro,fechaRetiro FROM tabla_retiros");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Retiro'); // esto lo q hace es parsearlo a un tipo objeto
    }

}