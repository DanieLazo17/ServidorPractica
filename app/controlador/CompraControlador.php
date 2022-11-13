<?php

    class CompraControlador{

        public function GenerarComprasDeSocio($nroSocio){
            //$fechaYHoraActual = date("Y/m/d h:i:sa");
            $fechaActual = date("Y/m/d");
            $anio = date("Y");
            $dia = date("d");
            $suscripcion = (int)date("n");
            $importe = 2000.00;
            //$arregloDeFechas = array();
            $estado = "Emitida";

            $Compra = new Compra();
            $Compra->setSocio($nroSocio);
            $Compra->setImporte($importe);
            $Compra->setFechaEmision($fechaActual);
            $Compra->setEstado($estado);

            for($i = $suscripcion; $i <= 12; ++$i){
                $suscripcionDeCompra = date_create_from_format("n",$i);
                $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                
                $Compra->setSuscripcion(date_format($suscripcionDeCompra,"M"));
                $Compra->setFechaVencimiento(date_format($fechaDeVencimiento,"Y/m/d"));
                $Compra->guardarComprasDeSocio();
                //array_push($arregloDeFechas, $i);
            }
            
            //$response->getBody()->write($fechaActual);
            //return $response;
            //$response->getBody()->write(json_encode($Compra));
            //return $response->withHeader('Content-Type', 'application/json');
            return;
        }

        public function GenerarCompras($request, $response, $args){
            $fechaActual = date("Y/m/d");
            $anio = date("Y");
            $dia = date("d");
            $suscripcion = (int)date("n");
            $importe = 2000.00;
            $estado = "Emitida";

            $SocioControlador = new SocioControlador();
            $arregloSocios = $SocioControlador->RetornarSociosParaGenerarCompras();

            foreach($arregloSocios as $objetoSocio){

                foreach($objetoSocio as $atr => $valueAtr){
                    $Compra = new Compra();
                    $Compra->setSocio($valueAtr);
                    $Compra->setImporte($importe);
                    $Compra->setFechaEmision($fechaActual);
                    $Compra->setEstado($estado);
                        
                    for($i = $suscripcion; $i <= 12; ++$i){
                        $suscripcionDeCompra = date_create_from_format("n",$i);
                        $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                        
                        $Compra->setSuscripcion(date_format($suscripcionDeCompra,"M"));
                        $Compra->setFechaVencimiento(date_format($fechaDeVencimiento,"Y/m/d"));
                        $Compra->guardarComprasDeSocio();
                    }
                }
            }
            
            $response->getBody()->write("Se generó compras correctamente");
            return $response;
            //$response->getBody()->write(json_encode($arreglo));
            //return $response->withHeader('Content-Type', 'application/json');
        }

        public function AdquirirSuscripcion($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nroSocio = $listaDeParametros['nroSocio'];
            $idSuscripcion = $listaDeParametros['idSuscripcion'];
            
            $SuscripcionControlador = new SuscripcionControlador();
            $ImporteSuscripcion = $SuscripcionControlador->RetornarImporte($request, $response, $args);

            $Compra = new Compra();
            $Compra->setSuscripcion($idSuscripcion);
            $Compra->setSocio($nroSocio);            
            $Compra->setImporte($ImporteSuscripcion['precio']);
            $Compra->setEstado("Emitida");
            $Compra->guardarCompraDeSocio();

            $response->getBody()->write("Suscripción agregada correctamente");
            return $response;
            // $response->getBody()->write(json_encode($ImporteSuscripcion));
            // return $response->withHeader('Content-Type', 'application/json');
        }

        public function ObtenerComprasDeSocio($request, $response, $args){
            $nroSocio = $args['nroSocio'];

            $Compra = new Compra();
            $Compra->setSocio($nroSocio);
            $Compra->actualizarEstadoDeCompras();
            $arregloCompras = $Compra->obtenerComprasEmitOVenc();
            $response->getBody()->write(json_encode($arregloCompras));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RegistrarPago($request, $response, $args, $pago){
            $listaDeParametros = $request->getParsedBody();
            $IDCompra = $listaDeParametros['idCompra'];            

            $FechaActual = date("Y-m-d");
            $date = date_create($FechaActual);
            date_add($date,date_interval_create_from_date_string("30 days"));
            $FechaVencimiento = date_format($date,"Y-m-d");
            
            $Compra = new Compra();
            $Compra->setIdCompra($IDCompra);
            $Compra->setFechaEmision($FechaActual);
            $Compra->setFechaVencimiento($FechaVencimiento);
            $Compra->setEstado("Pagada");
            $Compra->setPago($pago);
            $Compra->pagarCompra();

            return;
        }

        public function ObtenerEstadoDeCompras($request, $response, $args){
            $nroSocio = $args['nroSocio'];
            $Compra = new Compra();
            $Compra->setSocio($nroSocio);
            $Compra->actualizarEstadoDeCompras();
            $arregloCompras = $Compra->obtenerComprasEmitOVenc();

            $response->getBody()->write(json_encode($arregloCompras));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>