<?php

namespace App\Controllers;

use App\Models\Notificacion;

class NotificacionController extends BaseController
{
    public function listarPorReceptorId($receptorId = null)
    {
        $notificacionModel = new Notificacion();
        return $this->response->setJSON($notificacionModel->listarPorReceptorId((int) $receptorId));
    }

    public function marcarComoLeidoPorReceptorId($receptorId = null)
    {
        $notificacionModel = new Notificacion();
        $resultado = $notificacionModel->marcarComoLeidoPorReceptorId($receptorId ? (int) $receptorId : null);

        return $this->response->setJSON([
            'success' => $resultado,
            'message' => $resultado
                ? 'Notificaciones marcadas como leídas correctamente.'
                : 'No se encontraron notificaciones para actualizar.'
        ]);
    }
}