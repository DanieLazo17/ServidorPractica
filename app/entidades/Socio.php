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
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO socio(nroSocio, nombre, apellido, direccion, telefono, estado, usuario, fechaDeAlta) VALUES (?,?,?,?,?,?,?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroSocio, $this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->estado , $this->usuario, $this->fechaDeAlta));
        }

        public function agregarPerfil(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO perfilusuario(idUsuario, idPerfil) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            $idPerfil = "SOC";
            return $consulta->execute(array($this->usuario, $idPerfil));
        }

        public function guardarInscripcionAClase($idClasePorDia){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO socioclase(socio, clase) VALUES (?,?)");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroSocio, $idClasePorDia));
        }

        public function guardarAsistenciaAClase($idClasePorDia,$presente){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE socioclase SET presente=? WHERE socio=? and clase= ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($presente, $this->nroSocio, $idClasePorDia));
        }
        public function guardarDesinscripcionAClase($idClasePorDia){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM  socioclase WHERE socio= ? AND clase = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nroSocio, $idClasePorDia));
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

        public function actualizarDatosSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE socio SET nombre = ?, apellido = ?, direccion = ?, telefono = ? WHERE nroSocio = ?");
            //Devuelve true en caso de éxito o false en caso de error.
            return $consulta->execute(array($this->nombre, $this->apellido, $this->direccion, $this->telefono, $this->nroSocio));
        }

        public function actualizarEstado(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("UPDATE socio SET estado = ? WHERE nroSocio = ?");
            
            return $consulta->execute(array($this->estado, $this->nroSocio));
        }

        public function obtenerClasesHabilitadas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT cxd.idClasePorDia, cxd.idClase, cxd.fecha, suscripciones.nombreActividad, cl.dias, cl.horaDeInicio, salon.nombreSalon, CONCAT(p.nombre, ' ',p.apellido) AS profesor, cl.cupos, cl.cupos-COUNT(sc.clase) AS cupoDisponible 
            FROM clase AS cl, clasexdia AS cxd, socio AS s, salon, profesor AS p, socioclase AS sc,
                (SELECT a.idActividad AS idActividad, a.nombre AS nombreActividad, su.cantClases, co.fechaEmision AS fechaEmision, co.fechaVencimiento AS fechaVencimiento
                FROM compra AS co, suscripcion AS su, socio AS so, actividad AS a
                WHERE co.idSuscripcion = su.idSuscripcion 
                AND co.socio = so.nroSocio
                AND su.actividad = a.idActividad
                AND co.socio = ?
                AND CURRENT_DATE BETWEEN co.fechaEmision AND co.fechaVencimiento
                AND co.estado = 'PAGADA' OR co.estado = 'BONIFICADA') AS suscripciones
            WHERE cl.tipoActividad = suscripciones.idActividad
            AND cl.idClase = cxd.idClase
            AND cl.salon = salon.idSalon
            AND cl.profesor = p.legajo
            AND sc.clase = cxd.idClasePorDia
            AND sc.socio = s.nroSocio
            AND cxd.fecha BETWEEN suscripciones.fechaEmision AND suscripciones.fechaVencimiento
            GROUP BY sc.clase
            UNION
            SELECT cxd.idClasePorDia, cxd.idClase, cxd.fecha, suscripciones.nombreActividad, c.dias, c.horaDeInicio, salon.nombreSalon, CONCAT(p.nombre, ' ',p.apellido) AS profesor, c.cupos, c.cupos AS cupoDisponible
            FROM clasexdia AS cxd, clase AS c, profesor AS p, actividad AS a, salon,
                (SELECT a.idActividad AS idActividad, a.nombre AS nombreActividad, su.cantClases, co.fechaEmision AS fechaEmision, co.fechaVencimiento AS fechaVencimiento
                FROM compra AS co, suscripcion AS su, socio AS so, actividad AS a
                WHERE co.idSuscripcion = su.idSuscripcion 
                AND co.socio = so.nroSocio 
                AND su.actividad = a.idActividad
                AND co.socio = ?
                AND CURRENT_DATE BETWEEN co.fechaEmision AND co.fechaVencimiento
                AND co.estado = 'PAGADA' OR co.estado = 'BONIFICADA') AS suscripciones
            WHERE c.tipoActividad = suscripciones.idActividad
            AND cxd.idClase = c.idClase 
            AND c.profesor = p.legajo
            AND c.tipoActividad = a.idActividad
            AND c.salon = salon.idSalon
            AND cxd.fecha BETWEEN suscripciones.fechaEmision AND suscripciones.fechaVencimiento
            AND cxd.idClasePorDia NOT IN
            (SELECT DISTINCT clase
            FROM socioclase)
            ORDER BY fecha ASC");
            $consulta->execute(array($this->nroSocio, $this->nroSocio));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerEstado(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT estado FROM socio WHERE usuario = ?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerNumeroSocio(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio FROM socio WHERE usuario = ?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerSuscripcionesActivas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT c.idCompra, c.idSuscripcion, su.nombre AS nombreSuscripcion, a.idActividad, a.nombre AS nombreActividad, su.cantClases, c.fechaVencimiento
            FROM compra AS c, suscripcion AS su, socio AS s, actividad AS a
            WHERE c.idSuscripcion = su.idSuscripcion 
            AND c.socio = s.nroSocio 
            AND su.actividad = a.idActividad
            AND c.socio = ?
            AND CURRENT_DATE BETWEEN c.fechaEmision AND c.fechaVencimiento
            AND c.estado = 'PAGADA' OR c.estado = 'BONIFICADA'");
            $consulta->execute(array($this->nroSocio));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerNombreYEstado(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT CONCAT(nombre, ' ',apellido) AS nombreCompleto, estado FROM socio WHERE usuario = ?");
            $consulta->execute(array($this->usuario));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function obtenerClasesInscriptas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT cxd.idClasePorDia, cxd.idClase, a.nombre, cxd.fecha, c.dias, c.horaDeInicio, p.nombre, s.nombreSalon
            FROM socioclase AS sc, clasexdia AS cxd, clase AS c, actividad AS a, profesor AS p, salon AS s 
            WHERE sc.clase = cxd.idClasePorDia
            AND cxd.idClase = c.idClase
            AND c.tipoActividad = a.idActividad
            AND c.profesor = p.legajo
            AND c.salon = s.idSalon
            AND sc.socio = ?     
            AND cxd.fecha BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 1 MONTH)");
            $consulta->execute(array($this->nroSocio));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerHistorialInscripciones($FechaMin, $FechaMax){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT cxd.idClasePorDia, cxd.idClase, a.nombre, cxd.fecha, c.dias, c.horaDeInicio, p.nombre, s.nombreSalon
            FROM socioclase AS sc, clasexdia AS cxd, clase AS c, actividad AS a, profesor AS p, salon AS s 
            WHERE sc.clase = cxd.idClasePorDia
            AND cxd.idClase = c.idClase
            AND c.tipoActividad = a.idActividad
            AND c.profesor = p.legajo
            AND c.salon = s.idSalon
            AND sc.socio = ?     
            AND cxd.fecha BETWEEN ? AND ?");
            $consulta->execute(array($this->nroSocio, $FechaMin, $FechaMax));

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerSocios(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio, nombre, apellido, usuario FROM socio");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public static function obtenerSociosParaGenerarCuotas(){
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT nroSocio FROM socio WHERE estado = ?");
            $estado = "HAB";
            $consulta->execute(array($estado));

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