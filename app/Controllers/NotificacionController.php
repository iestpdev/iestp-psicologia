<?php

namespace App\Controllers;

use App\Models\Notificacion;
use App\Models\NotificacionUsuario;

class NotificacionController extends BaseController
{
    public function listar($receptorId = null)
    {
        $notificacionModel = new Notificacion();

        if($receptorId){
            $notifacionUsuarioModel = new NotificacionUsuario();
            $notificacionesUsuarioEspecifico = $notifacionUsuarioModel->listarPorUsuarioId($receptorId);

            return $this->response->setJSON($notificacionesUsuarioEspecifico);
        }

        return $this->response->setJSON($notificacionModel->listar());
    }

    public function marcarComoLeidoPorReceptorId($receptorId = null)
    {
        $notificacionModel = new Notificacion();
        if($receptorId){
             $notifacionUsuarioModel = new NotificacionUsuario();
             
        }
    }
}