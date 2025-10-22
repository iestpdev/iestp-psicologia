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
            "recordsTotal"    => $model->countAll($excludeId),
            "recordsFiltered" => $model->countFiltered($busqueda, $excludeId),
            "data"            => $model->getDatatables($inicio, $cantidad, $busqueda, $excludeId)
        ];

        // Responder con el formato esperado por DataTables
        return $this->response->setJSON(array_merge($data, [
            "draw" => $peticion
        ]));
    }
}
