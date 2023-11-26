<?php

require_once './models/Deposito.php';
require_once './models/Cuenta.php';

class DepositoController
{



    public function DepositarCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $saldoADepositar = $parametros['importeDepositar'];
        $saldoAcumulado = 0;
        $saldoExistente = Cuenta::obtenerSaldoExistente($id);

        $deposito = new Deposito();
        $deposito->idCuenta = $id;
        $deposito->tipoDeCuenta = $tipoDeCuenta;
        $deposito->importeDeposito = $saldoADepositar;

        $deposito->crearDeposito();

        $saldoAcumulado = $saldoADepositar + $saldoExistente;

        Deposito::depositarSaldo($id,$saldoAcumulado);

        $payload = json_encode(array('Aviso!' => "Se ha realizado el deposito correctamente. Saldo actual: $saldoAcumulado"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }



}