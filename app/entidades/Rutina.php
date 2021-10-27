<?php

    class Rutina{

        private $idRutina;
        private $nombre;
        private $descripcion;
        private $salon;

        function __construct(){
            
        }

        function setIdRutina($idRutina){
            
            $this->idRutina = $idRutina;
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function setDescripcion($descripcion){
            
            $this->descripcion = $descripcion;
        }

        function setSalon($salon){
            
            $this->salon = $salon;
        }

        function getIdRutina(){
            
            return $this->idRutina;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getDescripcion(){
            
            return $this->descripcion;
        }

        function getSalon(){
            
            return $this->salon;
        }

        public function guardarRutina(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO rutina(nombre, descripcion, salon) VALUES (?,?,?)");
            
            return $consulta->execute(array($this->nombre, $this->descripcion, $this->salon));
        }

        public function actualizarDatos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE rutina SET nombre = ?, descripcion = ?, salon = ? WHERE idRutina = ?");
            
            return $consulta->execute(array($this->nombre, $this->descripcion, $this->salon, $this->idRutina));
        }

        public static function obtenerRutinas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM rutina");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>