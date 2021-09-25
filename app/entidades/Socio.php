<?php

    class Socio{
        
        private $nroSocio;
        private $nombre;
        private $apellido;
        private $direccion;
        private $telefono;
        private $estado;
        private $usuario;
        private $fechaDeAlta;

        function __construct(){
            
        }

        function setNroSocio($nroSocio){
            
            $this->nroSocio = $nroSocio;
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

        function setEstado($estado){
            
            $this->estado = $estado;
        }

        function setUsuario($usuario){
            
            $this->usuario = $usuario;
        }

        function setFechaDeAlta($fechaDeAlta){
            
            $this->fechaDeAlta = $fechaDeAlta;
        }

        function getNroSocio(){
            
            return $this->nroSocio;
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

        function getEstado(){
            
            return $this->estado;
        }

        function getUsuario(){
            
            return $this->usuario;
        }

        function getFechaDeAlta(){
            
            return $this->fechaDeAlta;
        }

        public function guardarSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO socio(nroSocio, nombre, apellido, direccion, telefono, usuario, fechaDeAlta) VALUES (?,?,?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroSocio, $this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->usuario, $this->fechaDeAlta));
        }

        public function agregarPerfil(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO perfilUsuario(idUsuario, idPerfil) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            $idPerfil = "SOC";
            return $consulta->execute(array($this->usuario, $idPerfil));
        }

        public function guardarInscripcionAClase($idClase){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO socioclase(socio, clase) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroSocio, $idClase));
        }

        public function obtenerSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM socio WHERE nroSocio=?");
            $consulta->execute(array($this->nroSocio));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function guardarDireccion(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE socio SET direccion = ?WHERE nroSocio = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->direccion, $this->nroSocio));
        }

        public function guardarTelefono(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE socio SET telefono = ? WHERE nroSocio = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->telefono, $this->nroSocio));
        }

        public static function obtenerSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio, nombre, apellido FROM socio");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerSociosParaGenerarCuotas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio, estado FROM socio");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerCorreo($idUsuario){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT email FROM usuario WHERE idUsuario=?");
            $consulta->execute(array($idUsuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function obtenerUltimoNroSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(nroSocio) AS nroSocio FROM socio");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }

?>