<?php

    class Actividad{

        private $idActividad;
        private $nombre;

        function __construct(){
            
        }

        function setIdActividad($idActividad){
            
            $this->idActividad = $idActividad;
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function getIdActividad(){
            
            return $this->idActividad;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        public function guardarActividad(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO actividad(nombre) VALUES (?)");
            
            return $consulta->execute(array($this->nombre));
        }

        public static function obtenerActividades(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM actividad");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>