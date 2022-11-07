<?php

    class ClasePorDiaControlador{
        
        public function RetornarClasesPorDia($request, $response, $args){
            $arregloDeClases = ClasePorDia::obtenerClases();

            $ProximasClases = ClasePorDia::obtenerProximasClases();

            $ClaseControlador = new ClaseControlador();
            $ClasesBases = $ClaseControlador->RetornarClasesBases();

            if( count($ProximasClases) <= ( count($ClasesBases) * 4 ) ){
                ClasePorDiaControlador::GenerarClases($request, $response, $args);
            }
            
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

        public function GenerarClases($request, $response, $args){
            $ClaseControlador = new ClaseControlador();
            $Clases = $ClaseControlador->RetornarClasesBases();
            $ClasesGeneradas = array();
            
            foreach($Clases as $Clase){

                $ClasePorDia = new ClasePorDia();
                $ClasePorDia->setIdClase($Clase['idClase']);
                $UltimaFecha = $ClasePorDia->obtenerUltimaFecha();

                $date=date_create($UltimaFecha['fecha']);
                date_add($date,date_interval_create_from_date_string("1 week"));
                $NuevaFecha = date_format($date,"Y-m-d");

                $ClasePorDia->setFecha($NuevaFecha);

                $ClasePorDia->guardarClasePorDia();
            }

            // $response->getBody()->write("Se generó clases correctamente");
            // return $response;
            return;
        }
    }
?>