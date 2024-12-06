<?php

/**
 * Clase Registro.
 * Gestiona el registro de usuarios de forma temporal (¡aquí no hay base de datos!).
 * Los datos se almacenan en la sesión y se muestran en la vista correspondiente.
 */
class Registro {
    /**
     * @var object $twig Motor de plantillas Twig para renderizar vistas.
     */
    private $twig;

    /**
     * Constructor de la clase Registro.
     * Inicializa Twig para su uso en las vistas.
     *
     * @param object $twig Instancia del motor de plantillas Twig.
     */
    public function __construct($twig) {
        $this->twig = $twig;
    }

    /**
     * Gestiona las peticiones relacionadas con el registro.
     * - Si la petición es POST, procesa el formulario y guarda el usuario en la sesión.
     * - Siempre renderiza la vista `registro.twig` con la lista de usuarios registrados.
     *
     * @param object $request Objeto Request de Slim con los datos de la solicitud.
     * @param object $response Objeto Response de Slim para enviar la respuesta.
     * @return object Respuesta renderizada con la vista Twig.
     */
    public function gestionar($request, $response) {
        if ($request->getMethod() === 'POST') {
            // Obtiene los datos del formulario
            $datos = $request->getParsedBody();
            
            // Crea un nuevo usuario y lo añade a la sesión
            $usuario = [
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
            ];
            $_SESSION['usuarios'][] = $usuario; // ¡Bienvenido a bordo!
        }

        // Recupera todos los usuarios almacenados en la sesión
        $usuarios = $_SESSION['usuarios']; 

        // Renderiza la vista con la lista de usuarios
        return $this->twig->render($response, 'registro.twig', ['usuarios' => $usuarios]);
    }
}
