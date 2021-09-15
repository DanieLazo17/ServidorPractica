<?php

    class TipoClaseControlador{

        public function RetornarTiposDeClases($request, $response, $args){
            $arregloTipoDeClases = TipoClase::obtenerTiposDeClases();
            $response->getBody()->write(json_encode($arregloTipoDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>