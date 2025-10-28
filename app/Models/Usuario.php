<?php

namespace App\Models;

/**
 * Modelo Usuario
 *
 * Representa la entidad de usuarios del sistema. 
 * Proporciona métodos para manejar operaciones CRUD y consultas personalizadas.
 *
 * @package App\Models
 */
class Usuario extends BaseModel
{
    /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected $table = 'usuarios';

    /**
     * @var string Clave primaria de la tabla.
     */
    protected $primaryKey = 'id';

    /**
     * @var array Campos permitidos para inserción o actualización.
     */
    protected $allowedFields = [
        'correo_institucional',
        'username',
        'userpass',
        'persona_id',
        'rol',
        'estado',
        'codigo_2fa',
        'codigo_2fa_expira',
    ];

    /**
     * Obtiene un usuario por su nombre de usuario.
     *
     * @param string $username Nombre de usuario.
     * @return array|null Datos del usuario o null si no existe.
     */
    public function obtenerPorUsername($username)
    {
        $builder = $this->db->table($this->table . ' u')
            ->select("
                p.id AS persona_id,
                p.nombres,
                p.apellidos,
                p.dni,
                p.telefono,
                u.id,
                u.correo_institucional,
                u.username,
                u.userpass,
                u.rol,
                u.estado,
                u.created_at,
                u.updated_at,
                u.deleted_at
            ")
            ->join('personas p', 'u.persona_id = p.id', 'left')
            ->where('u.deleted_at', null)
            ->where('u.username', $username);

        return $builder->get()->getRowArray();
    }

    /**
     * Obtiene un usuario por su ID.
     *
     * @param int $id ID del usuario.
     * @return array|null Datos del usuario o null si no existe.
     */
    public function obtenerPorId(int $id)
    {
        $builder = $this->db->table($this->table . ' u')
            ->select("
                p.id AS persona_id,
                p.nombres,
                p.apellidos,
                p.dni,
                p.telefono,
                u.id,
                u.correo_institucional,
                u.username,
                u.rol,
                u.estado,
                u.codigo_2fa,
                u.codigo_2fa_expira,
                u.created_at,
                u.updated_at,
                u.deleted_at
            ")
            ->join('personas p', 'u.persona_id = p.id', 'left')
            ->where('u.deleted_at', null)
            ->where('u.id', $id);

        return $builder->get()->getRowArray();
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     * 
     * Antes de insertar, se cifra la contraseña usando bcrypt.
     *
     * @param array $data Datos del usuario.
     * @return int ID del nuevo usuario creado.
     */
    public function crear(array $data): int
    {
        $data['userpass'] = password_hash($data['userpass'], PASSWORD_BCRYPT);
        return $this->insert($data, true);
    }

    /**
     * Actualiza los datos de un usuario existente.
     * 
     * Si se incluye una nueva contraseña, se vuelve a cifrar.
     *
     * @param int $id ID del usuario.
     * @param array $data Datos a actualizar.
     * @return bool True si la actualización fue exitosa, False en caso contrario.
     */
    public function actualizar(int $id, array $data): bool
    {
        if (!empty($data['userpass'])) {
            $data['userpass'] = password_hash($data['userpass'], PASSWORD_BCRYPT);
        } else {
            unset($data['userpass']);
        }

        return $this->update($id, $data);
    }

    /**
     * Elimina (lógicamente) un usuario de la base de datos.
     *
     * @param int $id ID del usuario.
     * @return bool True si la eliminación fue exitosa, False en caso contrario.
     */
    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Obtiene una lista de usuarios con rol DOCENTE.
     *
     * @param string|null $dni (Opcional) DNI del docente para filtrar resultados.
     * @return array Lista de docentes encontrados.
     */
    public function obtenerDocentes(?string $dni = null): array
    {
        $builder = $this->db->table($this->table . ' u')
            ->select("
                p.id AS persona_id,
                CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombres_completos,
                p.dni,
                u.id,
                u.rol,
                u.created_at,
                u.updated_at,
                u.deleted_at
            ")
            ->join('personas p', 'u.persona_id = p.id', 'left')
            ->where('u.rol', 'DOCENTE')
            ->where('u.deleted_at', null);

        if (!empty($dni)) {
            $builder->where('p.dni', $dni);
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Obtiene una lista de usuarios con rol PSICÓLOGO.
     *
     * @return array Lista de psicólogos encontrados.
     */
    public function obtenerPsicologos(): array
    {
        $builder = $this->db->table($this->table . ' u')
            ->select("
                p.id AS persona_id,
                CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombres_completos,
                p.dni,
                u.id,
                u.rol,
                u.created_at,
                u.updated_at,
                u.deleted_at
            ")
            ->join('personas p', 'u.persona_id = p.id', 'left')
            ->where('u.rol', 'PSICOLOGO')
            ->where('u.deleted_at', null);

        return $builder->get()->getResultArray();
    }
}