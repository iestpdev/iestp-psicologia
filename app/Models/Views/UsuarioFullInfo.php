<?php

namespace App\Models\Views;

use App\Models\BaseModel;

class UsuarioFullInfo extends BaseModel
{
    protected $table      = 'view_usuario_full_info';
    protected $primaryKey = 'id';

    protected array $visibleFields = [
        'id',
        'correo_institucional',
        'username',
        'rol',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',

        'persona_id',
        'persona_nombres_completos',
        'dni',
        'telefono',
    ];

    protected array $searchableFields = [
        'persona_nombres_completos',
        'dni',
    ];
}
