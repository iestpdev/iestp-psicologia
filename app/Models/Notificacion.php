<?php

namespace App\Models;

class Notificacion extends BaseModel
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipoNotificacion',
        'entidad',
        'emisor',
        'descripcion',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function listar(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }
}