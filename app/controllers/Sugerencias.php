<?php

/**
 * Clase Sugerencias.
 * Gestiona la recepción y visualización de sugerencias por parte de los usuarios.
 * Todo se almacena en memoria (¡nada de guardar en bases de datos!).
 */
class Sugerencias {
    /**
     * @var object $twig Motor de plantillas Twig para renderizar vistas.
     */
    private $twig;

    /**
     * Constructor de la clase Sugerencias.
     * Inicializa Twig para su uso en las vistas.
     *
     * @param object $twig Instancia del motor de plantillas Twig.
     */
    public function __construct($twig) {
        $this->twig = $twig;
    }

    /**
     * Gestiona las sugerencias de los usuarios.
     * - Si la solicitud es POST, procesa el formulario y añade la sugerencia a la sesión.
     * - Siempre renderiza la vista `sugerencias.twig` con la lista de sugerencias almacenadas.
     *
     * @param object $request Objeto Request de Slim con los datos de la solicitud.
     * @param object $response Objeto Response de Slim para enviar la respuesta.
     * @return object Respuesta renderizada con la vista Twig.
     */
    public function gestionar($request, $response) {
        if ($request->getMethod() === 'POST') {
            // Obtiene los datos del formulario
            $datos = $request->getParsedBody();

            // Añade la sugerencia a la sesión
            $_SESSION['sugerencias'][] = $datos['sugerencia']; // ¡Gracias por tu idea!
        }

        // Recupera todas las sugerencias almacenadas en la sesión
        $sugerencias = $_SESSION['sugerencias']; 

        // Renderiza la vista con la lista de sugerencias
        return $this->twig->render($response, 'sugerencias.twig', ['sugerencias' => $sugerencias]);
    }
}
