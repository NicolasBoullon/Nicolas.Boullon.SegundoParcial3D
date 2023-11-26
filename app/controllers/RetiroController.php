<?php

require_once './models/Retiro.php';
require_once './models/Cuenta.php';

class RetiroController
{



    public function RetirarCuenta($request,$response,$args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $saldoARetirar = $parametros['importeRetirar'];
        $saldoRestante = 0;
        $saldoExistente = Cuenta::obtenerSaldoExistente($id);
        if($saldoExistente < $saldoARetirar)
        {
            $payload = json_encode(array('ERROR!' => "El monto a retirar es mayor al saldo depositado en la cuenta! Saldo de la cuenta: $saldoExistente - Saldo a retirar: $saldoARetirar"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json ');
        }

        $retiro = new Retiro();
        $retiro->idCuenta = $id;
        $retiro->tipoDeCuenta = $tipoDeCuenta;
        $retiro->importeRetiro = $saldoARetirar;

        $retiro->crearRetiro();

        $saldoRestante = $saldoExistente - $saldoARetirar;

        Retiro::retirarSaldo($id,$saldoRestante);

        $payload = json_encode(array('Aviso!' => "Se ha realizado el retiro correctamente. Saldo actual: $saldoRestante"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }




}