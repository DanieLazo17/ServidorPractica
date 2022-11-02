<?php

    class Suscripcion{

        private $idSuscripcion;
        private $nombre;
        private $cantClases;
        private $descSuscripcion;
        private $actividad;
  
        
        function __construct(){
            
        }

        function setIdSuscripcion($idSuscripcion){
            
            $this->idSuscripcion = $idSuscripcion;
        }

        function setNombre($nombre ){
            
            $this->nombre  = $nombre;
        }

        function setCantClases($cantClases){
            
            $this->cantClases = $cantClases;
        }

        function setDescSuscripcion($descSuscripcion){
            
            $this->descSuscripcion = $descSuscripcion;
        }

        function setActividad($actividad){
            
            $this->actividad = $actividad;
        }

        
        function getIdSuscripcion(){
            
            return $this->idSuscripcion;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getCantClases(){
            
            return $this->cantClases;
        }

        function getDescSuscripcion(){
            
            return $this->descSuscripcion;
        }
        function getActividad(){
            
            return $this->actividad;
        }

       
        public function guardarSuscripcion(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO suscripcion(idSuscripcion, nombre, cantClases, descSuscripcion, actividad) VALUES (?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->idSuscripcion, $this->nombre, $this->cantClases, $this->descSuscripcion, $this->actividad));
        }

       

        public function actualizarSuscripcion(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE suscripcion SET nombre = ?, cantClases = ?, descSuscripcion= ?, actividad = ? WHERE idSuscripcion = ?");
            
            return $consulta->execute(array( $this->nombre, $this->cantClases, $this->descSuscripcion, $this->actividad, $this->idSuscripcion));
        }

        public function obtenerUnaSuscripcion(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idSuscripcion, nombre, cantClases, descSuscripcion, actividad FROM suscripcion WHERE  idSuscripcion = ?");
            $consulta->execute(array($this->idSuscripcion));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerSuscripciones(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM suscripcion");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoNroSuscripcion(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(idSuscripcion) AS idSuscripcion FROM suscripcion");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

    }
?>