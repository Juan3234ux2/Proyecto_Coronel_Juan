<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 mb-4 px-4">Productos Eliminados</h1>
    <a class="btn-crud mx-4" href="<?php echo base_url('dashboard/productos') ?>"><i class="bi bi-arrow-left "></i>
        Regresar</a>
    <table id="tablaDatos" class="table table-dashboard">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio Venta</th>
                <th scope="col">Precio Compra</th>
                <th scope="col">Stock</th>
                <th scope="col">Categoria</th>
                <th scope="col">Marca</th>
                <th scope="col" class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['id']; ?> </td>
                    <td><?php echo $producto['nombre']; ?> </td>
                    <td>$ <?php echo number_format($producto['precio_venta'], 2, ',', '.'); ?> </td>
                    <td>$ <?php echo number_format($producto['precio_compra'], 2, ',', '.'); ?> </td>
                    <td><?php echo $producto['stock']; ?> </td>
                    <td><?php echo $producto['nombre_categoria'] ?> </td>
                    <td><?php echo $producto['nombre_marca'] ?> </td>
                    <td>
                        <div class="d-flex justify-content-end px-3 align-items-center">
                            <a class="rounded-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Activar producto."
                                href="<?php echo base_url('dashboard/productos/activar/') . $producto['id']; ?>"><i
                                    class="bi bi-arrow-up fw-bold"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>