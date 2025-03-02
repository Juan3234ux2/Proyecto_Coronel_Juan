<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidosModel extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_usuario', 'precio_total', 'estado', 'fecha_compra', 'medio_pago'];

    protected bool $allowEmptyInserts = false;

    public function obtenerPedidos()
    {
        return $this->select('pedidos.*, usuarios.nombre AS nombre_usuario')
            ->join('usuarios', 'usuarios.id = pedidos.id_usuario')
            ->findAll();
    }
    public function obtenerPedidosPorUsuario($idUsuario)
    {
        return $this
            ->where('id_usuario', $idUsuario)
            ->orderBy('fecha_compra', 'DESC')
            ->findAll();
    }
    public function obtenerEstadisticasVentas()
    {
        return $this->select('DATE(fecha_compra) as fecha_compra, SUM(precio_total) as total_recaudado')
            ->where('fecha_compra >=', date('Y-m-d', strtotime('-1 month')))
            ->groupBy('DATE(fecha_compra)')
            ->orderBy('fecha_compra')
            ->findAll();
    }
    public function obtenerPedidosUltimaSemana()
    {
        return $this->select('pedidos.*')
            ->where('fecha_compra >=', date('Y-m-d', strtotime('-1 month')))
            ->findAll();
    }
}
