<?php
    class SalonControlador{

        public function RetornarSalones($request, $response, $args){
            $arregloDeSalones = Salon::obtenerSalones();
            $response->getBody()->write(json_encode($arregloDeSalones));
   
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
?>