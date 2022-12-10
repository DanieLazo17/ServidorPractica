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

        public function RetornarSuscripcionesActivas($request, $response, $args){
            $Informe = new Informe();            
            $SuscripcionesActivas = $Informe->obtenerSuscripcionesActivas();

            $response->getBody()->write(json_encode($SuscripcionesActivas));
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function RetornarTotalSocios($request, $response, $args){
            $Informe = new Informe();            
            $total = $Informe->obtenerTotalSocios();

            $response->getBody()->write(json_encode($total));
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function RetornarTotalProfes($request, $response, $args){
            $Informe = new Informe();            
            $total = $Informe->obtenerTotalProfes();

            $response->getBody()->write(json_encode($total));
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function RetornarTotalClases($request, $response, $args){
            $Informe = new Informe();            
            $total = $Informe->obtenerTotalClases();

            $response->getBody()->write(json_encode($total));
            return $response->withHeader('Content-Type', 'application/json');
        }
        public function RetornarTotalRutinas($request, $response, $args){
            $Informe = new Informe();            
            $total = $Informe->obtenerTotalRutinas();

            $response->getBody()->write(json_encode($total));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>    