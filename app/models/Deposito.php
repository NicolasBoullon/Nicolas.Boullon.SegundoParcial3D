<?php

require_once './db/AccesoDatos.php';

class Deposito
{
    public $id;
    public $idCuenta; //numeroDeCuenta
    public $tipoDeCuenta;
    public $importeDeposito;
    public $fechaDeposito;


    



    public static function depositarSaldo($id,$saldoADepositar)
    {
        $montoCadena = sprintf("%.2f", $saldoADepositar);
        $objAccesoADatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoADatos->prepararConsulta("UPDATE tabla_cuentas SET saldo = :saldo WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':saldo', $montoCadena, PDO::PARAM_STR);
        $consulta->execute();
    }

}