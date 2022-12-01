<?php

    class Usuario{
        
        private $idUsuario;
        private $email;
        private $contrasena;
        private $origenDeContrasena;

        function __construct(){
            
        }

        function setIdUsuario($idUsuario){
            
            $this->idUsuario = $idUsuario;
        }

        function setEmail($email){
            
            $this->email = $email;
        }

        function setContrasena($contrasena){
            
            $this->contrasena = $contrasena;
        }

        function setOrigenDeContrasena($origenDeContrasena){
            
            $this->origenDeContrasena = $origenDeContrasena;
        }

        function getIdUsuario(){
            
            return $this->idUsuario;
        }

        function getEmail(){
            
            return $this->email;
        }

        function getContrasena(){
            
            return $this->contrasena;
        }

        function getOrigenDeContrasena(){
            
            return $this->origenDeContrasena;
        }

        public function compararContrasena($contrasenaIngresada){
            return password_verify($contrasenaIngresada, $this->getContrasena());
        }

        public function guardarUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario(email, contrasena, origenDeContrasena) VALUES (?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->email, $this->contrasena, $this->origenDeContrasena));
        }

        public function actualizarContrasena(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuario SET contrasena = ? WHERE email = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->contrasena, $this->email));
        }

        public function actualizarOrigenDeContrasena(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuario SET origenDeContrasena = ? WHERE email = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->origenDeContrasena, $this->email));
        }

        public function obtenerPerfil(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idPerfil FROM perfilusuario WHERE idUsuario = ?");
            $consulta->execute(array($this->idUsuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerId(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario FROM usuario WHERE email = ?");
            $consulta->execute(array($this->email));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, email, contrasena, origenDeContrasena FROM usuario WHERE email=?");
            $consulta->execute(array($this->email));
            $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

            return $consulta->fetch();
        }

        public function actualizarCorreo(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuario SET email = ? WHERE idUsuario = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->email, $this->idUsuario));
        }

        public static function buscarCorreo($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, email FROM usuario WHERE email=?");
            $consulta->execute(array($email));
            $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

            return $consulta->fetch();
        }

        public static function obtenerUltimoId(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT MAX(idUsuario) AS idUsuario FROM usuario");
            $consulta->execute();

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }

?>