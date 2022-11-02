<?php

    class CuotaControlador{

        public function GenerarCuotasDeSocio($nroSocio){
            //$fechaYHoraActual = date("Y/m/d h:i:sa");
            $fechaActual = date("Y/m/d");
            $anio = date("Y");
            $dia = date("d");
            $suscripcion = (int)date("n");
            $importe = 2000.00;
            //$arregloDeFechas = array();
            $estado = "Emitida";

            $Cuota = new Cuota();
            $Cuota->setSocio($nroSocio);
            $Cuota->setImporte($importe);
            $Cuota->setFechaEmision($fechaActual);
            $Cuota->setEstado($estado);

            for($i = $suscripcion; $i <= 12; ++$i){
                $suscripcionDeCuota = date_create_from_format("n",$i);
                $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                
                $Cuota->setSuscripcion(date_format($suscripcionDeCuota,"M"));
                $Cuota->setFechaVencimiento(date_format($fechaDeVencimiento,"Y/m/d"));
                $Cuota->guardarCuotasDeSocio();
                //array_push($arregloDeFechas, $i);
            }
            
            //$response->getBody()->write($fechaActual);
            //return $response;
            //$response->getBody()->write(json_encode($Cuota));
            //return $response->withHeader('Content-Type', 'application/json');
            return;
        }

        public function GenerarCuotas($request, $response, $args){
            $fechaActual = date("Y/m/d");
            $anio = date("Y");
            $dia = date("d");
            $suscripcion = (int)date("n");
            $importe = 2000.00;
            $estado = "Emitida";

            $SocioControlador = new SocioControlador();
            $arregloSocios = $SocioControlador->RetornarSociosParaGenerarCuotas();

            foreach($arregloSocios as $objetoSocio){

                foreach($objetoSocio as $atr => $valueAtr){
                    $Cuota = new Cuota();
                    $Cuota->setSocio($valueAtr);
                    $Cuota->setImporte($importe);
                    $Cuota->setFechaEmision($fechaActual);
                    $Cuota->setEstado($estado);
                        
                    for($i = $suscripcion; $i <= 12; ++$i){
                        $suscripcionDeCuota = date_create_from_format("n",$i);
                        $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                        
                        $Cuota->setSuscripcion(date_format($suscripcionDeCuota,"M"));
                        $Cuota->setFechaVencimiento(date_format($fechaDeVencimiento,"Y/m/d"));
                        $Cuota->guardarCuotasDeSocio();
                    }
                }
            }
            
            $response->getBody()->write("Se generó cuotas correctamente");
            return $response;
            //$response->getBody()->write(json_encode($arreglo));
            //return $response->withHeader('Content-Type', 'application/json');
        }

        public function ObtenerCuotasDeSocio($request, $response, $args){
            $nroSocio = $args['nroSocio'];

            $Cuota = new Cuota();
            $Cuota->setSocio($nroSocio);
            $Cuota->actualizarEstadoDeCuotas();
            $arregloCuotas = $Cuota->obtenerCuotasEmitOVenc();
            $response->getBody()->write(json_encode($arregloCuotas));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RegistrarPago($request, $response, $args, $pago){
            $listaDeParametros = $request->getParsedBody();
            $cuotas = $listaDeParametros['cuotas'];
            $arregloDeCuotas = json_decode($cuotas);
            $estado = "Pagada";

            for($i = 0; $i < count($arregloDeCuotas); ++$i){
                $Cuota = new Cuota();
                $Cuota->setIdCuota($arregloDeCuotas[$i]);
                $Cuota->setEstado($estado);
                $Cuota->setPago($pago);
                $Cuota->actualizarPagoDeCuota();
            }

            return;
        }

        public function ObtenerEstadoDeCuotas($request, $response, $args){
            $nroSocio = $args['nroSocio'];
            $Cuota = new Cuota();
            $Cuota->setSocio($nroSocio);
            $Cuota->actualizarEstadoDeCuotas();
            $arregloCuotas = $Cuota->obtenerCuotasEmitOVenc();

            $response->getBody()->write(json_encode($arregloCuotas));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>