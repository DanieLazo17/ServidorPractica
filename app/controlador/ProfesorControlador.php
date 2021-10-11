<?php

    class ProfesorControlador{

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
    }

?>