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

        public function obtenerProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM profesor WHERE legajo=?");
            $consulta->execute(array($this->legajo));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerCorreo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT email FROM usuario WHERE idUsuario=?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerProfesores(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT legajo, nombre, apellido FROM profesor");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>