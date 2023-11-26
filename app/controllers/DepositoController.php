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

        $saldoAcumulado = $saldoADepositar + $saldoExistente;

        Deposito::depositarSaldo($id,$saldoAcumulado);

        $payload = json_encode(array('Aviso!' => 'Se ha realizado el deposito correctamente'));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }



}