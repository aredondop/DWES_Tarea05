<?php

/**
 * Archivo principal de la aplicación.
 * Define rutas y controladores, inicia la sesión y se asegura de que todo funcione como un reloj suizo.
 */

define('CON_CONTROLADOR', true);

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

// Autoload de clases y controladores
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/controllers/Controlador.php';
require __DIR__ . '/../app/controllers/Sugerencias.php';
require __DIR__ . '/../app/controllers/Registro.php';

session_start();

/**
 * Inicializa las variables de sesión si no están definidas.
 * Aquí guardamos las sugerencias y los registros de usuarios como en un cuaderno de notas.
 */
if (!isset($_SESSION['sugerencias'])) {
    $_SESSION['sugerencias'] = [];
}
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

// Creación de la aplicación Slim
$app = AppFactory::create(); // ¡Vamos a construir esta maravilla!
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

/**
 * Configuración de Twig como el motor de vistas.
 * ¿Quién dijo que PHP no podía ser elegante? Twig lo hace posible.
 */
$twig = Twig::create(__DIR__ . '/../app/views');
$app->add(TwigMiddleware::create($app, $twig));

// Instanciación de los controladores
$controlador = new Controlador($twig); // El cerebro principal de nuestra app
$sugerencias = new Sugerencias($twig); // ¡Para escuchar a nuestros usuarios!
$registro = new Registro($twig); // ¡Aquí damos la bienvenida a nuevos amigos!

/**
 * Definición de las rutas.
 * Aquí se establece el "GPS" de nuestra aplicación.
 */
$app->get('/', [$controlador, 'mostrarListado']); // Página principal: lista de artículos
$app->get('/articulo', [$controlador, 'mostrarDetalle']); // Detalle de un artículo específico
$app->map(['GET', 'POST'], '/sugerencias', [$sugerencias, 'gestionar']); // Gestión de sugerencias
$app->map(['GET', 'POST'], '/registro', [$registro, 'gestionar']); // Registro de usuarios

/**
 * Ejecuta la aplicación Slim.
 * Con esto, ponemos todo en marcha y dejamos que la magia ocurra.
 */
$app->run(); // ¡A funcionar!
