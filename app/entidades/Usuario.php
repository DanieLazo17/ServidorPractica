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
    }

?>