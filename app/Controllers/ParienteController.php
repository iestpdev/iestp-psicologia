<?php

namespace App\Controllers;

use App\Models\Pariente;

class ParienteController extends BaseController
{
    public function obtenerPorId($id)
    {
        $parienteModel = new Pariente();
        return $this->response->setJSON($parienteModel->obtenerPorId((int) $id));
    }

    public function updatePariente($parienteId)
    {
        helper(['validation', 'input']);

        $errors = runValidation('pariente_update', $this->request);
        if (!empty($errors)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'errors' => $errors
            ]);
        }

        $parienteModel = new Pariente();
        $data = normalize_input([
            'nombres' => $this->request->getPost('nombres'),
            'apellidos' => $this->request->getPost('apellidos'),
            'dni' => $this->request->getPost('dni'),
            'telefono' => $this->request->getPost('telefono'),
            'parentesco_id' => $this->request->getPost('parentesco'),
        ]);

        if (!$parienteModel->actualizar($parienteId, $data)) {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => 'No se pudo actualizar el familiar']);
        }

        return $this->response->setJSON([
            'message' => 'Familiar actualizado correctamente',
            'data' => $data
        ]);
    }
}