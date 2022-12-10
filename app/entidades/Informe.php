<?php

    class Informe{

        function __construct(){

        }

        public function obtenerClasesXDia(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT DISTINCT dias, COUNT(*) AS Total
            FROM clase
            group BY dias
            ORDER BY FIELD(dias, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado')");
            $consulta->execute();
            

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerInscriptosXActividad(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT DISTINCT a.nombre, COUNT(sc.clase) AS Total
            FROM actividad AS a, clase AS cl, clasexdia AS cdia, socioclase AS sc 
            WHERE a.idActividad=cl.tipoActividad 
            AND cdia.idClase=cl.idClase 
            AND cdia.idClasePorDia=sc.clase
            GROUP BY a.nombre");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerSuscripcionesActivas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT DISTINCT s.nombre , COUNT(c.idSuscripcion) AS Total FROM suscripcion as s, compra as c where s.idSuscripcion=c.idSuscripcion and c.estado='Pagada' and c.fechaVencimiento>=CURDATE() group BY c.idSuscripcion
            ");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerTotalSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as Total FROM socio");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerTotalProfes(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as Total FROM profesor");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerTotalClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as Total FROM clase");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerTotalRutinas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as Total FROM rutina");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>