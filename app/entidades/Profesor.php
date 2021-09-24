<?php

    class Profesor{
        private $legajo;
        private $nombre;
        private $apellido;
        private $direccion;
        private $telefono;
        private $especialidad;
        private $usuario;

        function __construct(){
            
        }

        function setLegajo($legajo){
            
            $this->legajo = $legajo;
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function setApellido($apellido){
            
            $this->apellido = $apellido;
        }

        function setDireccion($direccion){
            
            $this->direccion = $direccion;
        }

        function setTelefono($telefono){
            
            $this->telefono = $telefono;
        }

        function setEspecialidad($especialidad){
            
            $this->especialidad = $especialidad;
        }

        function setUsuario($usuario){
            
            $this->usuario = $usuario;
        }

        function getLegajo(){
            
            return $this->legajo;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getApellido(){
            
            return $this->apellido;
        }

        function getDireccion(){
            
            return $this->direccion;
        }

        function getTelefono(){
            
            return $this->telefono;
        }

        function getEspecialidad(){
            
            return $this->especialidad;
        }

        function getUsuario(){
            
            return $this->usuario;
        }
    }
?>