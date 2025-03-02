<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nombre', 'email', 'contraseña', 'esAdmin', 'carrito', 'fecha_alta', 'fecha_edit'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha_alta';
    protected $updatedField = 'fecha_edit';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    public function obtenerUsuariosActivos()
    {
        return $this->where('activo', 1)->findAll();
    }
    public function obtenerUsuarioPorId($id)
    {
        return $this->find($id);
    }
    public function actualizarCarrito($idUsuario, $carrito)
    {
        $this->update($idUsuario, ['carrito' => json_encode($carrito)]);
    }

    public function obtenerCarrito($idUsuario)
    {
        $usuarioInfo = $this->obtenerUsuarioPorId($idUsuario);

        return $usuarioInfo['carrito'] ? json_decode($usuarioInfo['carrito'], true) : [];
    }
}
