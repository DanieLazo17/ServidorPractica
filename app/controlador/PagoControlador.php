<?php

    class PagoControlador{

        public function PagarCompras($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $importe = $listaDeParametros['importe'];
            $medioPago = $listaDeParametros['medioPago'];
            $fechaActual = date("Y/m/d");

            //Normalizar datos
            $importe = (float)$importe;

            $UltimoNro = Pago::obtenerUltimoNroPago();
            $NuevoNroPago = $UltimoNro['nroPago'] + 1;

            $Pago = new Pago();
            $Pago->setNroPago($NuevoNroPago);
            $Pago->setImporte($importe);
            $Pago->setFecha($fechaActual);
            $Pago->setMedioPago($medioPago);
            $Pago->guardarPago();

            $CompraControlador = new CompraControlador();
            $CompraControlador->RegistrarPago($request, $response, $args, $NuevoNroPago);
            
            $response->getBody()->write("Su número de pago es: " . $NuevoNroPago);
            return $response;
        }

        public function RetornarPagos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $FechaMin = $listaDeParametros['fechaMin'];
            $FechaMax = $listaDeParametros['fechaMax'];
           // $medioPago = $listaDeParametros['medioPago'];

            $Pago = new Pago();
           // $Pago->setMedioPago($medioPago);
            $HistorialPagos = $Pago->obtenerHistorialPagos($FechaMin, $FechaMax);

            $response->getBody()->write(json_encode($HistorialPagos));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>