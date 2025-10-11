<?php

if (!function_exists('normalize_input')) {
    /**
     * Limpia un arreglo de datos (por ejemplo, $_POST o partes de él),
     * eliminando espacios y convirtiendo las cadenas vacías en NULL.
     *
     * Ideal para usar antes de insertar o actualizar en base de datos,
     * evitando guardar cadenas vacías ("") en campos que admiten NULL.
     *
     * @param array $data Arreglo asociativo (por ejemplo, $this->request->getPost()).
     * @return array Arreglo normalizado (cadenas vacías reemplazadas por null).
     *
     * Ejemplo:
     *   $personaData = normalize_input([
     *       'nombre'   => '  Carlos  ',
     *       'telefono' => '   ',
     *   ]);
     *   // Resultado:
     *   // ['nombre' => 'Carlos', 'telefono' => null]
     */
    function normalize_input(array $data): array
    {
        return array_map(static function ($value) {
            if (is_array($value)) {
                return normalize_input($value);
            }
            
            if (is_string($value)) {
                $trimmed = trim($value);
                return $trimmed === '' ? null : $trimmed;
            }

            return $value;
        }, $data);
    }
}
