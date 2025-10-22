<?php

namespace App\Controllers;

class DataTableController extends BaseController
{
    public function getData($modelName)
    {
        $request = service('request');

        // Parámetros principales de DataTables
        $inicio     = (int) $request->getGet('start');             // desde qué registro
        $cantidad   = (int) $request->getGet('length');            // cuántos registros mostrar
        $busqueda   = $request->getGet('search')['value'] ?? '';   // texto buscado
        $peticion   = $request->getGet('draw');                    // número de petición (DataTables)
        $excludeId  = $request->getGet('exclude_id');              // id de usuario logeado
        $whereField = $request->getGet('where_field');             // campo de filtro adicional (ejm: traer todos los registros donde usuario_id = 7)
        $whereValue = $request->getGet('where_value');             // valor del campo (ejm: 7)

        // Construir el namespace completo del modelo (ej: App\Models\Views\UsuarioFullInfo)
        $modelClass = "App\\Models\\Views\\" . $modelName;

        if (!class_exists($modelClass)) {
            return $this->response->setJSON([
                "error" => "Modelo {$modelName} no encontrado"
            ]);
        }

        $model = new $modelClass();

        // Validar que el modelo tenga los métodos necesarios
        if (
            !method_exists($model, 'getDatatables') ||
            !method_exists($model, 'countFiltered')
        ) {
            return $this->response->setJSON([
                "error" => "El modelo {$modelName} no implementa los métodos requeridos"
            ]);
        }

        // Obtener los datos directamente (sin cache)
        $data = [
            "recordsTotal"    => $model->countAll($excludeId, $whereField, $whereValue),
            "recordsFiltered" => $model->countFiltered($busqueda, $excludeId, $whereField, $whereValue),
            "data"            => $model->getDatatables($inicio, $cantidad, $busqueda, $excludeId, $whereField, $whereValue)
        ];

        // Responder con el formato esperado por DataTables
        return $this->response->setJSON(array_merge($data, [
            "draw" => $peticion
        ]));
    }
}
