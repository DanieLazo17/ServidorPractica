<?php

    class SocioControlador{

        public function RegistrarSocio($request, $response, $args){
            $UsuarioControlador = new UsuarioControlador();
            $UsuarioNuevo = $UsuarioControlador->Registrar($request, $response, $args);
            
            $idUsuario = $UsuarioNuevo['idUsuario'];
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoId = Socio::obtenerUltimoId();
            $UltimoId['nroSocio'] += 1;
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];

            $ObjetoSocio = new Socio();
            $ObjetoSocio->setNroSocio($UltimoId['nroSocio']);
            $ObjetoSocio->setNombre($nombre);
            $ObjetoSocio->setApellido($apellido);
            $ObjetoSocio->setDireccion($direccion);
            $ObjetoSocio->setTelefono($telefono);
            $ObjetoSocio->setUsuario($idUsuario);
            
            $ObjetoSocio->guardarSocio();
            $ObjetoSocio->agregarPerfil();
            
            //$response->getBody()->write(json_encode($args));
            $response->getBody()->write(json_encode($UsuarioNuevo));
            return $response;
        }

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