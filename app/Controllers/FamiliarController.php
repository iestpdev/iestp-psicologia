<?php

namespace App\Controllers;

use App\Models\Familiar;
use App\Models\Pariente;

class FamiliarController extends BaseController
{
    public function listarPorAlumnoId($alumnoId)
    {
        $familiarModel = new Familiar();
        return $this->response->setJSON($familiarModel->listarPorAlumnoId((int) $alumnoId));
    }

    public function saveFamiliar($alumnoId)
    {
        helper(['validation', 'input']);
        $errors = runValidation('pariente_create', $this->request);

        if (!empty($errors)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'errors' => $errors
            ]);
        }

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $parienteData = normalize_input([
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni' => $this->request->getPost('dni'),
                'telefono' => $this->request->getPost('telefono'),
                'parentesco_id' => $this->request->getPost('parentesco'),
            ]);
            $parienteModel = new Pariente();
            $parienteId = $parienteModel->crear($parienteData);
            if (!$parienteId)
                throw new \Exception("Error al crear Pariente");

            $familiarData = normalize_input([
                'alumno_id' => $alumnoId,
                'pariente_id' => $parienteId,
            ]);
            $familiarModel = new Familiar();
            $familiarId = $familiarModel->crear($familiarData);
            if (!$familiarId)
                throw new \Exception("Error al crear Familiar");

            $db->transCommit();

            // obtenemos el nuevo registro para devolverlo
            $nuevo = $familiarModel->listarPorAlumnoId($alumnoId);
            $nuevo = end($nuevo);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Familiar registrado correctamente',
                'data' => $nuevo
            ]);

        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
