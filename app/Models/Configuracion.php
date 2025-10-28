<?php

namespace App\Models;

/**
 * Modelo Configuracion
 *
 * Representa las preferencias de autenticación y notificación por usuario.
 * Proporciona métodos CRUD simples basados en el ID del usuario.
 *
 * @package App\Models
 */
class Configuracion extends BaseModel
{
    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected $table = "configuraciones";

    /**
     * @var string Clave primaria de la tabla.
     */
    protected $primaryKey = "id";

    /**
     * @var array Campos permitidos para inserción o actualización.
     */
    protected $allowedFields = [
        'usuario_id',
        'auth_email',
        'notif_email',
    ];

    /**
     * Obtiene la configuración asociada a un usuario.
     *
     * @param int $usuarioId ID del usuario.
     * @return array|null Datos de configuración o null si no existe.
     */
    public function obtenerPorUsuarioId(int $usuarioId)
    {
        return $this->where('usuario_id', $usuarioId)->first();
    }

    /**
     * Actualiza la configuración de un usuario.
     *
     * @param int $usuarioId ID del usuario.
     * @param array $data Datos a actualizar.
     * @return bool True si la actualización fue exitosa, False en caso contrario.
     */
    public function actualizarPorUsuarioId(int $usuarioId, array $data): bool
    {
        return $this->where('usuario_id', $usuarioId)->set($data)->update();
    }

    /**
     * Crea una nueva configuración para un usuario.
     *
     * @param array $data Datos de configuración.
     * @return int ID de la nueva configuración creada.
     */
    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }
}