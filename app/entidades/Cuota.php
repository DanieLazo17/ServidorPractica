<?php

    class Cuota{

        public $idCuota;
        public $mes;
        public $socio;
        public $importe;
        public $fechaEmision;
        public $fechaVencimiento;

        function __construct(){

        }

        function setIdCuota($idCuota){    

            $this->idCuota = $idCuota;
        }

        function setMes($mes){    
             
            $this->mes = $mes;
        }

        function setSocio($socio){    
            
            $this->socio = $socio;
        }

        function setImporte($importe){    
             
            $this->importe = $importe;
        }

        function setFechaEmision($fechaEmision){    
             
            $this->fechaEmision = $fechaEmision;
        }

        function setFechaVencimiento($fechaVencimiento){    
             
            $this->fechaVencimiento = $fechaVencimiento;
        }

        function getIdCuota(){
            
            return $this->idCuota;
        }

        function getMes(){
            
            return $this->mes;
        }

        function getSocio(){
            
            return $this->socio;
        }

        function getImporte(){
            
            return $this->importe;
        }

        function getFechaEmision(){
            
            return $this->fechaEmision;
        }

        function getFechaVencimiento(){
            
            return $this->fechaVencimiento;
        }

        public function guardarCuotasDeSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cuota(mes, socio, importe, fechaEmision, fechaVencimiento) VALUES (?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->mes, $this->socio, $this->importe, $this->fechaEmision, $this->fechaVencimiento));
        }
    }
?>