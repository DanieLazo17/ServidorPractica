<?php
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    session_start();
    error_reporting(-1);
    ini_set('display_errors', 1);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface;
    use Slim\Factory\AppFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;

    require __DIR__ . '/../vendor/autoload.php';

    require __DIR__ . '/accesoADatos/AccesoDatos.php';
    require __DIR__ . '/funciones/funciones.php';
    require __DIR__ . '/entidades/Usuario.php';
    require __DIR__ . '/entidades/Administrativo.php';
    require __DIR__ . '/entidades/Socio.php';
    require __DIR__ . '/entidades/Actividad.php';
    require __DIR__ . '/entidades/Clase.php';
    require __DIR__ . '/entidades/Profesor.php';
    require __DIR__ . '/entidades/Compra.php';
    require __DIR__ . '/entidades/Pago.php';
    require __DIR__ . '/entidades/Salon.php';
    require __DIR__ . '/entidades/Producto.php';
    require __DIR__ . '/entidades/Venta.php';
    require __DIR__ . '/entidades/Rutina.php';
    require __DIR__ . '/entidades/Suscripcion.php';
    require __DIR__ . '/entidades/ClasePorDia.php';
    require __DIR__ . '/entidades/Informe.php';
    require __DIR__ . '/controlador/UsuarioControlador.php';
    require __DIR__ . '/controlador/SocioControlador.php';
    require __DIR__ . '/controlador/ActividadControlador.php';
    require __DIR__ . '/controlador/ClaseControlador.php';
    require __DIR__ . '/controlador/ProfesorControlador.php';
    require __DIR__ . '/controlador/CompraControlador.php';
    require __DIR__ . '/controlador/PagoControlador.php';
    require __DIR__ . '/controlador/SalonControlador.php';
    require __DIR__ . '/controlador/ProductoControlador.php';
    require __DIR__ . '/controlador/VentaControlador.php';
    require __DIR__ . '/controlador/AdministrativoControlador.php';
    require __DIR__ . '/controlador/RutinaControlador.php';
    require __DIR__ . '/controlador/SuscripcionControlador.php';
    require __DIR__ . '/controlador/ClasePorDiaControlador.php';
    require __DIR__ . '/controlador/InformeControlador.php';

    //Crear un objeto
    $app = AppFactory::create();

    //Interceptar paquete entrante
    $app->addErrorMiddleware(true,true,true);

    // Habilitar CORS
    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        // $routeContext = RouteContext::fromRequest($request);
        // $routingResults = $routeContext->getRoutingResults();
        // $methods = $routingResults->getAllowedMethods();
        
        $response = $handler->handle($request);
    
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
    
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', 'get,post');
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
    
        // Optional: Allow Ajax CORS requests with Authorization header
        // $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
    
        return $response;
    });

    $app->get('[/]', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Bienvenido");
        return $response;
    });

    $app->group("/Usuario", function (RouteCollectorProxy $grupoUsuario) {
        $grupoUsuario->post("[/]", \UsuarioControlador::class . ':Validar' );
        $grupoUsuario->post("/Correo[/]", \UsuarioControlador::class . ':ComprobarCorreo' );
        $grupoUsuario->post("/Recuperacion[/]", \UsuarioControlador::class . ':RecuperarContrasena' );
        $grupoUsuario->post("/CambioDeContrasena[/]", \UsuarioControlador::class . ':CambiarContrasena' );
        $grupoUsuario->post("/EditarCorreo/{idUsuario}[/]", \UsuarioControlador::class . ':CambiarCorreo' );
        $grupoUsuario->get("[/]", \SesionControlador::class . ':Cerrar' );
    });

    $app->group("/Administrativo", function (RouteCollectorProxy $grupoAdministrativo) {
        $grupoAdministrativo->post("/Perfil[/]", \AdministrativoControlador::class . ':RetornarPerfil' );
        $grupoAdministrativo->post("/ModificacionDePerfil[/]", \AdministrativoControlador::class . ':ActualizarDatos' );
    });

    $app->group("/Socio", function (RouteCollectorProxy $grupoSocio) {
        $grupoSocio->post("/Registro[/]", \SocioControlador::class . ':RegistrarSocio' );
        $grupoSocio->get("[/]", \SocioControlador::class . ':RetornarSocios' );
        $grupoSocio->get("/{nroSocio}[/]", \SocioControlador::class . ':RetornarSocio' );
        $grupoSocio->get("/Suscripciones/{nroSocio}[/]", \SocioControlador::class . ':RetornarSuscripcionesActivas' );
        $grupoSocio->get("/ClasesRestantes/{nroSocio}[/]", \SocioControlador::class . ':RetornarClasesRestantes' );
        $grupoSocio->get("/ClasesHabilitadas/{nroSocio}[/]", \SocioControlador::class . ':RetornarClasesHabilitadas' );
        $grupoSocio->get("/Inscripciones/{nroSocio}[/]", \SocioControlador::class . ':RetornarClasesInscriptas' );
        $grupoSocio->post("/HistorialInscripciones/{nroSocio}[/]", \SocioControlador::class . ':RetornarHistorialInscripciones' );
        $grupoSocio->post("/Inscripcion[/]", \SocioControlador::class . ':InscribirAClase' );
        $grupoSocio->post("/Desinscripcion[/]", \SocioControlador::class . ':DesinscribirAClase' );
        $grupoSocio->post("/Asistencia[/]", \SocioControlador::class . ':GuardarAsistenciaAClase' );
        $grupoSocio->post("/HistorialSuscripciones/{nroSocio}[/]", \SocioControlador::class . ':RetornarHistorialSuscripciones' );
        //$grupoSocio->post("/ActualizacionDeDireccion/{nroSocio}[/]", \SocioControlador::class . ':ActualizarDireccion' );
        //$grupoSocio->post("/ActualizacionDeTelefono/{nroSocio}[/]", \SocioControlador::class . ':ActualizarTelefono' );
        $grupoSocio->post("/Actualizacion/{nroSocio}[/]", \SocioControlador::class . ':ActualizarDatos' );
        $grupoSocio->post("/Borrar/{nroSocio}[/]", \SocioControlador::class . ':DeshabilitarSocio' );
        $grupoSocio->post("/Habilitacion/{nroSocio}[/]", \SocioControlador::class . ':HabilitarSocio' );
        $grupoSocio->post("/Correo[/]", \SocioControlador::class . ':RetornarNumeroDeSocio' );
    });

    $app->group("/Actividad", function (RouteCollectorProxy $grupoActividad) {
        $grupoActividad->post("/Registro[/]", \ActividadControlador::class . ':Registrar' );
        $grupoActividad->get("[/]", \ActividadControlador::class . ':RetornarActividades' );
    });

    $app->group("/Clase", function (RouteCollectorProxy $grupoClase) {
        $grupoClase->post("/Registro[/]", \ClaseControlador::class . ':RegistrarClase' );
        $grupoClase->post("/EnCurso[/]", \ClaseControlador::class . ':RetornarClasesEnCurso' );
        $grupoClase->post("/Actualizacion/{idClase}[/]", \ClaseControlador::class . ':ActualizarDatos' );
        $grupoClase->get("/Profesor/{legajo}[/]", \ClaseControlador::class . ':RetornarClasesDelProfesor' );
        $grupoClase->get("/Socios/{idClase}[/]", \ClaseControlador::class . ':RetornarSociosDeClase' );
        $grupoClase->get("/Consulta/{idClase}[/]", \ClaseControlador::class . ':RetornarClase' );
        $grupoClase->get("/{Actividad}[/]", \ClaseControlador::class . ':RetornarActividades' );
        $grupoClase->get("[/]", \ClaseControlador::class . ':RetornarClases' );
    });

    $app->group("/Compra", function (RouteCollectorProxy $grupoCompra) {
        $grupoCompra->post("/Suscripcion[/]", \CompraControlador::class . ':AdquirirSuscripcion' );
        $grupoCompra->get("/Estado/{nroSocio}[/]", \CompraControlador::class . ':ObtenerEstadoDeCompras' );
        $grupoCompra->get("/{nroSocio}[/]", \CompraControlador::class . ':ObtenerComprasDeSocio' );
    });

    $app->group("/Pago", function (RouteCollectorProxy $grupoPago) {
        $grupoPago->post("[/]", \PagoControlador::class . ':PagarCompras' );
        $grupoPago->post("/Historial[/]", \PagoControlador::class . ':RetornarPagos' );
    });

    $app->group("/Profesor", function (RouteCollectorProxy $grupoProfesor) {
        $grupoProfesor->post("/Registro[/]", \ProfesorControlador::class . ':RegistrarProfesor' );
        $grupoProfesor->get("[/]", \ProfesorControlador::class . ':RetornarProfesores' );
        $grupoProfesor->get("/{legajo}[/]", \ProfesorControlador::class . ':RetornarProfesor' );
        $grupoProfesor->get("/Clase/{legajo}[/]", \ProfesorControlador::class . ':RetornarClasesACargo' );
        $grupoProfesor->post("/Especialidad[/]", \ProfesorControlador::class . ':TraerProfesoresPorEsp' );
        $grupoProfesor->post("/Actualizacion/{legajo}[/]", \ProfesorControlador::class . ':ActualizarDatos' );
        $grupoProfesor->post("/Borrar/{legajo}[/]", \ProfesorControlador::class . ':DeshabilitarProfesor' );
        $grupoProfesor->post("/Habilitacion/{legajo}[/]", \ProfesorControlador::class . ':HabilitarProfesor' );
        $grupoProfesor->post("/Correo[/]", \ProfesorControlador::class . ':RetornarLegajoDeProfesor' );
    });

    $app->group("/Salon", function (RouteCollectorProxy $grupoSalon) {
        $grupoSalon->get("[/]", \SalonControlador::class . ':RetornarSalones' );
        $grupoSalon->post("/Actualizacion/{idSalon}[/]", \SalonControlador::class . ':Actualizar' );
    });

    $app->group("/Rutina", function (RouteCollectorProxy $grupoRutina) {
        $grupoRutina->post("/Registro[/]", \RutinaControlador::class . ':Registrar' );
        $grupoRutina->post("/Actualizacion/{idRutina}[/]", \RutinaControlador::class . ':Actualizar' );
        $grupoRutina->get("[/]", \RutinaControlador::class . ':RetornarRutinas' );
    });
    
    $app->group("/Suscripcion", function (RouteCollectorProxy $grupoSuscripcion) {
        $grupoSuscripcion->post("/Registro[/]", \SuscripcionControlador::class . ':RegistrarSuscripcion' );
        $grupoSuscripcion->post("/Actualizacion/{idSuscripcion}[/]", \SuscripcionControlador::class . ':ActualizarDatos' );
        $grupoSuscripcion->get("[/]", \SuscripcionControlador::class . ':RetornarSuscripciones' );
        $grupoSuscripcion->get("/{idSuscripcion}[/]", \SuscripcionControlador::class . ':RetornarUnaSuscripcion' );
    });

    $app->group("/ClasePorDia", function (RouteCollectorProxy $grupoClasePorDia) {
        $grupoClasePorDia->get("[/]", \ClasePorDiaControlador::class . ':RetornarClasesPorDia' );        
        $grupoClasePorDia->get("/{idClasePorDia}[/]", \ClasePorDiaControlador::class . ':RetornarInscriptos' );
    });

    $app->group("/Informe", function (RouteCollectorProxy $grupoInforme) {
        $grupoInforme->get("/ClasesXDia[/]", \InformeControlador::class . ':RetornarClasesXDia' );
        $grupoInforme->get("/InscriptosXActividad[/]", \InformeControlador::class . ':RetornarInscriptosXActividad' );
    });

    $app->run();
?>