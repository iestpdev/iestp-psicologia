<?php

namespace App\Controllers;

class DataTableController extends BaseController
{
    public function getData($modelName)
    {
        $request = service('request');

        $inicio = (int) $request->getGet('start');            // desde qué registro
        $cantidad = (int) $request->getGet('length');           // cuántos registros mostrar
        $busqueda = $request->getGet('search')['value'] ?? '';  // texto buscado
        $peticion = $request->getGet('draw');                   // número de petición (DataTables)

        // construyendo el namespace completo del modelo
        $modelClass = "App\\Models\\Views\\" . $modelName;

        if (!class_exists($modelClass)) {
            return $this->response->setJSON([
                "error" => "Modelo {$modelName} no encontrado"
            ]);
        }

        $model = new $modelClass();

        if (
            !method_exists($model, 'getDatatables') ||
            !method_exists($model, 'countFiltered')
        ) {
            return $this->response->setJSON([
                "error" => "El modelo {$modelName} no implementa los métodos requeridos"
            ]);
        }

        $cacheKey = "datatable_{$modelName}_{$inicio}_{$cantidad}_" . md5($busqueda);
        $cached = cache($cacheKey);

        if ($cached === null) {
            $cached = [
                "recordsTotal" => $model->countAll(),
                "recordsFiltered" => $model->countFiltered($busqueda),
                "data" => $model->getDatatables($inicio, $cantidad, $busqueda)
            ];
            cache()->save($cacheKey, $cached, 3600);
        }

        return $this->response->setJSON(array_merge($cached, [
            "draw" => $peticion
        ]));
    }
}
