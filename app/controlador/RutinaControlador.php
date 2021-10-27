<?php
    class RutinaControlador{

        public function Registrar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            //Normalizar datos
            $nombre = ucfirst($listaDeParametros['nombre']);
            $descripcion = ucfirst($listaDeParametros['descripcion']);
            $salon = (int)$listaDeParametros['salon'];

            $Rutina = new Rutina();
            $Rutina->setNombre($nombre);
            $Rutina->setDescripcion($descripcion);
            $Rutina->setSalon($salon);
            $Rutina->guardarRutina();

            $response->getBody()->write("Se agregó nueva rutina correctamente");
            return $response;
        }

        public function RetornarRutinas($request, $response, $args){
            $arregloDeRutinas = Rutina::obtenerRutinas();
            $response->getBody()->write(json_encode($arregloDeRutinas));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function Actualizar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $idRutina = $args['idRutina'];
            
            //Normalizar datos
            $nombre = ucfirst($listaDeParametros['nombre']);
            $descripcion = ucfirst($listaDeParametros['descripcion']);
            $salon = (int)$listaDeParametros['salon'];

            $Rutina = new Rutina();
            $Rutina->setIdRutina($idRutina);
            $Rutina->setNombre($nombre);
            $Rutina->setDescripcion($descripcion);
            $Rutina->setSalon($salon);
            $Rutina->actualizarDatos();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }
    }
?>