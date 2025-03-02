<?php

namespace App\Models;

use CodeIgniter\Model;

class MarcasModel extends Model
{
    protected $table = 'marcas';
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
    public function obtenerMarcasActivas()
    {
        return $this->where('activo', 1)->findAll();
    }
    public function obtenerMarcasPorId($id)
    {
        return $this->find($id);
    }
    public function actualizarMarca($id, $data)
    {
        return $this->update($id, $data);
    }
    public function obtenerMarcasInactivas()
    {
        return $this->where('activo', 0)->findAll();
    }
}
