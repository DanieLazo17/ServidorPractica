<?php

    class ProfesorControlador{

        public function RegistrarProfesor($request, $response, $args){
            $UsuarioControlador = new UsuarioControlador();
            $UsuarioNuevo = $UsuarioControlador->Registrar($request, $response, $args);
            
            $idUsuario = $UsuarioNuevo['idUsuario'];
            $listaDeParametros = $request->getParsedBody();
            
            $UltimoLegajo = Profesor::obtenerUltimoLegajo();
            $UltimoLegajo['legajo'] += 1;
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];
            $especialidad = $listaDeParametros['especialidad'];

            //Normalizar datos
            $nombre = ucwords($nombre);
            $apellido = ucwords($apellido);
            $direccion = ucwords($direccion);
            $especialidad = ucwords($especialidad);
            $fechaActual = date("Y/m/d");
            $estado = "HAB";

            $Profesor = new Profesor();
            $Profesor->setLegajo($UltimoLegajo['legajo']);
            $Profesor->setNombre($nombre);
            $Profesor->setApellido($apellido);
            $Profesor->setDireccion($direccion);
            $Profesor->setTelefono($telefono);
            $Profesor->setEspecialidad($especialidad);
            $Profesor->setUsuario($idUsuario);
            $Profesor->setEstado($estado);
            $Profesor->setFechaDeAlta($fechaActual);
            $Profesor->guardarProfesor();
            $Profesor->agregarPerfil();
            $ProfesorNuevo = array("nroSocio"=>$UltimoLegajo['legajo'], "contrasena"=>$UsuarioNuevo['contrasena']);

            $response->getBody()->write("Profesor registrado correctamente. Su número de legajo es ".$UltimoLegajo['legajo']. " y su contraseña provisoria es ". $UsuarioNuevo['contrasena']);
            return $response;
        }

        public function RetornarProfesores($request, $response, $args){  
            $arregloProfesores = Profesor::obtenerProfesores();
            $response->getBody()->write(json_encode($arregloProfesores));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function RetornarProfesor($request, $response, $args){
            $legajo = $args['legajo'];

            $Profesor = new Profesor();
            $Profesor->setLegajo($legajo);
            $objProfesor = $Profesor->obtenerProfesor();
            $Profesor->setUsuario($objProfesor['usuario']);
            $correoDeProfesor = $Profesor->obtenerCorreo();
            $objetoProfesor = array_merge($objProfesor,$correoDeProfesor);
            $response->getBody()->write(json_encode($objetoProfesor));
   
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function TraerProfesoresPorEsp($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $especialidad = $listaDeParametros['especialidad'];

            $Profesor = new Profesor();
            $Profesor->setEspecialidad($especialidad);
            $arregloProfesores = $Profesor->obtenerProfesorPorEsp();

            $response->getBody()->write(json_encode($arregloProfesores));
            return $response->withHeader('Content-Type', 'application/json');
        }

        public function ActualizarDatos($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $nombre = $listaDeParametros['nombre'];
            $apellido = $listaDeParametros['apellido'];
            $direccion = $listaDeParametros['direccion'];
            $telefono = $listaDeParametros['telefono'];
            $especialidad = $listaDeParametros['especialidad'];
            $legajo = $args['legajo'];
            
            $Profesor = new Profesor();
            $Profesor->setLegajo($legajo);
            $Profesor->setNombre($nombre);
            $Profesor->setApellido($apellido);
            $Profesor->setDireccion($direccion);
            $Profesor->setTelefono($telefono);
            $Profesor->setEspecialidad($especialidad);
            $Profesor->actualizarDatosProfesor();

            $response->getBody()->write("Se actualizó datos correctamente");
            return $response;
        }

        public function RetornarClasesACargo($request, $response, $args){
            $legajo = $args['legajo'];

            $Profesor = new Profesor();
            $Profesor->setLegajo($legajo);
            $arregloClases = $Profesor->obtenerClasesDeProfesor();

            $response->getBody()->write(json_encode($arregloClases));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>