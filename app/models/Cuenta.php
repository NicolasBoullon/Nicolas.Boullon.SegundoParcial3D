<?php

require_once "./db/AccesoDatos.php";

class Cuenta
{
    public $id;
    public $nombre;
    public $apellido;
    public $tipoDeDocumento; //DNI
    public $numeroDeDocumento; // 8 digitos
    public $tipoDeCuenta; // Caja de ahorro CA- Cuenta corriente CC
    public $saldo; //por defecto 0
    public $email;
    public $estado;


    public function crearCuenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO tabla_cuentas (nombre, apellido,tipoDeDocumento,numeroDeDocumento,tipoDeCuenta,saldo,email) VALUES (:nombre, :apellido, :tipoDeDocumento, :numeroDeDocumento, :tipoDeCuenta,:saldo,:email)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':tipoDeDocumento', $this->tipoDeDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':numeroDeDocumento', $this->numeroDeDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':tipoDeCuenta', $this->tipoDeCuenta, PDO::PARAM_STR);
        $consulta->bindValue(':saldo', $this->saldo, PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->execute();
    }





}