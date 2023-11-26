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
    
    public static function obtenerTodasCuentas()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, nombre, apellido,tipoDeDocumento,numeroDeDocumento,tipoDeCuenta,saldo,email,estado FROM tabla_cuentas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cuenta'); // esto lo q hace es parsearlo a un tipo objeto
    }

    public static function ValidarDatosDeCuenta($tipoDeDocumento,$numeroDeDocumento,$email,$tipoDeCuenta,$saldo)
    {
        $validacionEmail = "/@gmail\.com$/";
        $todoOk = TRUE;
        if($tipoDeDocumento !== NULL && $email !== NULL && $tipoDeCuenta !== NULL && $saldo !== NULL)
        {
            if($tipoDeDocumento !== "DNI")
            {
                echo json_encode(["Error!" => "Problema con el tipo de documento ingresado. Debe ser DNI!"]);
                echo "<br>";
                $todoOk = FALSE;
            }
            if(strlen($numeroDeDocumento) != 8 || $numeroDeDocumento < 0)
            {
                echo json_encode(["Error!" => "Problema con el numero de DNI ingresado. Debe ser de 8 digitos!"]);
                echo "<br>";
                $todoOk = FALSE;
    
            }
            if(!preg_match($validacionEmail,$email)) 
            {
                echo json_encode(["Error!" => "Problema con el email ingresado. Debe finalizar con: @gmail.com!"]);
                echo "<br>";
                $todoOk = FALSE;
            }
            if($tipoDeCuenta !== "CA$" && $tipoDeCuenta !== "CAU\$S" && $tipoDeCuenta !== "CC$" && $tipoDeCuenta !== "CCU\$S")
            {
                echo json_encode(["Error!" => "Problema con el tipo de cuenta ingresado. Debe ser CA$ - CC$ para cuenta de ahorro o corriente en pesos o CAU\$S - CCU\$S para cuenta de ahorro o corriente en dolares!"]);
                echo "<br>";
                $todoOk = FALSE;
            }
            if($saldo < 0)
            {
                echo json_encode(["Error!" => "Problema con el saldo ingresado. Debe ser mayor a 0!"]);
                echo "<br>";
                $todoOk = FALSE;
            }
        }
        else{
            $todoOk = FALSE;
        }

        if(!$todoOk)
        {
            return throw new Exception();
        }
        return $todoOk;
        
    }



}