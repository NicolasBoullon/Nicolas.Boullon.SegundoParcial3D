<?php

class Modificar{


    public static function modCuenta($id,$nombre,$apellido,$numeroDeDocumento,$email)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE tabla_cuentas SET nombre = :nombre, apellido = :apellido, numeroDeDocumento = :numeroDeDocumento, email = :email WHERE id = :id");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $apellido, PDO::PARAM_STR);
        $consulta->bindValue(':numeroDeDocumento', $numeroDeDocumento, PDO::PARAM_STR);
        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
    }

}