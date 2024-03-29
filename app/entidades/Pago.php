<?php

    class Pago{

        private $nroPago;
        private $importe;
        private $fecha;
        private $medioPago;

        function __construct(){

        }

        function setNroPago($nroPago){    

            $this->nroPago = $nroPago;
        }

        function setImporte($importe){    

            $this->importe = $importe;
        }

        function setFecha($fecha){    

            $this->fecha = $fecha;
        }

        function setMedioPago($medioPago){    

            $this->medioPago = $medioPago;
        }

        function getNroPago(){
            
            return $this->nroPago;
        }

        function getImporte(){
            
            return $this->importe;
        }

        function getFecha(){
            
            return $this->fecha;
        }

        function getMedioPago(){
            
            return $this->medioPago;
        }

        public function guardarPago(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pago(nroPago, importe, fecha, medioPago) VALUES (?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroPago, $this->importe, $this->fecha, $this->medioPago));
        }

        public function obtenerHistorialPagos($FechaMin, $FechaMax){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT p.nroPago, p.importe, p.fecha, p.medioPago,s.nombre,s.apellido 
            FROM pago AS p, compra as c, socio as s
           
            WHERE p.fecha BETWEEN ? AND ?
            AND p.medioPago = ?
            AND p.nroPago=c.pago and c.socio=s.nroSocio");
            $consulta->execute(array($FechaMin, $FechaMax, $this->medioPago));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoNroPago(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(nroPago) AS nroPago FROM pago");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }
?>