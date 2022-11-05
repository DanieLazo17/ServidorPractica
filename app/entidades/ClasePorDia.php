<?php

    class ClasePorDia{

        private $idClasePorDia;
        private $idClase;
        private $fecha;
        
        function __construct(){
            
        }

        function setIdClasePorDia($idClasePorDia){
            
            $this->idClasePorDia = $idClasePorDia;
        }

        function setIdClase($idClase){
            
            $this->idClase = $idClase;
        }

        function setFecha($fecha){
            
            $this->fecha = $fecha;
        }

        function getIdClasePorDia(){
            
            return $this->idClasePorDia;
        }

        function getIdClase(){
            
            return $this->idClase;
        }

        function getFecha(){
            
            return $this->fecha;
        }

        public static function obtenerClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT sc.clase, cxd.idClase, a.nombre AS actividad, c.dias, c.horaDeInicio, salon.nombreSalon, p.nombre AS profesor, c.cupos, c.cupos-COUNT(sc.clase) AS cupoDisponible 
            FROM clasexdia AS cxd, clase AS c, socioclase AS sc, socio AS s, profesor AS p, actividad AS a, salon
            WHERE cxd.idClase = c.idClase 
            AND cxd.idClasePorDia = sc.clase 
            AND sc.socio = s.nroSocio
            AND c.profesor = p.legajo
            AND c.tipoActividad = a.idActividad
            AND c.salon = salon.idSalon
            AND cxd.fecha BETWEEN DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH) AND DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)
            GROUP BY sc.clase");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>