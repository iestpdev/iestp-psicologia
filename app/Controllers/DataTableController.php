<?php

namespace App\Controllers;

use App\Models\Views\UsuarioFullInfo;

class DataTableController extends BaseController
{
    public function getUsuarios()
    {
        $request = service('request');

        $inicio   = (int) $request->getGet('start');            // desde qué registro
        $cantidad = (int) $request->getGet('length');           // cuántos registros mostrar
        $busqueda = $request->getGet('search')['value'] ?? '';  // texto buscado
        $peticion = $request->getGet('draw');                   // número de petición (DataTables)

        $usuarioModel = new UsuarioFullInfo();

        $usuarios = $usuarioModel->getDatatables($inicio, $cantidad, $busqueda);

        $totalRegistros     = $usuarioModel->countAll();
        $registrosFiltrados = $usuarioModel->countFiltered($busqueda);

        return $this->response->setJSON([
            "draw" => intval($peticion),
            "recordsTotal" => $totalRegistros,
            "recordsFiltered" => $registrosFiltrados,
            "data" => $usuarios
        ]);
    }
}
