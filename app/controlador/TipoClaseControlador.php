<?php

    class TipoClaseControlador{

        public function RetornarTiposDeClases($request, $response, $args){
            $arregloTipoDeClases = TipoClase::obtenerTiposDeClases();
            $response->getBody()->write(json_encode($arregloTipoDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function Registrar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];

            $TipoClase = new TipoClase();
            $TipoClase->setNombre($nombre);
            $TipoClase->guardarTipoClase();

            $response->getBody()->write("Tipo de clase agregadó correctamente.");
            return $response;
        }
    }
?>