<?php

    class ClasePorDiaControlador{
        
        public function RetornarClasesPorDia($request, $response, $args){
            $arregloDeClases = ClasePorDia::obtenerClases();
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarInscriptos($request, $response, $args){
            $idClasePorDia = $args['idClasePorDia'];

            $ClasePorDia = new ClasePorDia();
            $ClasePorDia->setIdClasePorDia($idClasePorDia);
            $inscriptos = $ClasePorDia->obtenerInscriptos();

            $response->getBody()->write(json_encode($inscriptos));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>