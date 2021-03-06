<?php

    class Pago{

        private $nroPago;
        private $importe;
        private $fecha;

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

        function getNroPago(){
            
            return $this->nroPago;
        }

        function getImporte(){
            
            return $this->importe;
        }

        function getFecha(){
            
            return $this->fecha;
        }

        public function guardarPago(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pago(importe, fecha) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->importe, $this->fecha));
        }

        public static function obtenerUltimoNroPago(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(nroPago) AS nroPago FROM pago");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }
?>