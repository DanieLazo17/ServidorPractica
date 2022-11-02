<?php
    class SuscripcionControlador{

        public function RegistrarSuscripcion($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoNroSuscripcion = Clase::obtenerUltimoNroSuscripcion();
            $UltimoNroClase['idSuscripcion'] += 1;
            $nombre= $listaDeParametros['nombre'];
            $cantClases = $listaDeParametros['cantClases'];
            $descSuscripcion = $listaDeParametros['descSuscripcion'];
            $actividad = $listaDeParametros['actividad'];
            

            $Suscripcion = new Suscripcion();
            $Suscripcion->setIdSuscripcion($UltimoNroSuscripcion['idSuscripcion']);
            $Suscripcion->setNombre($nombre);
            $Suscripcion->setCantClases($cantClases);
            $Suscripcion->setDescSuscripcion($descSuscripcion);
            $Suscripcion->setActividad($actividad);
            $Suscripcion->guardarSuscripcion();

            $SuscripcionNueva = array("idSuscripcion"=>$UltimoNroSuscripcion['idSuscripcion']);
            $response->getBody()->write("Suscripcion generada correctamente.");
            return $response;
        }

        public function RetornarSuscripcion($request, $response, $args){
            $arregloDeClases = Clase::obtenerSuscripciones();
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>