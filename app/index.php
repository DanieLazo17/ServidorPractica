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
    require __DIR__ . '/sesiones/SesionControlador.php';
    require __DIR__ . '/funciones/funciones.php';
    require __DIR__ . '/entidades/Usuario.php';
    require __DIR__ . '/entidades/Administrativo.php';
    require __DIR__ . '/entidades/Socio.php';
    require __DIR__ . '/entidades/TipoClase.php';
    require __DIR__ . '/entidades/Clase.php';
    require __DIR__ . '/entidades/Profesor.php';
    require __DIR__ . '/entidades/Cuota.php';
    require __DIR__ . '/entidades/Pago.php';
    require __DIR__ . '/controlador/UsuarioControlador.php';
    require __DIR__ . '/controlador/SocioControlador.php';
    require __DIR__ . '/controlador/TipoClaseControlador.php';
    require __DIR__ . '/controlador/ClaseControlador.php';
    require __DIR__ . '/controlador/ProfesorControlador.php';
    require __DIR__ . '/controlador/CuotaControlador.php';
    require __DIR__ . '/controlador/PagoControlador.php';

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
        //Ir a ruteo /Socio/Registro
        //$grupoUsuario->post("/Registro[/]", \UsuarioControlador::class . ':Registrar' );
        $grupoUsuario->post("/Recuperacion[/]", \UsuarioControlador::class . ':RecuperarContrasena' );
        $grupoUsuario->post("/CambioDeContrasena[/]", \UsuarioControlador::class . ':CambiarContrasena' );
        $grupoUsuario->get("[/]", \SesionControlador::class . ':Cerrar' );
    });

    $app->group("/Socio", function (RouteCollectorProxy $grupoSocio) {
        $grupoSocio->post("/Registro[/]", \SocioControlador::class . ':RegistrarSocio' );
        $grupoSocio->get("[/]", \SocioControlador::class . ':RetornarSocios' );
        $grupoSocio->get("/{nroSocio}[/]", \SocioControlador::class . ':RetornarSocio' );
        $grupoSocio->post("/Inscripcion[/]", \SocioControlador::class . ':InscribirAClase' );
        //Actualizar Socio
        //$grupoSocio->post("/ActualizacionDeDireccion/{nroSocio}[/]", \SocioControlador::class . ':ActualizarDireccion' );
        //$grupoSocio->post("/ActualizacionDeTelefono/{nroSocio}[/]", \SocioControlador::class . ':ActualizarTelefono' );
        $grupoSocio->post("/Actualizacion/{nroSocio}[/]", \SocioControlador::class . ':ActualizarDatos' );
        $grupoSocio->post("/Borrar/{nroSocio}[/]", \SocioControlador::class . ':DeshabilitarSocio' );
    });

    $app->group("/Clase", function (RouteCollectorProxy $grupoClase) {
        $grupoClase->get("/{tipoClase}[/]", \ClaseControlador::class . ':RetornarClasesDelTipo' );
    });

    $app->group("/TipoClase", function (RouteCollectorProxy $grupoTipoClase) {
        $grupoTipoClase->get("[/]", \TipoClaseControlador::class . ':RetornarTiposDeClases' );
    });

    $app->group("/Cuota", function (RouteCollectorProxy $grupoCuota) {
        $grupoCuota->get("/Estado/{nroSocio}[/]", \CuotaControlador::class . ':ObtenerEstadoDeCuotas' );
        $grupoCuota->get("[/]", \CuotaControlador::class . ':GenerarCuotas' );
        //$grupoCuota->get("[/]", \CuotaControlador::class . ':GenerarCuotasDeSocio' );
        $grupoCuota->get("/{nroSocio}[/]", \CuotaControlador::class . ':ObtenerCuotasDeSocio' );
    });

    $app->group("/Pago", function (RouteCollectorProxy $grupoPago) {
        $grupoPago->post("[/]", \PagoControlador::class . ':PagarCuotas' );
    });

    $app->post('/hello/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];
        $response->getBody()->write("Hello, $name");
        return $response;
    });

    $app->run();
?>