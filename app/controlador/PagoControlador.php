<?php

    class PagoControlador{

        public function PagarCuotas($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $importe = $listaDeParametros['importe'];
            $fechaActual = date("Y/m/d");

            //Normalizar datos
            $importe = (float)$importe;

            $UltimoNro = Pago::obtenerUltimoNroPago();
            $UltimoNro['nroPago'] += 1;

            $Pago = new Pago();
            $Pago->setNroPago($UltimoNro['nroPago']);
            $Pago->setImporte($importe);
            $Pago->setFecha($fechaActual);
            $Pago->guardarPago();

            $CuotaControlador = new CuotaControlador();
            $CuotaControlador->RegistrarPago($request, $response, $args, $UltimoNro['nroPago']);

            //Devolver nroPago en write("Mensaje")
            $response->getBody()->write("Su número de pago es: " . $UltimoNro['nroPago']);
            return $response;
        }
    }
?>