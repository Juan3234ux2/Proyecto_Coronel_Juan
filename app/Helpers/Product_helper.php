<?php
function devolverNombreProducto($producto)
{
    return $producto['nombre'] . ' ' . $producto['contenido'] . $producto['nombre_unidad'] . ' ' . $producto['nombre_marca'];
}
