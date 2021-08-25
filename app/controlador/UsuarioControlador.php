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

        public function ComprobarCorreo($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();

            $objetoUsuario = Usuario::buscarCorreo($listaDeParametros['email']);

            if(!$objetoUsuario){
                $response->getBody()->write("Correo correcto");
                return $response;
            }

            $response->getBody()->write("Correo duplicado");
            return $response;
        }

        public function Registrar($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();

            $email = $listaDeParametros['email'];
            $contrasenaAleatoria = generarContrasenaAleatoria();
            $hashDeContrasena = password_hash($contrasenaAleatoria, PASSWORD_DEFAULT);

            $ObjetoUsuario = new Usuario();
            $ObjetoUsuario->setEmail($email);
            $ObjetoUsuario->setContrasena($hashDeContrasena);
            $ObjetoUsuario->guardarUsuario();
            $UltimoId = Usuario::obtenerUltimoId();
            $UsuarioNuevo = array("idUsuario"=>$UltimoId['idUsuario'], "contrasena"=>$contrasenaAleatoria);

            //$response->getBody()->write($contrasenaAleatoria);
            //return $response;
            return $UsuarioNuevo;
        }
        
        public function RecuperarContrasena($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            
            $objetoUsuario = Usuario::buscarCorreo($listaDeParametros['email']);

            if(!$objetoUsuario){
                $response->getBody()->write("No existe correo");
                return $response;
            }
            
            $contrasenaNueva = generarContrasenaAleatoria();
            $hashDeContrasena = password_hash($contrasenaNueva, PASSWORD_DEFAULT);

            $ObjUsuario = new Usuario();
            $ObjUsuario->setEmail($objetoUsuario['email']);
            $ObjUsuario->setContrasena($hashDeContrasena);
            $ObjUsuario->actualizarContrasena();
            $texto = "Recuperación de Contraseña";

            //mail('37198321@itbeltran.com.ar', $texto, $contrasenaNueva);

            $response->getBody()->write("Se envió una nueva contraseña ". $contrasenaNueva ." al correo ".$listaDeParametros['email']);
            return $response;
        }
    }

?>