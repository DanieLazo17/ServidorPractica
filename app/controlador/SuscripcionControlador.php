<?php
    class SuscripcionControlador{

        public function RegistrarSuscripcion($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoNroSuscripcion = Suscripcion::obtenerUltimoNroSuscripcion();
            $UltimoNroClase['idSuscripcion'] += 1;
            $nombre= $listaDeParametros['nombre'];
            $cantClases = $listaDeParametros['cantClases'];
            $descSuscripcion = $listaDeParametros['descSuscripcion'];
            $actividad = $listaDeParametros['actividad'];
            $pago = $listaDeParametros['pago'];
            

            $Suscripcion = new Suscripcion();
            $Suscripcion->setIdSuscripcion($UltimoNroSuscripcion['idSuscripcion']);
            $Suscripcion->setNombre($nombre);
            $Suscripcion->setCantClases($cantClases);
            $Suscripcion->setDescSuscripcion($descSuscripcion);
            $Suscripcion->setActividad($actividad);
            $Suscripcion->setPago($pago);
            $Suscripcion->guardarSuscripcion();

            $SuscripcionNueva = array("idSuscripcion"=>$UltimoNroSuscripcion['idSuscripcion']);
            $response->getBody()->write("Suscripcion generada correctamente.");
            return $response;
        }

        public function RetornarSuscripciones($request, $response, $args){
            $arregloDeSusc = Suscripcion::obtenerSuscripciones();
            $response->getBody()->write(json_encode($arregloDeSusc));
   
            return $response->withHeader('Content-Type', 'application/json');
        }


        public function ActualizarDatos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $idSuscripcion = $args['idSuscripcion'];
            $nombre= $listaDeParametros['nombre'];
            $cantClases = $listaDeParametros['cantClases'];
            $descSuscripcion = $listaDeParametros['descSuscripcion'];
            $actividad = $listaDeParametros['actividad'];
            $pago = $listaDeParametros['pago'];

          
            $Suscripcion = new Suscripcion();
            $Suscripcion->setIdSuscripcion($idSuscripcion);
            $Suscripcion->setNombre($nombre);
            $Suscripcion->setCantClases($cantClases);
            $Suscripcion->setDescSuscripcion($descSuscripcion);
            $Suscripcion->setActividad($actividad);
            $Suscripcion->setPago($pago);
            $Suscripcion->actualizarSuscripcion();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }

        public function RetornarUnaSuscripcion($request, $response, $args){
            $idSuscripcion = $args['idSuscripcion'];

            $Suscripcion = new Suscripcion();
            $Suscripcion->setIdSuscripcion($idSuscripcion);
            $ObjetoSuscripcion = $Suscripcion->obtenerUnaSuscripcion();

            $response->getBody()->write(json_encode($ObjetoSuscripcion));
            return $response->withHeader('Content-Type', 'application/json');
        }


    }
?>