<?php

namespace App\Controllers;

use App\Models\Usuario;

class UsuarioController extends BaseController
{
    public function index(): string
    {
        return view('modules/usuarios/index');
    }

    public function getUsuarios()
    {
        $request = service('request');

        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $search = $request->getGet('search')['value'];
        $orderColumn = $request->getGet('order')[0]['column'];
        $orderDir    = $request->getGet('order')[0]['dir'];
        $draw        = $request->getGet('draw');

        $usuarioModel = new \App\Models\Usuario();

        $data = $usuarioModel->getDatatables($start, $length, $search, $orderColumn, $orderDir);

        $totalRecords = $usuarioModel->countAll();
        $filteredRecords = $usuarioModel->countFiltered($search);

        return $this->response->setJSON([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ]);
    }
}
