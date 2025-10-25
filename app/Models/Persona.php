<?php

namespace App\Models;

/**
 * Modelo Persona
 *
 * Representa a las personas registradas en el sistema. 
 * Este modelo maneja operaciones CRUD básicas y extiende de BaseModel,
 * heredando su soporte para soft deletes y timestamps.
 *
 * @package App\Models
 */
class Persona extends BaseModel
{
    /** @var string Nombre de la tabla asociada en la base de datos */
    protected $table = 'personas';

    /** @var string Clave primaria de la tabla */
    protected $primaryKey = 'id';

    /** @var array Campos permitidos para inserción y actualización */
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
    ];

    /**
     * Obtiene una persona por su ID.
     *
     * @param int $id ID de la persona.
     * @return array|null Retorna los datos de la persona o null si no existe.
     */
    public function obtenerPorId($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Crea un nuevo registro de persona.
     *
     * @param array $data Datos de la persona (nombres, apellidos, dni, teléfono, etc.).
     * @return int ID del nuevo registro insertado.
     */
    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    /**
     * Actualiza los datos de una persona existente.
     *
     * @param int $id ID de la persona a actualizar.
     * @param array $data Datos actualizados.
     * @return bool true si la actualización fue exitosa, false en caso contrario.
     */
    public function actualizar(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Elimina (lógicamente) una persona del sistema.
     *
     * @param int $id ID de la persona a eliminar.
     * @return bool true si la eliminación fue exitosa, false si falló.
     */
    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }
}