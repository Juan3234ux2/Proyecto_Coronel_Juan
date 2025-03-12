<?php

namespace App\Models;

use CodeIgniter\Model;

class SaboresModel extends Model
{
    protected $table = 'sabores';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'activo'];

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
    public function obtenerSaboresActivos()
    {
        return $this->where('activo', 1)->findAll();
    }
    public function obtenerSaboresPorId($id)
    {
        return $this->find($id);
    }
    public function actualizarSabor($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerSaboresInactivos()
    {
        return $this->where('activo', 0)->findAll();
    }
}
