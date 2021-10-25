<?php

    class Profesor{
        private $legajo;
        private $nombre;
        private $apellido;
        private $direccion;
        private $telefono;
        private $especialidad;
        private $usuario;
        private $estado;
        private $fechaDeAlta;

        function __construct(){
            
        }

        function setLegajo($legajo){
            
            $this->legajo = $legajo;
        }

        function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        function setApellido($apellido){
            
            $this->apellido = $apellido;
        }

        function setDireccion($direccion){
            
            $this->direccion = $direccion;
        }

        function setTelefono($telefono){
            
            $this->telefono = $telefono;
        }

        function setEspecialidad($especialidad){
            
            $this->especialidad = $especialidad;
        }

        function setUsuario($usuario){
            
            $this->usuario = $usuario;
        }

        function setEstado($estado){
            
            $this->estado = $estado;
        }

        function setFechaDeAlta($fechaDeAlta){
            
            $this->fechaDeAlta = $fechaDeAlta;
        }

        function getLegajo(){
            
            return $this->legajo;
        }

        function getNombre(){
            
            return $this->nombre;
        }

        function getApellido(){
            
            return $this->apellido;
        }

        function getDireccion(){
            
            return $this->direccion;
        }

        function getTelefono(){
            
            return $this->telefono;
        }

        function getEspecialidad(){
            
            return $this->especialidad;
        }

        function getUsuario(){
            
            return $this->usuario;
        }

        function getEstado(){
            
            return $this->estado;
        }

        function getFechaDeAlta(){
            
            return $this->fechaDeAlta;
        }

        public function guardarProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO profesor(legajo, nombre, apellido, direccion, telefono, especialidad, usuario, estado, fechaDeAlta) VALUES (?,?,?,?,?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->legajo, $this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->especialidad , $this->usuario, $this->estado, $this->fechaDeAlta));
        }

        public function agregarPerfil(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO perfilusuario(idUsuario, idPerfil) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            $idPerfil = "PRO";
            return $consulta->execute(array($this->usuario, $idPerfil));
        }

        public function obtenerProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM profesor WHERE legajo=?");
            $consulta->execute(array($this->legajo));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerCorreo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT email FROM usuario WHERE idUsuario=?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerProfesorPorEsp(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT legajo, nombre, apellido FROM profesor WHERE especialidad LIKE ?");
            $especialidad = "%".$this->especialidad."%";
            $consulta->execute(array($especialidad));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function actualizarDatosProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE profesor SET nombre = ?, apellido = ?, direccion = ?, telefono = ?, especialidad = ? WHERE legajo = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->especialidad, $this->legajo));
        }

        public function obtenerClasesDeProfesor(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idClase, tc.nombre, dias, horaDeInicio, horaDeFin, fechaDeInicio, fechaDeFin, s.nombreSalon AS salon, cupos FROM clase AS c, salon AS s, tipoclase AS tc WHERE c.salon = s.idSalon AND c.tipoClase = tc.idTipoClase AND c.profesor = ?");
            $consulta->execute(array($this->legajo));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function actualizarEstado(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE profesor SET estado = ? WHERE legajo = ?");
            
            return $consulta->execute(array($this->estado, $this->legajo));
        }

        public static function obtenerUltimoLegajo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(legajo) AS legajo FROM profesor");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerProfesores(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT legajo, nombre, apellido FROM profesor");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>