<?php

namespace App\Rules;

use Config\Database;

class CustomRules
{
    /**
     * Verifica si un valor es único en una tabla considerando únicamente los registros activos
     * (aquellos donde "deleted_at" es NULL). 
     * 
     * Adicionalmente, permite excluir un registro específico durante la validación, lo cual es
     * útil para los formularios de edición, evitando que el propio registro sea considerado como duplicado.
     *
     * --- Ejemplo de uso ---
     * is_unique_soft[usuarios.correo]
     *     → Verifica que el correo no exista entre los usuarios activos.
     * 
     * is_unique_soft[usuarios.username,id,{id}]
     *     → Verifica que el username sea único excluyendo el usuario con ese "id".
     *       En este caso, "{id}" se reemplaza automáticamente con el valor del campo "id"
     *       proveniente del formulario o validación.
     * 
     * --- Estructura esperada ---
     *  tabla.columna[,primaryKey,valorPrimaryKey]
     *  Ejemplo: usuarios.correo,id,{id}
     * 
     * --- Notas ---
     * - Compatible con eliminaciones lógicas mediante "deleted_at".
     * - El placeholder "{id}" requiere que el campo "id" esté definido en las reglas del validador 
     *   (por ejemplo: 'id' => 'permit_empty'), o que se pase manualmente al validador.
     * - Es requerido que el id sea enviado desde el formulario, se recomienda usar un input de tipo hidden
     * 
     * @param string $str   Valor a validar.
     * @param string $field Cadena con formato "tabla.columna" o 
     *                      "tabla.columna,primaryKey,valorPrimaryKey" para exclusión.
     * @param array  $data  Datos disponibles durante la validación (habitualmente $_POST).
     *
     * @return bool TRUE si el valor es único (no existe duplicado activo), FALSE en caso contrario.
     */
    public function is_unique_soft(string $str, string $field, array $data): bool
    {
        $params = explode(',', $field);
        [$table, $column] = explode('.', array_shift($params));

        $ignoreField = $params[0] ?? null;
        $ignoreValue = $params[1] ?? null;

        if ($ignoreValue && preg_match('/{(\w+)}/', $ignoreValue, $matches)) {
            $key = $matches[1];
            $ignoreValue = $data[$key] ?? null;
        }

        $db = Database::connect();
        $builder = $db->table($table);
        $builder->where($column, $str);
        $builder->where('deleted_at', null);

        if ($ignoreField && $ignoreValue) {
            $builder->where("$ignoreField !=", $ignoreValue);
        }

        return $builder->countAllResults() === 0;
    }
}
