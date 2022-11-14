<?php

    class AdministrativoControlador{

        public function RetornarPerfil($request, $response, $args){
            $UsuarioControlador = new UsuarioControlador();
            $Usuario = $UsuarioControlador->BuscarPorCorreo($request, $response, $args);       
            $idUsuario = $Usuario['idUsuario'];

            $listaDeParametros = $request->getParsedBody();
            $email = $listaDeParametros['email'];

            $Administrativo = new Administrativo();
            $Administrativo->setUsuario($idUsuario);
            $objAdmin = $Administrativo->obtenerAdministrativo();
            //$correoAdmin = $Administrativo->obtenerCorreo();
            $objetoAdmin = array_merge($objAdmin,$listaDeParametros);
            $response->getBody()->write(json_encode($objetoAdmin));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarDatos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $dni = $listaDeParametros['dni'];
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];

            //Normalizar datos
            $nombre = ucwords($nombre);
            $apellido = ucwords($apellido);
            $direccion = ucwords($direccion);
            
            $Administrativo = new Administrativo();
            $Administrativo->setDni($dni);
            $Administrativo->setNombre($nombre);
            $Administrativo->setApellido($apellido);
            $Administrativo->setDireccion($direccion);
            $Administrativo->setTelefono($telefono);
            $Administrativo->actualizarDatosAdministrativo();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }

        public function RetornarNombreCompleto($IDUsuario){
            $Administrativo = new Administrativo();
            $Administrativo->setUsuario($IDUsuario);

            return $Administrativo->obtenerNombreCompleto();
        }
    }
?>