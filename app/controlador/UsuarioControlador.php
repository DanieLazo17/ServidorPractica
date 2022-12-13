<?php

    class UsuarioControlador{

        public function Validar($request, $response, $args){  
            $listaDeParametros = $request->getParsedBody();

            $Usuario = new Usuario();
            $Usuario->setEmail($listaDeParametros['email']);
            $objetoUsuario = $Usuario->obtenerUsuario();
            $UsuarioRegistrado = array("idUsuario"=>null, "idPerfil"=>null, "email"=>null, "nombreCompleto"=>null, "estado"=>null, "origenDeContrasena"=>null);

            if(!$objetoUsuario){
                $response->getBody()->write(json_encode($UsuarioRegistrado));
                return $response;
            }
    
            if($objetoUsuario->compararContrasena($listaDeParametros['pass'])){
                $idDePerfil = $objetoUsuario->obtenerPerfil();

                if($idDePerfil['idPerfil'] == "ADMIN"){
                    $AdministrativoControlador = new AdministrativoControlador();
                    $NombreCompleto = $AdministrativoControlador->RetornarNombreCompleto($objetoUsuario->getIdUsuario());
                    $UsuarioRegistrado = array("idUsuario"=>$objetoUsuario->getIdUsuario(), "idPerfil"=>$idDePerfil['idPerfil'], "email"=>$objetoUsuario->getEmail(), "nombreCompleto"=>$NombreCompleto['nombreCompleto'], "estado"=>null, "origenDeContrasena"=>$objetoUsuario->getOrigenDeContrasena());
                }
                if($idDePerfil['idPerfil'] == "PRO"){
                    $ProfesorControlador = new ProfesorControlador();
                    $NombreYEstado = $ProfesorControlador->RetornarNombreYEstado($objetoUsuario->getIdUsuario());
                    $UsuarioRegistrado = array("idUsuario"=>$objetoUsuario->getIdUsuario(), "idPerfil"=>$idDePerfil['idPerfil'], "email"=>$objetoUsuario->getEmail(), "nombreCompleto"=>$NombreYEstado['nombreCompleto'], "estado"=>$NombreYEstado['estado'], "origenDeContrasena"=>$objetoUsuario->getOrigenDeContrasena());
                }
                if($idDePerfil['idPerfil'] == "SOC"){
                    $SocioControlador = new SocioControlador();
                    $NombreYEstado = $SocioControlador->RetornarNombreYEstado($objetoUsuario->getIdUsuario());
                    $UsuarioRegistrado = array("idUsuario"=>$objetoUsuario->getIdUsuario(), "idPerfil"=>$idDePerfil['idPerfil'], "email"=>$objetoUsuario->getEmail(), "nombreCompleto"=>$NombreYEstado['nombreCompleto'], "estado"=>$NombreYEstado['estado'], "origenDeContrasena"=>$objetoUsuario->getOrigenDeContrasena());
                }
                $response->getBody()->write(json_encode($UsuarioRegistrado));
            }
            else{
                $response->getBody()->write(json_encode($UsuarioRegistrado));
            }
            
            return $response->withHeader('Content-Type', 'application/json');
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
            $ObjetoUsuario->setOrigenDeContrasena("SIS");
            $ObjetoUsuario->guardarUsuario();
            $UltimoId = Usuario::obtenerUltimoId();
            $UsuarioNuevo = array("idUsuario"=>$UltimoId['idUsuario'], "contrasena"=>$contrasenaAleatoria);

            $asunto = "Clave de Acceso";
            $mensaje = "Su contraseña provisoria es: " . $contrasenaAleatoria;
            enviarCorreo($ObjetoUsuario->getEmail(), $asunto, $mensaje);

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
            $ObjUsuario->setIdUsuario($objetoUsuario->getIdUsuario());
            $ObjUsuario->setEmail($objetoUsuario->getEmail());
            $ObjUsuario->setContrasena($hashDeContrasena);
            $ObjUsuario->setOrigenDeContrasena("SIS");
            $ObjUsuario->actualizarContrasena();
            $ObjUsuario->actualizarOrigenDeContrasena();
            $asunto = "Clave de Acceso";
            $mensaje = "Su contraseña nueva es: " . $contrasenaNueva;
            /*
            $cabecera = 'From: daniel.lazo92@gmail.com' . "\r\n" .
            'Reply-To: daniel.lazo92@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            
            $puerto = ini_get('smtp_port');
            ini_set('SMTP', 'smtp.gmail.com');
            ini_set('smtp_port', '587');
            ini_set('sendmail_from', 'daniel.lazo92@gmail.com');
            */
            $respuesta = enviarCorreo($ObjUsuario->getEmail(), $asunto, $mensaje);
            //$respuesta = enviarCorreo("primerospasosbeltran@gmail.com", $asunto, $mensaje);
            $response->getBody()->write($respuesta);
            return $response;
        }

        public function CambiarContrasena($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();

            $email = $listaDeParametros['email'];
            $contrasenaNueva = $listaDeParametros['contrasenaNueva'];

            $hashDeContrasena = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
            
            $ObjUsuario = new Usuario();
            $ObjUsuario->setEmail($email);
            $ObjUsuario->setContrasena($hashDeContrasena);
            $ObjUsuario->setOrigenDeContrasena("USU");
            $ObjUsuario->actualizarContrasena();
            $ObjUsuario->actualizarOrigenDeContrasena();
            
            $response->getBody()->write("Se modificó contraseña correctamente");
            return $response;
        }

        public function BuscarPorCorreo($request, $response, $args){
            $listaDeParametros = $request->getParsedBody();
            $email = $listaDeParametros['email'];

            $ObjetoUsuario = new Usuario();
            $ObjetoUsuario->setEmail($email);
            $Usuario = $ObjetoUsuario->obtenerId();

            return $Usuario;
        }

        public function CambiarCorreo($request, $response, $args){      
            $listaDeParametros = $request->getParsedBody();
            $email = $listaDeParametros['email'];      
            $idUsuario = $args['idUsuario'];

            $Usuario = new Usuario();
            $Usuario->setIdUsuario($idUsuario);
            $Usuario->setEmail($email);
            $Usuario->actualizarCorreo();

            $response->getBody()->write(json_encode($email));
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

?>