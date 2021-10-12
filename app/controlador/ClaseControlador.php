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
    }
?>