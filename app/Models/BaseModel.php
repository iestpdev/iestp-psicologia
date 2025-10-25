<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class BaseModel
 *
 * Modelo base que extiende la funcionalidad de CodeIgniter\Model,
 * agregando manejo de SoftDeletes, timestamps y métodos genéricos
 * para DataTables y filtrado dinámico.
 *
 * @package App\Models
 */
class BaseModel extends Model
{
    /**
     * @var bool Indica si se usarán los campos de timestamps automáticamente.
     */
    protected $useTimestamps = true;

    /**
     * @var string Nombre del campo de creación.
     */
    protected $createdField = 'created_at';

    /**
     * @var string Nombre del campo de actualización.
     */
    protected $updatedField = 'updated_at';

    /**
     * @var string Nombre del campo de eliminación lógica.
     */
    protected $deletedField = 'deleted_at';

    /**
     * @var bool Habilita el uso de Soft Deletes.
     */
    protected $useSoftDeletes = true;

    /**
     * @var array Campos disponibles para búsqueda global.
     */
    protected array $searchableFields = [];

    /**
     * @var array Campos visibles al obtener registros (oculta datos sensibles).
     */
    protected array $visibleFields = [];

    /**
     * Devuelve registros paginados y filtrados según los parámetros de búsqueda.
     *
     * @param int $inicio     Posición inicial del paginado.
     * @param int $cantidad   Cantidad de registros por página.
     * @param string $busqueda Texto de búsqueda opcional.
     * @param int|null $excludeId ID que se debe excluir (por ejemplo, el usuario logueado).
     * @param string|null $whereField Campo adicional para filtrar.
     * @param mixed|null $whereValue Valor del filtro adicional.
     *
     * @return array Lista de registros filtrados.
     *
     * @example
     * $model->getDatatables(0, 10, 'Juan', 1);
     */
    public function getDatatables(int $inicio, int $cantidad, string $busqueda = '', $excludeId = null, $whereField = null, $whereValue = null): array
    {
        $builder = $this->db->table($this->table);

        $builder->select($this->getVisibleFields());

        if ($this->useSoftDeletes && !empty($this->deletedField)) {
            $builder->where("{$this->table}.{$this->deletedField}", null);
        }

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

        $builder->orderBy($this->createdField, 'DESC');
        $builder->limit($cantidad, $inicio);

        return $builder->get()->getResultArray();
    }

    /**
     * Cuenta todos los registros del modelo, respetando Soft Deletes.
     *
     * @param int|null $excludeId ID que se debe excluir del conteo.
     * @param string|null $whereField Campo adicional para filtrar.
     * @param mixed|null $whereValue Valor del filtro adicional.
     *
     * @return int Cantidad total de registros.
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
     * Cuenta los registros filtrados según un texto de búsqueda.
     *
     * @param string $busqueda Texto de búsqueda opcional.
     * @param int|null $excludeId ID que se debe excluir del conteo.
     * @param string|null $whereField Campo adicional para filtrar.
     * @param mixed|null $whereValue Valor del filtro adicional.
     *
     * @return int Cantidad de registros filtrados.
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
     * Retorna los campos visibles que deben ser seleccionados en las consultas.
     *
     * Si el modelo hijo define `$visibleFields`, se priorizan sobre `$allowedFields`.
     *
     * @return string Campos separados por comas.
     */
    protected function getVisibleFields(): string
    {
        if (!empty($this->visibleFields)) {
            $fields = $this->visibleFields;
        } elseif (!empty($this->allowedFields)) {
            $fields = $this->allowedFields;
        }

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