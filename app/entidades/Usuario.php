<?php

    class Usuario{
        
        private $idUsuario;
        private $email;
        private $contrasena;

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

        function getIdUsuario(){
            
            return $this->idUsuario;
        }

        function getEmail(){
            
            return $this->email;
        }

        function getContrasena(){
            
            return $this->contrasena;
        }

        public static function obtenerUsuario($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT idUsuario, email, contrasena FROM usuario WHERE email=?");
            $consulta->execute(array($email));
            $consulta->setFetchMode(PDO::FETCH_CLASS, 'Usuario');

            return $consulta->fetch();
        }

        public function compararContrasena($contrasenaIngresada){
            
            return password_verify($contrasenaIngresada, $this->getContrasena());
        }

        public function guardarUsuario(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuario(email, contrasena) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->email, $this->contrasena));
        }

        public function actualizarContrasena(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuario SET contrasena = ? WHERE email = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->contrasena, $this->email));
        }

        public static function buscarCorreo($email){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT email FROM usuario WHERE email=?");
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