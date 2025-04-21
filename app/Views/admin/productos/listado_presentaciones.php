<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Presentaciones
        <?php echo $producto['nombre'] . ' ' . $producto['nombre_marca']; ?>
    </h1>
    <div class="mt-4 mb-2 mx-4">
        <a class="m-0 btn-crud" href=" <?php echo base_url('dashboard/productos/'); ?>">Regresar</a>
    </div>
    <div class="position-relative" id="tableContainer">
        <div id="table-loading" class="loading-overlay d-none">
            <div class="spinner-border text-light" role="status"></div>
        </div>
        <table class="table-dashboard">
            <thead>
                <tr>
                    <th scope="col">Sabor</th>
                    <th scope="col">Tamaño</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Precio Compra</th>
                    <th scope="col">Precio Venta</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($presentaciones as $presentacion) {
                    ?>
                    <tr id="<?= $presentacion['id']; ?>">
                        <td><?php echo $presentacion['nombre_sabor']; ?> </td>
                        <td><?php echo $presentacion['contenido'] . ' ' . $presentacion['nombre_unidad']; ?> </td>
                        <td><?php echo $presentacion['stock']; ?> </td>
                        <td>$ <?php echo number_format($presentacion['precio_compra'], 2, ',', '.'); ?> </td>
                        <td>$ <?php echo number_format($presentacion['precio_venta'], 2, ',', '.'); ?> </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</section>