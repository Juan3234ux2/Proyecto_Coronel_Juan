<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Productos</h1>
    <?php if (!empty(session()->getFlashdata('success'))) { ?>
        <span class="mb-2 text-center mensaje-flash"
            style="background-color: rgba(0, 255, 0, 0.2); display:block; padding:12px; color:green; font-weight:500; border-radius:2px">
            <?= session()->getFlashdata('success'); ?>
        </span>
        <?php
    } ?>
    <div class="d-flex justify-content-end align-items-center gap-3 mt-3 mb-2 mx-4">
        <a class="mb-2 btn-crud" href=" <?php echo base_url('dashboard/productos/agregar'); ?>">Agregar Producto</a>
        <a class="mb-2 btn-crud" style="background-color: rgb(194, 24, 7);"
            href=" <?php echo base_url('dashboard/productos/eliminados'); ?>">Eliminados</a>
    </div>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Precio Venta</th>
                <th scope="col">Precio Compra</th>
                <th scope="col">Stock</th>
                <th scope="col">Categoría</th>
                <th scope="col">Marca</th>
                <th scope="col" class="text-end px-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto) { ?>
                <tr id="<?= $producto['id']; ?>">
                    <td><?php echo $producto['nombre']; ?> </td>
                    <td>$ <?php echo number_format($producto['precio_venta'], 2, ',', '.'); ?> </td>
                    <td>$ <?php echo number_format($producto['precio_compra'], 2, ',', '.'); ?> </td>
                    <td><?php echo $producto['stock']; ?> </td>
                    <td><?php echo $producto['nombre_categoria'] ?> </td>
                    <td><?php echo $producto['nombre_marca'] ?> </td>
                    <td>
                        <div class="d-flex align-items-center gap-2 justify-content-end">
                            <a class="rounded-btn"
                                href="<?php echo base_url('dashboard/productos/editar/') . $producto['id']; ?>">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <!-- Button trigger modal -->
                            <button type="button" class="rounded-btn open-delete-modal" data-id="<?= $producto['id']; ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>

<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Estás seguro que quieres eliminar este producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btn-eliminar" style="background-color: rgb(160, 13, 0); color: white;"
                    class="btn eliminar-producto" data-bs-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var currentProductId;

        $('.open-delete-modal').on('click', function () {
            currentProductId = $(this).data('id');
            $('#btn-eliminar').data('id', currentProductId);
            $('#modalEliminar').modal('show');
        });

        $('#btn-eliminar').on('click', function () {
            var idProducto = $(this).data('id');
            console.log(idProducto);
            $.ajax({
                url: '<?php echo base_url('dashboard/productos/eliminar/'); ?>',
                type: 'POST',
                data: {
                    id: idProducto,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#' + idProducto).remove();
                        $('#modalEliminar').modal('hide');
                    } else {
                        alert('Error al borrar el producto');
                    }
                }
            });
        });
    });
</script>