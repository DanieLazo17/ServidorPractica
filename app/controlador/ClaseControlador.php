<?php
    class ClaseControlador{

        public function RegistrarClase($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoNroClase = Clase::obtenerUltimoNroClase();
            $UltimoNroClase['idClase'] += 1;
            $tipoClase = $listaDeParametros['tipoClase'];
            $modalidad = $listaDeParametros['modalidad'];
            $dias = $listaDeParametros['dias'];
            $horaDeInicio = $listaDeParametros['horaDeInicio'];
            $horaDeFin = $listaDeParametros['horaDeFin'];
            $fechaDeInicio = $listaDeParametros['fechaDeInicio'];
            $fechaDeFin = $listaDeParametros['fechaDeFin'];
            $cupos = $listaDeParametros['cupos'];
            $profesor = $listaDeParametros['profesor'];
            $salon = $listaDeParametros['salon'];

            $Clase = new Clase();
            $Clase->setIdClase($UltimoNroClase['idClase']);
            $Clase->setTipoClase($tipoClase);
            $Clase->setDias($dias);
            $Clase->setHoraDeInicio($horaDeInicio);
            $Clase->setHoraDeFin($horaDeFin);
            $Clase->setFechaDeInicio($fechaDeInicio);
            $Clase->setFechaDeFin($fechaDeFin);
            $Clase->setProfesor($profesor);
            $Clase->setSalon($salon);
            $Clase->setCupos($cupos);
            $Clase->setModalidad($modalidad);
            $Clase->guardarClase();

            $ClaseNueva = array("idClase"=>$UltimoNroClase['idClase']);
            $response->getBody()->write("Clase generada correctamente.");
            return $response;
        }

        public function RetornarClasesDelTipo($request, $response, $args){
            $tipoClase = $args['tipoClase'];

            $arregloDeClases = Clase::obtenerClasesDelTipo($tipoClase);
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarClasesEnCurso($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $dias = $listaDeParametros['dias'];

            $Clase = new Clase();
            $Clase->setDias($dias);
            $arregloDeClases = $Clase->buscarClases();

            $response->getBody()->write(json_encode($arregloDeClases));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarClasesDelProfesor($request, $response, $args){
            $legajo = $args['legajo'];

            $Clase = new Clase();
            $Clase->setProfesor($legajo);
            $arregloDeClases = $Clase->obtenerClasesDelProfesor();

            $response->getBody()->write(json_encode($arregloDeClases));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarClases($request, $response, $args){
            $arregloDeClases = Clase::obtenerClases();
            $response->getBody()->write(json_encode($arregloDeClases));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarDatos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $idClase = $args['idClase'];
            $tipoClase = $listaDeParametros['tipoClase'];
            $modalidad = $listaDeParametros['modalidad'];
            $dias = $listaDeParametros['dias'];
            $horaDeInicio = $listaDeParametros['horaDeInicio'];
            $horaDeFin = $listaDeParametros['horaDeFin'];
            $fechaDeInicio = $listaDeParametros['fechaDeInicio'];
            $fechaDeFin = $listaDeParametros['fechaDeFin'];
            $cupos = $listaDeParametros['cupos'];
            $profesor = $listaDeParametros['profesor'];
            $salon = $listaDeParametros['salon'];

            //Normalizar datos
            $dias = ucwords($dias);
            $modalidad = ucwords($modalidad);
            
            $Clase = new Clase();
            $Clase->setIdClase($idClase);
            $Clase->setTipoClase($tipoClase);
            $Clase->setDias($dias);
            $Clase->setHoraDeInicio($horaDeInicio);
            $Clase->setHoraDeFin($horaDeFin);
            $Clase->setFechaDeInicio($fechaDeInicio);
            $Clase->setFechaDeFin($fechaDeFin);
            $Clase->setProfesor($profesor);
            $Clase->setSalon($salon);
            $Clase->setCupos($cupos);
            $Clase->setModalidad($modalidad);
            $Clase->actualizarDatosClase();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }

        public function RetornarClase($request, $response, $args){
            $idClase = $args['idClase'];

            $Clase = new Clase();
            $Clase->setIdClase($idClase);
            $ObjetoClase = $Clase->obtenerClase();

            $response->getBody()->write(json_encode($ObjetoClase));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarSociosDeClase($request, $response, $args){
            $idClase = $args['idClase'];

            $Clase = new Clase();
            $Clase->setIdClase($idClase);
            $arregloDeSocios = $Clase->obtenerSocios();

            $response->getBody()->write(json_encode($arregloDeSocios));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>