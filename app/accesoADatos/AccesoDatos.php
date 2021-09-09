<?php

    class AccesoDatos {

        private static $objAccesoDatos;
        private $objetoPDO;

        private function __construct(){
            try {
                //$this->objetoPDO = new PDO('mysql:host=remotemysql.com:3306;dbname=2PCWh7y5Lf;charset=utf8', '2PCWh7y5Lf', '09enEZGbMN', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $this->objetoPDO = new PDO('mysql:host=localhost:3306;dbname=gimnasio;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $this->objetoPDO->exec("SET CHARACTER SET utf8");
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage();
                die();
            }
        }
        
        //Patrón Singleton
        public static function obtenerInstancia(){
            if (!isset(self::$objAccesoDatos)) {
                self::$objAccesoDatos = new AccesoDatos();
            }
            return self::$objAccesoDatos;
        }

        public function prepararConsulta($sql){
            return $this->objetoPDO->prepare($sql);
        }

        //Cerramos conexión de base de datos
        public function cerrarConexion(){
            $this->objetoPDO = null;
            self::$objAccesoDatos = null;
        }

        public function obtenerUltimoId(){
            return $this->objetoPDO->lastInsertId();
        }

        public function __clone(){
            trigger_error('ERROR: La clonación de este objeto no está permitida', E_USER_ERROR);
        }
    }

?>