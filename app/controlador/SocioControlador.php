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
            $fechaActual = date("Y/m/d");
            $estado = "HAB";

            $ObjetoSocio = new Socio();
            $ObjetoSocio->setNroSocio($UltimoNro['nroSocio']);
            $ObjetoSocio->setNombre($nombre);
            $ObjetoSocio->setApellido($apellido);
            $ObjetoSocio->setDireccion($direccion);
            $ObjetoSocio->setTelefono($telefono);
            $ObjetoSocio->setEstado($estado);
            $ObjetoSocio->setUsuario($idUsuario);
            $ObjetoSocio->setFechaDeAlta($fechaActual);
            
            $ObjetoSocio->guardarSocio();
            $ObjetoSocio->agregarPerfil();
            $CuotaControlador = new CuotaControlador();
            $CuotaControlador->GenerarCuotasDeSocio($UltimoNro['nroSocio']);
            
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

        public function RetornarSociosParaGenerarCuotas(){  
            $arregloSocios = Socio::obtenerSociosParaGenerarCuotas();
   
            return $arregloSocios;
        }

        public function RetornarSocio($request, $response, $args){  
            $nroSocio = $args['nroSocio'];

            $Socio = new Socio();
            $Socio->setNroSocio($nroSocio);
            $objeto = $Socio->obtenerSocio();
            $correo = Socio::obtenerCorreo($objeto['usuario']);
            $objetoSocio = array_merge($objeto,$correo);
            $response->getBody()->write(json_encode($objetoSocio));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function InscribirAClase($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();

            $nroSocio = $listaDeParametros['nroSocio'];
            $idClase = $listaDeParametros['idClase'];

            $ObjetoSocio = new Socio();
            $ObjetoSocio->setNroSocio($nroSocio);
            $ObjetoSocio->guardarInscripcionAClase($idClase);

            $response->getBody()->write("Se realizó inscripción correctamente");
            return $response;
        }

        public function ActualizarDatos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];
            $nroSocio = $args['nroSocio'];

            //Normalizar datos
            $nombre = ucwords($nombre);
            $apellido = ucwords($apellido);
            $direccion = ucwords($direccion);
            
            $Socio = new Socio();
            $Socio->setNroSocio($nroSocio);
            $Socio->setNombre($nombre);
            $Socio->setApellido($apellido);
            $Socio->setDireccion($direccion);
            $Socio->setTelefono($telefono);
            $Socio->actualizarDatosSocio();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }

        public function ActualizarDireccion($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $direccion = $listaDeParametros['direccion'];
            $nroSocio = $args['nroSocio'];
            
            $Socio = new Socio();
            $Socio->setNroSocio($nroSocio);
            $Socio->setDireccion($direccion);
            $Socio->guardarDireccion();

            $response->getBody()->write("Se actualizó dirección personal correctamente");
            return $response;
        }

        public function ActualizarTelefono($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $telefono = $listaDeParametros['telefono'];
            $nroSocio = $args['nroSocio'];
            
            $Socio = new Socio();
            $Socio->setNroSocio($nroSocio);
            $Socio->setTelefono($telefono);
            $Socio->guardarTelefono();

            $response->getBody()->write("Se actualizó teléfono personal correctamente");
            return $response;
        }

        public function DeshabilitarSocio($request, $response, $args){
            $nroSocio = $args['nroSocio'];
            $estado = "DESHAB";

            $Socio = new Socio();
            $Socio->setNroSocio($nroSocio);
            $Socio->setEstado($estado);
            $Socio->suspenderSocio();

            $response->getBody()->write("Se deshabilitó socio");
            return $response;
        }
    }

?>