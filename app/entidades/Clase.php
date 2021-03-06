<?php

    class Clase{

        private $idClase;
        private $tipoClase;
        private $dias;
        private $horaDeInicio;
        private $horaDeFin;
        private $fechaDeInicio;
        private $fechaDeFin;
        private $profesor;
        private $salon;
        private $cupos;
        private $modalidad;
        
        function __construct(){
            
        }

        function setIdClase($idClase){
            
            $this->idClase = $idClase;
        }

        function setTipoClase($tipoClase){
            
            $this->tipoClase = $tipoClase;
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

        function setFechaDeFin($fechaDeFin){
            
            $this->fechaDeFin = $fechaDeFin;
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

        function getTipoClase(){
            
            return $this->tipoClase;
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

        function getFechaDeFin(){
            
            return $this->fechaDeFin;
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
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO clase(idClase, tipoClase, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, profesor, salon, cupos, modalidad) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            //Devuelve true en caso de ??xito o false en caso de error.
            return $consulta->execute(array($this->idClase, $this->tipoClase, $this->dias, $this->horaDeInicio, $this->horaDeFin, $this->fechaDeInicio , $this->fechaDeFin, $this->profesor, $this->salon, $this->cupos, $this->modalidad));
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
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin, s.nombreSalon AS salon FROM clase AS c, salon AS s WHERE c.salon = s.idSalon AND c.profesor = ?");
            $consulta->execute(array($this->profesor));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function actualizarDatosClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE clase SET tipoClase = ?, dias = ?, horaDeInicio = ?, horaDeFin = ?, fechaDeInicio = ?, fechaDeFin = ?, profesor = ?, salon = ?, cupos = ?, modalidad = ? WHERE idClase = ?");
            
            return $consulta->execute(array($this->tipoClase, $this->dias, $this->horaDeInicio, $this->horaDeFin, $this->fechaDeInicio , $this->fechaDeFin, $this->profesor, $this->salon, $this->cupos, $this->modalidad, $this->idClase));
        }

        public function obtenerClase(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, modalidad FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase AND idClase = ?");
            $consulta->execute(array($this->idClase));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT s.nroSocio, s.nombre, s.apellido FROM socio AS s, clase AS c, socioclase AS sc WHERE c.idClase = sc.clase AND s.nroSocio = sc.socio AND c.idClase = ?");
            $consulta->execute(array($this->idClase));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerClasesDelTipo($tipoClase){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin FROM clase WHERE tipoClase = ?");
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc, socioclase AS sc 
                WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase AND c.idClase = sc.clase AND c.tipoClase = ? GROUP BY c.idClase HAVING cupoDisponible > 0
                UNION
                SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos AS cupoDisponible 
                FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc
                WHERE c.profesor = p.legajo
                AND c.salon = s.idSalon
                AND c.tipoClase = tc.idTipoClase
                AND c.tipoClase = ?
                AND c.idClase NOT IN
                (SELECT DISTINCT clase
                FROM socioclase)");
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, dias, horaDeInicio, horaDeFin, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, socioclase AS sc WHERE c.idClase = sc.clase AND c.tipoClase = ? GROUP BY c.idClase HAVING cupoDisponible > 0");
            $consulta->execute(array($tipoClase, $tipoClase));

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
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase");
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc, socioclase AS sc 
                WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase AND c.idClase = sc.clase GROUP BY sc.clase
                UNION
                SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos AS cupoDisponible 
                FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc
                WHERE c.profesor = p.legajo
                AND c.salon = s.idSalon
                AND c.tipoClase = tc.idTipoClase
                AND c.idClase NOT IN
                (SELECT DISTINCT clase
                FROM socioclase)");
            //$consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, CONCAT(p.nombre, ' ',p.apellido) AS profesor, s.nombreSalon AS salon, cupos, c.cupos-COUNT(sc.clase) AS cupoDisponible FROM clase AS c, profesor AS p, salon AS s, tipoclase AS tc, socioclase AS sc WHERE c.profesor = p.legajo AND c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase AND c.idClase = sc.clase GROUP BY c.idClase");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>