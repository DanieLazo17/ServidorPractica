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
    }
?>