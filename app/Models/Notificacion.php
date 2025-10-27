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
        'receptor',
        'descripcion',
        'leido',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function marcarComoLeidoPorReceptorId(?int $receptorId = null): bool
    {
        $builder = $this->db->table($this->table)
            ->where('leido', 0);

        if ($receptorId) {
            $builder->where('receptor', $receptorId);
        }

        $builder->set('leido', 1)->update();

        return $this->db->affectedRows() > 0;
    }

    public function listarPorReceptorId(?int $receptorId = null): array
    {
        $builder = $this->db->table($this->table . ' n')
            ->select('
                n.id,
                n.tipoNotificacion,
                n.entidad,
                n.emisor,
                n.receptor,
                n.descripcion,
                n.leido,
                n.created_at
            ')
            ->where('n.deleted_at', null)
            ->orderBy('n.created_at', 'DESC');

        if ($receptorId) {
            $builder->where('n.receptor', $receptorId);
        }

        return $builder->get()->getResultArray();
    }
}