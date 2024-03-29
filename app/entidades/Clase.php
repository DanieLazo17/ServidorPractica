<?php

    class Clase{

        private $idClase;
        private $tipoActividad;
        private $dias;
        private $horaDeInicio;
        private $horaDeFin;
        private $fechaDeInicio;
        private $profesor;
        private $salon;
        private $cupos;
        private $modalidad;
        
        function __construct(){
            
        }

        function setIdClase($idClase){
            
            $this->idClase = $idClase;
        }

        function setActividad($tipoActividad){
            
            $this->tipoActividad  = $tipoActividad;
        }

        function setDias($dias){
            
            $this->dias = $dias;
        }

        function setHoraDeInicio($horaDeInicio){
            
            $this->horaDeInicio = $horaDeInicio;
        }

        function setHoraDeFin($horaDeFin){
            
            $this->horaDeFin = $horaDeFin;
        }

        function setFechaDeInicio($fechaDeInicio){
            
            $this->fechaDeInicio = $fechaDeInicio;
        }

       
        function setProfesor($profesor){
            
            $this->profesor = $profesor;
        }

        function setSalon($salon){
            
            $this->salon = $salon;
        }

        function setCupos($cupos){
            
            $this->cupos = $cupos;
        }

        function setModalidad($modalidad){
            
            $this->modalidad = $modalidad;
        }

        function getIdClase(){
            
            return $this->idClase;
        }

        function getActividad(){
            
            return $this->tipoActividad;
        }

        function getDias(){
            
            return $this->dias;
        }

        function getHoraDeInicio(){
            
            return $this->horaDeInicio;
        }

        function getHoraDeFin(){
            
            return $this->horaDeFin;
        }

        function getFechaDeInicio(){
            
            return $this->fechaDeInicio;
        }

        function getProfesor(){
            
            return $this->profesor;
        }

        function getSalon(){
            
            return $this->salon;
        }

        function getCupos(){
            
            return $this->cupos;
        }
        
        function getModalidad(){
            
            return $this->modalidad;
        }

        public function guardarClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO clase(idClase, tipoActividad, dias, horaDeInicio, horaDeFin, fechaDeInicio,  profesor, salon, cupos, modalidad) VALUES (?,?,?,?,?,?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->idClase, $this->tipoActividad, $this->dias, $this->horaDeInicio, $this->horaDeFin, $this->fechaDeInicio ,  $this->profesor, $this->salon, $this->cupos, $this->modalidad));
        }

        public function buscarClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon FROM clase AS c, profesor AS p, salon AS s WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND dias LIKE ?");
            $dias = "%".$this->dias."%";
            $consulta->execute(array($dias));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerClasesDelProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase,tipoActividad, dias, horaDeInicio, horaDeFin, s.nombreSalon AS salon FROM clase AS c, salon AS s WHERE c.salon = s.idSalon AND c.profesor = ?");
            $consulta->execute(array($this->profesor));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function actualizarDatosClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE clase SET tipoActividad = ?, dias = ?, horaDeInicio = ?, horaDeFin = ?, fechaDeInicio = ?,  profesor = ?, salon = ?, cupos = ?, modalidad = ? WHERE idClase = ?");
            
            return $consulta->execute(array($this->tipoActividad, $this->dias, $this->horaDeInicio, $this->horaDeFin, $this->fechaDeInicio ,  $this->profesor, $this->salon, $this->cupos, $this->modalidad, $this->idClase));
        }

        public function obtenerClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio,  CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, modalidad FROM clase AS c, profesor AS p, salon AS s, actividad AS tc WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoActividad = tc.idActividad AND idClase = ?");
            $consulta->execute(array($this->idClase));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT s.nroSocio, s.nombre, s.apellido FROM socio AS s, clase AS c, socioclase AS sc WHERE c.idClase = sc.clase AND s.nroSocio = sc.socio AND c.idClase = ?");
            $consulta->execute(array($this->idClase));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerClasesDelTipo($tipoActividad){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin FROM clase WHERE tipoActividad = ?");
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio,  CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, profesor AS p, salon AS s, actividad  AS tc, socioclase AS sc 
                WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoActividad = tc.idActividad AND c.idClase = sc.clase AND c.tipoActividad = ? GROUP BY c.idClase HAVING cupoDisponible > 0
                UNION
                SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio,  CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos AS cupoDisponible 
                FROM clase AS c, profesor AS p, salon AS s, actividad AS tc
                WHERE c.profesor = p.legajo
                AND c.salon = s.idSalon
                AND c.tipoActividad = tc.idActividad
                AND c.tipoActividad  = ?
                AND c.idClase NOT IN
                (SELECT DISTINCT clase
                FROM socioclase)");
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, socioclase AS sc WHERE c.idClase = sc.clase AND c.tipoClase = ? GROUP BY c.idClase HAVING cupoDisponible > 0");
            $consulta->execute(array($tipoActividad, $tipoActividad));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoNroClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(idClase) AS idClase FROM clase");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerClases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, a.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio,  CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos 
                FROM clase AS c, profesor AS p, salon AS s, actividad  AS a
                WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoActividad = a.idActividad");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerClasesBases(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, fechaDeInicio FROM clase");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>