<?php

    class TipoClase{

        private $idTipoClase;
        private $nombre;

        function __construct(){
            
        }

        function setIdTipoClase($idTipoClase){
            
            $this->idTipoClase = $idTipoClase;
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function getIdTipoClase(){
            
            return $this->idTipoClase;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        public function guardarTipoClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO tipoclase(nombre) VALUES (?)");
            
            return $consulta->execute(array($this->nombre));
        }

        public static function obtenerTiposDeClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM tipoclase");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>