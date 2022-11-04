<?php

    class ClasePorDiaControlador{
        
        public function RetornarClasesPorDia($request, $response, $args){
            $arregloDeClases = ClasePorDia::obtenerClases();
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>