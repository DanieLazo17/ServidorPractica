<?php

    class Pago{

        private $nroPago;
        private $cuota;
        private $importe;
        private $fecha;

        function __construct(){

        }

        function setNroPago($nroPago){    

            $this->nroPago = $nroPago;
        }

        function setCuota($cuota){    

            $this->cuota = $cuota;
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

        function getCuota(){
            
            return $this->cuota;
        }

        function getImporte(){
            
            return $this->importe;
        }

        function getFecha(){
            
            return $this->fecha;
        }
    }
?>