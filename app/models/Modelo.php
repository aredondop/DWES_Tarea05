<?php

/**
 * Comprueba si el archivo ha sido llamado directamente.
 * Si no está definida la constante `CON_CONTROLADOR`, finaliza la ejecución del script.
 */
if (!defined('CON_CONTROLADOR')) {
    die('Acceso directo no permitido a este archivo.');
}

/**
 * Clase Modelo.
 * Proporciona acceso a los datos de los artículos, usuarios y sugerencias.
 * Es el "almacén" central de datos de la aplicación.
 */
class Modelo {
    /**
     * @var array $articulos Lista de artículos disponibles en la tienda.
     * Cada artículo tiene un nombre, descripción y precio.
     */
    private $articulos = [
        1 => ['nombre' => 'Camiseta', 'descripcion' => 'Camiseta de algodón', 'precio' => 15.99],
        2 => ['nombre' => 'Pantalón', 'descripcion' => 'Pantalón vaquero', 'precio' => 29.99],
        3 => ['nombre' => 'Zapatos', 'descripcion' => 'Zapatos de cuero', 'precio' => 59.99],
    ];

    /**
     * @var array $sugerencias Lista de sugerencias realizadas por los usuarios.
     * Actualmente está vacía ya que se gestiona desde la sesión.
     */
    private $sugerencias = [];

    /**
     * @var array $usuarios Lista de usuarios registrados.
     * Actualmente está vacía ya que se gestiona desde la sesión.
     */
    private $usuarios = [];

    /**
     * Obtiene la lista completa de artículos.
     *
     * @return array Lista de artículos disponibles.
     */
    public function getArticulos() {
        return $this->articulos;
    }

    /**
     * Obtiene los detalles de un artículo específico.
     *
     * @param int $id Identificador del artículo.
     * @return array|null Datos del artículo si existe, o `null` si no se encuentra.
     */
    public function getArticulo($id) {
        return $this->articulos[$id] ?? null; // Devuelve el artículo o "nada que ver aquí" si no existe
    }
}
