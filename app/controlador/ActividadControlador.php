<?php

    class ActividadControlador{

        public function RetornarActividades($request, $response, $args){
            $arregloActividades = Actividad::obtenerActividades();
            $response->getBody()->write(json_encode($arregloActividades));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function Registrar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];

            $Actividad = new Actividad();
            $Actividad->setNombre($nombre);
            $Actividad->guardarActividad();

            $response->getBody()->write("Actividad agregada correctamente.");
            return $response;
        }
    }
?>