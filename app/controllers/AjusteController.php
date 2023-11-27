<?php


require_once './models/Ajuste.php';
require_once './models/Cuenta.php';
require_once './models/Deposito.php';
require_once './models/Retiro.php';


class AjusteController
{

    public function AjustarCuentaDeposito($request,$response,$args)
    {
        $parametros = $request->getParsedBody();

        $idCuenta = $parametros['id'];
        $idAjuste = $parametros['idAjuste'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $motivo = $parametros['motivo'];
        $tipoDeAjuste = "deposito";
        
        $monto = 0;

        $ajuste = new Ajuste();
        $ajuste->idCuenta = $idCuenta;
        $ajuste->idAjuste = $idAjuste;
        $ajuste->tipoDeCuenta = $tipoDeCuenta;
        $ajuste->tipoDeAjuste = $tipoDeAjuste;
        $ajuste->motivo = $motivo;

        $depositos = Deposito::obtenerTodosDepositos();

        // var_dump($depositos);
        for ($i=0; $i < count($depositos); $i++) { 
            if($depositos[$i]->id == $idAjuste && $depositos[$i]->tipoDeCuenta == $tipoDeCuenta)
            {
                $monto = $depositos[$i]->importeDeposito;
                break;
            }
        }
        $saldoEnCuenta = 0 ;
        $cuentas = Cuenta::obtenerTodasCuentas();
        for ($i=0; $i < count($cuentas); $i++) { 
            if($cuentas[$i]->id == $idCuenta && $cuentas[$i]->tipoDeCuenta == $tipoDeCuenta)
            {
                $saldoEnCuenta = $cuentas[$i]->saldo;
                break;
            }
        }
        // var_dump("ASD");
        $saldoAjustar = 0;
        $saldoAjustar = $saldoEnCuenta - $monto;
        
        if($saldoAjustar == 0) 
        {
            $payload = json_encode(array('ERROR!' => "El saldo de la cuenta quedaria negativo. No se pudo hacer el ajuste"));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        $ajuste->importeAjuste = $monto;
        
        try {
            $ajuste->crearAjuste();
        } catch (Exception $e) {
            echo "Error al crear el ajuste: " . $e->getMessage();
            // También podrías loguear este mensaje de error o manejarlo de alguna otra manera
        }

        Cuenta::AjustarCuentaDeposito($idCuenta,$saldoAjustar);

        $payload = json_encode(array('Aviso!' => "Se ha hecho el ajuste correctamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function AjustarCuentaRetiro($request,$response,$args)
    {
        $parametros = $request->getParsedBody();

        $idCuenta = $parametros['id'];
        $idAjuste = $parametros['idAjuste'];
        $tipoDeCuenta = $parametros['tipoDeCuenta'];
        $motivo = $parametros['motivo'];
        $tipoDeAjuste = "retiro";
        
        $monto = 0;

        $ajuste = new Ajuste();
        $ajuste->idCuenta = $idCuenta;
        $ajuste->idAjuste = $idAjuste;
        $ajuste->tipoDeCuenta = $tipoDeCuenta;
        $ajuste->tipoDeAjuste = $tipoDeAjuste;
        $ajuste->motivo = $motivo;

        $retiros = Retiro::obtenerTodosRetiros();

        // var_dump($depositos);
        for ($i=0; $i < count($retiros); $i++) { 
            if($retiros[$i]->id == $idAjuste && $retiros[$i]->tipoDeCuenta == $tipoDeCuenta)
            {
                $monto = $retiros[$i]->importeRetiro;
                break;
            }
        }
        $saldoEnCuenta = 0 ;
        $cuentas = Cuenta::obtenerTodasCuentas();
        for ($i=0; $i < count($cuentas); $i++) { 
            if($cuentas[$i]->id == $idCuenta && $cuentas[$i]->tipoDeCuenta == $tipoDeCuenta)
            {
                $saldoEnCuenta = $cuentas[$i]->saldo;
                break;
            }
        }
        // var_dump("ASD");
        $saldoAjustar = 0;
        $saldoAjustar = $saldoEnCuenta + $monto;
        
        $ajuste->importeAjuste = $monto;
        
        try {
            $ajuste->crearAjuste();
        } catch (Exception $e) {
            echo "Error al crear el ajuste: " . $e->getMessage();
            // También podrías loguear este mensaje de error o manejarlo de alguna otra manera
        }

        Cuenta::AjustarCuentaDeposito($idCuenta,$saldoAjustar);

        $payload = json_encode(array('Aviso!' => "Se ha hecho el ajuste correctamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }




}