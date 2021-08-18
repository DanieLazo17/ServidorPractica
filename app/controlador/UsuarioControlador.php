<?php

    /*
        El objeto de la clase usuarioControlador realiza cada una de las funciones que necesitamos para que funcione nuestra aplicación.
        En la clase controlador, creamos funciones de acuerdo a qué funcionamiento le damos a una llamada o solicitud
    */

    class UsuarioControlador{

        public function Validar($request, $response, $args){  
            $listaDeParametros = $request->getParsedBody();

            $objetoUsuario = Usuario::obtenerUsuario($listaDeParametros['email']);
            $UsuarioRegistrado = array("idUsuario"=>null, "email"=>null);

            if(!$objetoUsuario){
                $response->getBody()->write(json_encode($UsuarioRegistrado));
                return $response;
            }
    
            if($objetoUsuario->compararContrasena($listaDeParametros['pass'])){
                SesionControlador::Iniciar($listaDeParametros['email']);

                $UsuarioRegistrado = array("idUsuario"=>$objetoUsuario->getIdUsuario(), "email"=>$objetoUsuario->getEmail());
                $response->getBody()->write(json_encode($UsuarioRegistrado));
                //$response->getBody()->write("Acceso correcto");
            }
            else{
                $response->getBody()->write(json_encode($UsuarioRegistrado));
                //$response->getBody()->write("Contraseña incorrecta");
            }
            return $response->withHeader('Content-Type', 'application/json');
            //return $response;
        }

    }

?>