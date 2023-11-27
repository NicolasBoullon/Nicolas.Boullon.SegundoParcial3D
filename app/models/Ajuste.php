<?php

require_once "./db/AccesoDatos.php";
date_default_timezone_set('America/Argentina/Buenos_Aires');
class Ajuste
{
    public $id;
    public $idCuenta;
    public $idAjuste;
    public $tipoDeCuenta;
    public $tipoDeAjuste;
    public $importeAjuste;
    public $motivo;
    public $fechaAjuste;



    public function crearAjuste()
    {
        $fechaAjuste = date('Y-m-d H:i:s');
        $montoCadena = sprintf("%.2f", $this->importeAjuste);
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO tabla_ajustes (idCuenta,idAjuste,tipoDeAjuste,tipoDeCuenta,importeAjuste,motivo,fechaAjuste) VALUES (:idCuenta,:idAjuste,:tipoDeAjuste,:tipoDeCuenta,:importeAjuste,:motivo,:fechaAjuste)");
        $consulta->bindValue(':idCuenta', $this->idCuenta, PDO::PARAM_INT);
        $consulta->bindValue(':idAjuste', $this->idAjuste, PDO::PARAM_INT);
        $consulta->bindValue(':tipoDeAjuste', $this->tipoDeAjuste, PDO::PARAM_STR);
        $consulta->bindValue(':tipoDeCuenta', $this->tipoDeCuenta, PDO::PARAM_STR);
        $consulta->bindValue(':importeAjuste', $montoCadena, PDO::PARAM_STR);
        $consulta->bindValue(':motivo', $this->motivo, PDO::PARAM_STR);
        $consulta->bindValue(':fechaAjuste', $fechaAjuste, PDO::PARAM_STR);
        $consulta->execute();
    }

}