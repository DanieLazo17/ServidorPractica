<?php

    class PagoControlador{

        public function PagarCompras($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $importe = $listaDeParametros['importe'];
            $fechaActual = date("Y/m/d");

            //Normalizar datos
            $importe = (float)$importe;

            $UltimoNro = Pago::obtenerUltimoNroPago();
            $NuevoNroPago = $UltimoNro['nroPago'] + 1;

            $Pago = new Pago();
            $Pago->setNroPago($NuevoNroPago);
            $Pago->setImporte($importe);
            $Pago->setFecha($fechaActual);
            $Pago->guardarPago();

            $CuotaControlador = new CuotaControlador();
            $CuotaControlador->RegistrarPago($request, $response, $args, $NuevoNroPago);
            
            $response->getBody()->write("Su número de pago es: " . $NuevoNroPago);
            return $response;
        }
    }
?>