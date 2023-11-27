<?php

require_once './db/AccesoDatos.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');
class Deposito
{
    public $id;
    public $idCuenta; //numeroDeCuenta
    public $tipoDeCuenta;
    public $importeDeposito;
    public $fechaDeposito;
    

    
    public  function crearDeposito()
    {               
        // var_dump("ASD");
        $fechaDeposito = date('Y-m-d H:i:s');
        // $ajuste = "deposito";
        $objAccesoADatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoADatos->prepararConsulta("INSERT INTO tabla_depositos (idCuenta,tipoDeCuenta,importeDeposito,fechaDeposito)  VALUES (:idCuenta,:tipoDeCuenta,:importeDeposito,:fechaDeposito)");
        
        $importe = $this->importeDeposito;
        $montoCadena = sprintf("%.2f", $importe);

        $consulta->bindValue(':idCuenta', $this->idCuenta, PDO::PARAM_INT);
        $consulta->bindValue(':tipoDeCuenta', $this->tipoDeCuenta, PDO::PARAM_STR);
        $consulta->bindValue(':importeDeposito', $montoCadena, PDO::PARAM_STR);
        // $consulta->bindValue(':tipoDeAjuste', $ajuste, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDeposito', $fechaDeposito, PDO::PARAM_STR);
        $consulta->execute();
    }


    public static function depositarSaldo($id,$saldoADepositar)
    {
        $montoCadena = sprintf("%.2f", $saldoADepositar);
        $objAccesoADatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoADatos->prepararConsulta("UPDATE tabla_cuentas SET saldo = :saldo WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':saldo', $montoCadena, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function obtenerTodosDepositos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, idCuenta,tipoDeCuenta,importeDeposito,fechaDeposito FROM tabla_depositos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Deposito'); // esto lo q hace es parsearlo a un tipo objeto
    }
}