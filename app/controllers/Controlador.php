<?php

/**
 * Controlador principal de la aplicación.
 * Gestiona las operaciones relacionadas con los artículos: listado y detalle.
 * Actúa como el "maestro de ceremonias" entre el modelo y las vistas.
 */

require_once __DIR__ . '/../models/Modelo.php';

/**
 * Clase Controlador.
 * Coordina las acciones de la aplicación para los artículos.
 */
class Controlador {
    /**
     * @var object $modelo Instancia del modelo para acceder a los datos de los artículos.
     * @var object $twig Motor de plantillas Twig para renderizar las vistas.
     */
    private $modelo;
    private $twig;

    /**
     * Constructor de la clase Controlador.
     * Inicializa el modelo y Twig para su uso en los métodos de la clase.
     *
     * @param object $twig Instancia del motor de plantillas Twig.
     */
    public function __construct($twig) {
        $this->modelo = new Modelo(); // Nuestro proveedor de datos
        $this->twig = $twig; // Nuestra herramienta para hacer las vistas bonitas
    }

    /**
     * Muestra el listado de artículos.
     * - Obtiene los artículos del modelo.
     * - Renderiza la vista `listado.twig` con los datos obtenidos.
     *
     * @param object $request Objeto Request de Slim con los datos de la solicitud.
     * @param object $response Objeto Response de Slim para enviar la respuesta.
     * @return object Respuesta renderizada con la vista Twig.
     */
    public function mostrarListado($request, $response) {
        // Obtenemos los artículos del modelo
        $articulos = $this->modelo->getArticulos();

        // Renderizamos la vista con los artículos
        return $this->twig->render($response, 'listado.twig', ['articulos' => $articulos]);
    }

    /**
     * Muestra el detalle de un artículo.
     * - Obtiene el ID del artículo desde los parámetros de la URL.
     * - Llama al modelo para obtener los datos del artículo.
     * - Si el artículo no existe, devuelve un mensaje de error con estado 404.
     * - Si el artículo existe, renderiza la vista `detalle.twig` con sus datos.
     *
     * @param object $request Objeto Request de Slim con los datos de la solicitud.
     * @param object $response Objeto Response de Slim para enviar la respuesta.
     * @return object Respuesta renderizada con la vista Twig o mensaje de error.
     */
    public function mostrarDetalle($request, $response) {
        // Obtenemos el ID del artículo de los parámetros de la URL
        $id = $request->getQueryParams()['id'] ?? null;

        // Obtenemos los datos del artículo del modelo
        $articulo = $this->modelo->getArticulo($id);

        if (!$articulo) {
            // Artículo no encontrado
            $response->getBody()->write("Artículo no encontrado.");
            return $response->withStatus(404); // Devuelve un 404 Not Found
        }

        // Renderizamos la vista con los datos del artículo
        return $this->twig->render($response, 'detalle.twig', ['articulo' => $articulo]);
    }
}
