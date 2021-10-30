<?php
    class SalonControlador{

        public function RetornarSalones($request, $response, $args){
            $arregloDeSalones = Salon::obtenerSalones();
            $response->getBody()->write(json_encode($arregloDeSalones));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function Actualizar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $idSalon = $args['idSalon'];
            $nombreSalon = $listaDeParametros['nombreSalon'];
            $capacidad = $listaDeParametros['capacidad'];
            $estado = $listaDeParametros['estado'];

            //Normalizar datos
            $nombreSalon = ucwords($nombreSalon);
            $capacidad = (int)$capacidad;
            $estado = ucfirst($estado);
            
            $Salon = new Salon();
            $Salon->setIdSalon($idSalon);
            $Salon->setNombreSalon($nombreSalon);
            $Salon->setCapacidad($capacidad);
            $Salon->setEstado($estado);
            $Salon->actualizarDatos();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }
    }
?>