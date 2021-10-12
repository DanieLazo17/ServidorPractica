<?php

    class Clase{

        private $idClase;
        private $tipoClase;
        private $dias;
        private $horaDeInicio;
        private $horaDeFin;
        private $fechaDeInicio;
        private $fechaDeFin;
        private $profesor;
        private $salon;
        private $cupos;
        private $modalidad;
        
        function __construct(){
            
        }

        function setIdClase($idClase){
            
            $this->idClase = $idClase;
        }

        function setTipoClase($tipoClase){
            
            $this->tipoClase = $tipoClase;
        }

        function setDias($dias){
            
            $this->dias = $dias;
        }

        function setHoraDeInicio($horaDeInicio){
            
            $this->horaDeInicio = $horaDeInicio;
        }

        function setHoraDeFin($horaDeFin){
            
            $this->horaDeFin = $horaDeFin;
        }

        function setFechaDeInicio($fechaDeInicio){
            
            $this->fechaDeInicio = $fechaDeInicio;
        }

        function setFechaDeFin($fechaDeFin){
            
            $this->fechaDeFin = $fechaDeFin;
        }

        function setProfesor($profesor){
            
            $this->profesor = $profesor;
        }

        function setSalon($salon){
            
            $this->salon = $salon;
        }

        function setCupos($cupos){
            
            $this->cupos = $cupos;
        }

        function setModalidad($modalidad){
            
            $this->modalidad = $modalidad;
        }

        function getIdClase(){
            
            return $this->idClase;
        }

        function getTipoClase(){
            
            return $this->tipoClase;
        }

        function getDias(){
            
            return $this->dias;
        }

        function getHoraDeInicio(){
            
            return $this->horaDeInicio;
        }

        function getHoraDeFin(){
            
            return $this->horaDeFin;
        }

        function getFechaDeInicio(){
            
            return $this->fechaDeInicio;
        }

        function getFechaDeFin(){
            
            return $this->fechaDeFin;
        }

        function getProfesor(){
            
            return $this->profesor;
        }

        function getSalon(){
            
            return $this->salon;
        }

        function getCupos(){
            
            return $this->cupos;
        }
        
        function getModalidad(){
            
            return $this->modalidad;
        }

        public function buscarClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon FROM clase AS c, profesor AS p, salon AS s WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND dias LIKE ?");
            $dias = "%".$this->dias."%";
            $consulta->execute(array($dias));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerClasesDelTipo($tipoClase){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin FROM clase WHERE tipoClase = ?");
            $consulta->execute(array($tipoClase));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoNroClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(idClase) AS idClase FROM clase");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }
?>