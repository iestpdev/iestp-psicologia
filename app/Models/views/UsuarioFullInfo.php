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

        'docente_nombres',
        'docente_apellidos',
        'docente_dni',
        'docente_telefono',

        'psicologo_nombres',
        'psicologo_apellidos',
        'psicologo_dni',
        'psicologo_telefono',

        'administrador_nombres',
        'administrador_apellidos',
        'administrador_dni',
        'administrador_telefono',
    ];

    protected array $searchableFields = [
        'docente_nombres',
        'docente_apellidos',
        'docente_dni',

        'psicologo_nombres',
        'psicologo_apellidos',
        'psicologo_dni',

        'administrador_nombres',
        'administrador_apellidos',
        'administrador_dni',
    ];
}
