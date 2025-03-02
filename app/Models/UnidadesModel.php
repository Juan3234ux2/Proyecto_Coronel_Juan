<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadesModel extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'nombre_corto', 'activo'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha_alta';
    protected $updatedField = 'fecha_edit';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function obtenerUnidadesActivas()
    {
        return $this->where('activo', 1)->findAll();
    }
    public function obtenerUnidadesPorId($id)
    {
        return $this->find($id);
    }
    public function actualizarUnidad($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerUnidadesInactivas()
    {
        return $this->where('activo', 0)->findAll();
    }
}
