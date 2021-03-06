<?php

    class Cuota{

        private $idCuota;
        private $mes;
        private $socio;
        private $importe;
        private $fechaEmision;
        private $fechaVencimiento;
        private $estado;
        private $pago;

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

        function setEstado($estado){    
             
            $this->estado = $estado;
        }

        function setPago($pago){    
             
            $this->pago = $pago;
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

        function getEstado(){
            
            return $this->estado;
        }

        function getPago(){
            
            return $this->pago;
        }

        public function guardarCuotasDeSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cuota(mes, socio, importe, fechaEmision, fechaVencimiento, estado) VALUES (?,?,?,?,?,?)");
            //Devuelve true en caso de ??xito o false en caso de error.
            return $consulta->execute(array($this->mes, $this->socio, $this->importe, $this->fechaEmision, $this->fechaVencimiento, $this->estado));
        }

        public function actualizarEstadoDeCuotas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE cuota SET estado = ? WHERE socio = ? AND pago IS NULL AND CURRENT_DATE > fechaVencimiento");
            $estado = "Impaga";
            
            return $consulta->execute(array($estado, $this->socio));
        }

        public function obtenerCuotasEmitOVenc(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idCuota, mes, importe, fechaVencimiento, estado FROM cuota WHERE socio=? AND (estado='Emitida' OR estado='Impaga')");
            $consulta->execute(array($this->socio));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function actualizarPagoDeCuota(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE cuota SET estado = ?, pago = ? WHERE idCuota = ?");
            
            return $consulta->execute(array($this->estado, $this->pago, $this->idCuota));
        }
    }
?>