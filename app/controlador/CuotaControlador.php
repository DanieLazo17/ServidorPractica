<?php

    class CuotaControlador{

        public function GenerarCuotasDeSocio($nroSocio){
            //$fechaYHoraActual = date("Y/m/d h:i:sa");
            $fechaActual = date("Y/m/d");
            $anio = date("Y");
            $dia = date("d");
            $mes = (int)date("n");
            $importe = 2000.00;
            //$arregloDeFechas = array();

            $Cuota = new Cuota();
            $Cuota->setSocio($nroSocio);
            $Cuota->setImporte($importe);
            $Cuota->setFechaEmision($fechaActual);

            for($i = $mes; $i <= 12; ++$i){
                $mesDeCuota = date_create_from_format("n",$i);
                $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                
                $Cuota->setMes(date_format($mesDeCuota,"M"));
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
            $mes = (int)date("n");
            $importe = 2000.00;

            $SocioControlador = new SocioControlador();
            $arregloSocios = $SocioControlador->RetornarSociosParaGenerarCuotas();

            foreach($arregloSocios as $objetoSocio){

                foreach($objetoSocio as $atr => $valueAtr){
                    if($atr == 'nroSocio'){
                        $Cuota = new Cuota();
                        $Cuota->setSocio($valueAtr);
                        $Cuota->setImporte($importe);
                        $Cuota->setFechaEmision($fechaActual);
                        
                        for($i = $mes; $i <= 12; ++$i){
                            $mesDeCuota = date_create_from_format("n",$i);
                            $fechaDeVencimiento = date_create($anio ."-". (string)$i ."-". (string)10);
                            
                            $Cuota->setMes(date_format($mesDeCuota,"M"));
                            $Cuota->setFechaVencimiento(date_format($fechaDeVencimiento,"Y/m/d"));
                            $Cuota->guardarCuotasDeSocio();
                        }
                    }
                }
            }
            
            $response->getBody()->write("Se generó cuotas correctamente");
            return $response;
            //$response->getBody()->write(json_encode($Cuota));
            //return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>