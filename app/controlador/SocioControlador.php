<?php

    class SocioControlador{

        public function RegistrarSocio($request, $response, $args){
            $UsuarioControlador = new UsuarioControlador();
            $UsuarioNuevo = $UsuarioControlador->Registrar($request, $response, $args);
            
            $idUsuario = $UsuarioNuevo['idUsuario'];
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoNro = Socio::obtenerUltimoNroSocio();
            $UltimoNro['nroSocio'] += 1;
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];

            //Normalizar datos
            $nombre = ucwords($nombre);
            $apellido = ucwords($apellido);
            $direccion = ucwords($direccion);

            $ObjetoSocio = new Socio();
            $ObjetoSocio->setNroSocio($UltimoNro['nroSocio']);
            $ObjetoSocio->setNombre($nombre);
            $ObjetoSocio->setApellido($apellido);
            $ObjetoSocio->setDireccion($direccion);
            $ObjetoSocio->setTelefono($telefono);
            $ObjetoSocio->setUsuario($idUsuario);
            
            $ObjetoSocio->guardarSocio();
            $ObjetoSocio->agregarPerfil();
            
            //$response->getBody()->write(json_encode($args));
            $SocioNuevo = array("nroSocio"=>$UltimoNro['nroSocio'], "contrasena"=>$UsuarioNuevo['contrasena']);
            $response->getBody()->write("Socio registrado correctamente. Su número de socio es ".$UltimoNro['nroSocio']. " y su contraseña provisoria es ". $UsuarioNuevo['contrasena']);
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
            $correo = Socio::obtenerCorreo($objeto['usuario']);
            $objetoSocio = array_merge($objeto,$correo);
            $response->getBody()->write(json_encode($objetoSocio));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function InscribirAClase($request, $response, $args){
            $nroSocio = $args['nroSocio'];

            
        }
    }

?>