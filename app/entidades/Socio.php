<?php

    class Socio{
        
        private $nroSocio;
        private $nombre;
        private $apellido;
        private $direccion;
        private $email;
        private $telefono;
        private $estado;

        function __construct(){
            
        }

        function setNroSocio($nroSocio){
            
            $this->nroSocio = $nroSocio;
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

        function setEmail($email){
            
            $this->email = $email;
        }

        function setTelefono($telefono){
            
            $this->telefono = $telefono;
        }

        function setEstado($estado){
            
            $this->estado = $estado;
        }

        function getNroSocio(){
            
            return $this->nroSocio;
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

        function getEmail(){
            
            return $this->email;
        }

        function getTelefono(){
            
            return $this->telefono;
        }

        function getEstado(){
            
            return $this->estado;
        }

        public static function obtenerSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio, nombre FROM socio");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerSocio($nroSocio){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM socio WHERE nroSocio=?");
            $consulta->execute(array($nroSocio));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

    }

?>