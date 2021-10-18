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

        public function obtenerAdministrativo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM administrativo WHERE usuario=?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerCorreo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT email FROM usuario WHERE idUsuario=?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function actualizarDatosAdministrativo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE administrativo SET nombre = ?, apellido = ?, direccion = ?, telefono = ? WHERE dni = ?");
            
            return $consulta->execute(array($this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->dni));
        }
    }

?>