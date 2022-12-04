<?php

    class InformeControlador{

        public function RetornarClasesXDia($request, $response, $args){
            $Informe = new Informe();            
            $ClasesXDia = $Informe->obtenerClasesXDia();

            $response->getBody()->write(json_encode($ClasesXDia));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarInscriptosXActividad($request, $response, $args){
            $Informe = new Informe();            
            $InscriptosXActividad = $Informe->obtenerInscriptosXActividad();

            $response->getBody()->write(json_encode($InscriptosXActividad));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>    