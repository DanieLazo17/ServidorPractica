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

        public function obtenerInscriptos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT s.nroSocio, s.nombre, s.apellido 
            FROM clasexdia AS cxd, socioclase AS sc, socio AS s 
            WHERE cxd.idClasePorDia = sc.clase 
            AND sc.socio = s.nroSocio 
            AND cxd.idClasePorDia = ?");
            $consulta->execute(array($this->idClasePorDia));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function guardarClasePorDia(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO clasexdia(idClase, fecha) VALUES (?,?)");
            
            return $consulta->execute(array($this->idClase, $this->fecha));
        }

        public function obtenerUltimaFecha(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(fecha) AS fecha FROM clasexdia WHERE idClase = ?");
            $consulta->execute(array($this->idClase));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerProximasClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClasePorDia, idClase, fecha
            FROM clasexdia
            WHERE fecha BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>