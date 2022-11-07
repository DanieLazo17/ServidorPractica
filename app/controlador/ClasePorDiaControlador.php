<?php

    class ClasePorDiaControlador{
        
        public function RetornarClasesPorDia($request, $response, $args){
            $ClasesPorDia = ClasePorDia::obtenerClases();

            $ProximasClases = ClasePorDia::obtenerProximasClases();

            $ClaseControlador = new ClaseControlador();
            $ClasesBases = $ClaseControlador->RetornarClasesBases();

            if( count($ProximasClases) <= ( count($ClasesBases) * 4 ) ){
                ClasePorDiaControlador::GenerarClases($request, $response, $args);
            }
            
            $response->getBody()->write(json_encode($ClasesPorDia));
   
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
            
            foreach($Clases as $Clase){

                $ClasePorDia = new ClasePorDia();
                $ClasePorDia->setIdClase($Clase['idClase']);
                $UltimaFecha = $ClasePorDia->obtenerUltimaFecha();

                $date = date_create($UltimaFecha['fecha']);
                date_add($date,date_interval_create_from_date_string("1 week"));
                $NuevaFecha = date_format($date,"Y-m-d");

                $ClasePorDia->setFecha($NuevaFecha);

                $ClasePorDia->guardarClasePorDia();
            }

            // $response->getBody()->write("Se generó clases correctamente");
            // return $response;
            return;
        }

        public function CrearClasesNuevas($idClase, $fechaDeInicio){
            $ClasePorDia = new ClasePorDia();
            $ClasePorDia->setIdClase($idClase);

            $FechaInicio = date_create($fechaDeInicio);
            $FechaActual = date("Y-m-d");
            $FechaActual = date_create($FechaActual);
            $diff = date_diff($FechaInicio, $FechaActual);            

            $ClasesPorCrear = 4;
            $ClasesARestar = floor($diff->format("%a") / 7);
            $ClasesPorCrear = $ClasesPorCrear - $ClasesARestar;

            $ClasePorDia->setFecha($fechaDeInicio);
            $ClasePorDia->guardarClasePorDia();

            $UltimaFecha = $fechaDeInicio;

            for($x = 0; $x < $ClasesPorCrear; $x++){

                $date = date_create($UltimaFecha);
                date_add($date,date_interval_create_from_date_string("1 week"));
                $NuevaFecha = date_format($date,"Y-m-d");

                $NuevaClasePorDia = new ClasePorDia();
                $NuevaClasePorDia->setIdClase($idClase);
                $NuevaClasePorDia->setFecha($NuevaFecha);
                $NuevaClasePorDia->guardarClasePorDia();
                $UltimaFecha = $NuevaFecha;
            }

            return;
        }
    }
?>