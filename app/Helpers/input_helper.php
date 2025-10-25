<?php

if (!function_exists('normalize_input')) {
    /**
     * Normaliza un arreglo de datos: elimina espacios y convierte
     * cadenas vacías en null. Útil antes de guardar en la BD.
     *
     * @param array $data Datos de entrada (por ejemplo, $_POST).
     * @return array Datos normalizados.
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
