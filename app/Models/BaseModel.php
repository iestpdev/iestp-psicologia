<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;

    // Cada modelo hijo podrá definir sus columnas filtrables
    protected array $searchableFields = [];

    // Cada modelo hijo podrá definir sus columnas visibles (evitar exponer datos sensibles)
    protected array $visibleFields = [];

    /**
     * Devuelve registros paginados y filtrados
     */
    public function getDatatables(int $inicio, int $cantidad, string $busqueda = '', $excludeId = null, $whereField = null, $whereValue = null): array
    {
        $builder = $this->db->table($this->table);

        $builder->select($this->getVisibleFields());

        if ($this->useSoftDeletes && !empty($this->deletedField)) {
            $builder->where("{$this->table}.{$this->deletedField}", null);
        }

        // excluimos un registro en especifico (ejm: excluimos el usuario logeado de una lista de usuarios)
        if (!empty($excludeId)) {
            $builder->where("{$this->table}.id !=", $excludeId);
        }

        // Filtro adicional dinámico (ej: usuario_id = 7)
        if (!empty($whereField) && !empty($whereValue)) {
            $builder->where($whereField, $whereValue);
        }

        // Filtro de búsqueda global
        if (!empty($busqueda) && !empty($this->searchableFields)) {
            $builder->groupStart();
            foreach ($this->searchableFields as $field) {
                $builder->orLike($field, $busqueda);
            }
            $builder->groupEnd();
        }

        // Orden por fecha de creación (más recientes primero)
        $builder->orderBy($this->createdField, 'DESC');

        // Paginación
        $builder->limit($cantidad, $inicio);

        return $builder->get()->getResultArray();
    }

    /**
     * Cuenta todos los registros (con soft deletes aplicados)
     */
    public function countAll($excludeId = null, $whereField = null, $whereValue = null): int
    {
        $builder = $this->db->table($this->table)
            ->where("{$this->deletedField}", null);

        if (!empty($excludeId)) {
            $builder->where("{$this->table}.id !=", $excludeId);
        }

        if (!empty($whereField) && !empty($whereValue)) {
            $builder->where($whereField, $whereValue);
        }

        return $builder->countAllResults();
    }

    /**
     * Cuenta registros filtrados por búsqueda
     */
    public function countFiltered(string $busqueda = '', $excludeId = null, $whereField = null, $whereValue = null): int
    {
        $builder = $this->db->table($this->table)
            ->select('COUNT(*) as total')
            ->where("{$this->deletedField}", null);

        if (!empty($excludeId)) {
            $builder->where("{$this->table}.id !=", $excludeId);
        }

        if (!empty($whereField) && !empty($whereValue)) {
            $builder->where($whereField, $whereValue);
        }

        if (!empty($busqueda) && !empty($this->searchableFields)) {
            $builder->groupStart();
            foreach ($this->searchableFields as $field) {
                $builder->orLike($field, $busqueda);
            }
            $builder->groupEnd();
        }

        return (int) $builder->get()->getRow()->total;
    }

    /**
     * Retorna los campos visibles
     */
    protected function getVisibleFields(): string
    {
        // Si el hijo define visibleFields, usamos esos
        if (!empty($this->visibleFields)) {
            $fields = $this->visibleFields;
        }
        // Si no, caemos en allowedFields
        else if (!empty($this->allowedFields)) {
            $fields = $this->allowedFields;
        }

        // añadiendo timestamps si existen
        if ($this->useTimestamps) {
            $fields[] = $this->createdField;
            $fields[] = $this->updatedField;
        }
        if ($this->useSoftDeletes) {
            $fields[] = $this->deletedField;
        }

        return implode(',', array_unique($fields));
    }
}
