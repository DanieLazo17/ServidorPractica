<?php

    class Administrativo{
        private $dni;
        private $nombre;
        private $apellido;
        private $direccion;
        private $telefono;
        private $usuario;

        function __construct(){
            
        }

        function setDni($dni){
            
            $this->dni = $dni;
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

        function setUsuario($usuario){
            
            $this->usuario = $usuario;
        }

        function getDni(){
            
            return $this->dni;
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

        function getUsuario(){
            
            return $this->usuario;
        }
    }

?>