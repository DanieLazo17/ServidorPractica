<?php

    class Informe{

        function __construct(){

        }

        public function obtenerClasesXDia(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT DISTINCT dias, COUNT(*) AS Total
            FROM clase
            group BY dias
            ORDER by dias");
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
    }
?>