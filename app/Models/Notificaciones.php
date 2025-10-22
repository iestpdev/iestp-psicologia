<?php

use App\Models\BaseModel;

class Notificaciones extends BaseModel
{
    protected $table = "configuraciones";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'usuario_id',
        'auth_SMS',
        'auth_email',
        'notif_email',
    ];

    public function obtenerPorUsuarioId($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }

    public function actualizarPorUsuarioId($usuarioId, $data)
    {
        return $this->where('usuario_id', $usuarioId)->set($data)->update();
    }

    public function crear(array $data)
    {
        return $this->insert($data);
    }

    public function eliminarPorUsuarioId($usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->delete();
    }
}