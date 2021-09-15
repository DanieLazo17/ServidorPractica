<?php
    class ClaseControlador{

        public function RetornarClasesDelTipo($request, $response, $args){
            $tipoClase = $args['tipoClase'];

            $arregloDeClases = Clase::obtenerClasesDelTipo($tipoClase);
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>