<?php
    class Destino {
  
        private $idDestino;
        private $nombre;
        private $tipoTurismo;
        private $pais;
        private $provincia;
        private $tipoAlojamiento;
        private $tipoComida;
        private $comunidad;
        private $imagenPath;

        public function __construct(){
            
        }

        public function setIdDestino($idDestino){
            
            $this->idDestino = $idDestino;
        }

        public function setNombre($nombre){
            
            $this->nombre = $nombre;
        }

        public function setTipoTurismo($tipoTurismo){
            
            $this->tipoTurismo = $tipoTurismo;
        }

        public function setPais($pais){
            
            $this->pais = $pais;
        }

        public function setProvincia($provincia){
            
            $this->provincia = $provincia;
        }

        public function getNombre(){
            
            return $this->nombre;
        }

        public function getIdDestino(){
            
            return $this->idDestino;
        }

        public function getTipoTurismo(){
            
            return $this->tipoTurismo;
        }

        public function getPais(){
            
            return $this->pais;
        }

        public function getProvincia(){
            
            return $this->provincia;
        }

        public function guardarDestino(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO destino(nombre, tipoTurismo, pais, provincia) VALUES (?,?,?,?)");
            $consulta->execute(array($this->nombre, $this->tipoTurismo, $this->pais, $this->provincia));
        }

        public static function obtenerDestinos(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM destino");
            $consulta->execute();
    
            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Destino');
        }
    }
?>