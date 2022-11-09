<?php

    class Compra{

        private $idCompra;
        private $idSuscripcion;
        private $socio;
        private $importe;
        private $fechaEmision;
        private $fechaVencimiento;
        private $estado;
        private $pago;

        function __construct(){

        }

        function setIdCompra($idCompra){    

            $this->idCompra = $idCompra;
        }

        function setSuscripcion($idSuscripcion){    
             
            $this->idSuscripcion = $idSuscripcion;
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

        function getIdCompra(){
            
            return $this->idCompra;
        }

        function getidSuscripcion(){
            
            return $this->idSuscripcion;
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

        public function guardarCompraDeSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO compra(idSuscripcion, socio, importe, estado) VALUES (?,?,?,?)");
            
            return $consulta->execute(array($this->idSuscripcion, $this->socio, $this->importe, $this->estado));
        }

        public function actualizarEstadoDeCompras(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE compra SET estado = ? WHERE socio = ? AND pago IS NULL AND CURRENT_DATE > fechaVencimiento");
            $estado = "Impaga";
            
            return $consulta->execute(array($estado, $this->socio));
        }

        public function obtenerComprasEmitOVenc(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idCompra, idSuscripcion, importe, fechaVencimiento, estado FROM compra WHERE socio=? AND (estado='Emitida' OR estado='Impaga')");
            $consulta->execute(array($this->socio));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function pagarCompra(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE compra SET fechaEmision = ?, fechaVencimiento = ?, estado = ?, pago = ? WHERE idCompra = ?");
            
            return $consulta->execute(array($this->fechaEmision, $this->fechaVencimiento, $this->estado, $this->pago, $this->idCompra));
        }
    }
?>