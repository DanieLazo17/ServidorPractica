<?php

    class SocioControlador{

        public function RetornarSocios($request, $response, $args){  
            $arregloSocios = Socio::obtenerSocios();
            $response->getBody()->write(json_encode($arregloSocios));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarSocio($request, $response, $args){  
            $nroSocio = $args['nroSocio'];

            $objeto = Socio::obtenerSocio($nroSocio);
            $response->getBody()->write(json_encode($objeto));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

    }

?>