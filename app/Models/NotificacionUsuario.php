<?php

namespace App\Models;

class NotificacionUsuario extends BaseModel
{
    protected $table = 'notificaciones_usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'notificacion_id',
        'usuario_id',
        'leido',
        'fecha_leido',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function listarPorUsuarioId(int $usuarioId)
    {
        return $this->where('usuario_id', $usuarioId);
    }

    public function obtenerPorUsuarioId(int $usuarioId){
        
    }
}