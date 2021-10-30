<?php

    class Salon{

        private $idSalon;
        private $nombreSalon;
        private $capacidad;
        private $estado;
        
        function __construct(){  

        }

        function setIdSalon($idSalon){

            $this->idSalon = $idSalon;
        }

        function setNombreSalon($nombreSalon){

            $this->nombreSalon = $nombreSalon;
        }

        function setCapacidad($capacidad){

            $this->capacidad = $capacidad;
        }

        function setEstado($estado){

            $this->estado = $estado;
        }

        function getIdSalon(){
            
            return $this->idSalon;
        }

        function getNombreSalon(){
            
            return $this->nombreSalon;
        }

        function getCapacidad(){
            
            return $this->capacidad;
        }

        function getEstado(){
            
            return $this->estado;
        }

        public function actualizarDatos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE salon SET nombreSalon = ?, capacidad = ?, estado = ? WHERE idSalon = ?");
            
            return $consulta->execute(array($this->nombreSalon, $this->capacidad, $this->estado, $this->idSalon));
        }

        public static function obtenerSalones(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM salon");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>