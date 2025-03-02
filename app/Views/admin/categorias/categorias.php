<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Categorías</h1>
    <div class="d-flex justify-content-end align-items-center gap-3 mt-3 mb-2 mx-4">
        <a class="mb-2 btn-crud" href="<?php echo base_url('dashboard/categorias/agregar'); ?>">Agregar Categoría</a>
        <a class="mb-2 btn-crud" style="background-color: rgb(194, 24, 7);"
            href="<?php echo base_url('dashboard/categorias/eliminados'); ?>">Eliminados</a>
    </div>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end px-3"><span>Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria) { ?>
                <tr id="<?php echo $categoria['id']; ?>">
                    <td><?php echo $categoria['nombre']; ?> </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center justify-content-end">
                            <a class="rounded-btn"
                                href="<?php echo base_url('dashboard/categorias/editar/') . $categoria['id']; ?>"><i
                                    class="bi bi-pencil"></i></a>
                            <button type="button" class="rounded-btn open-delete-modal" data-id="<?= $categoria['id']; ?>">
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
                <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar Categoría</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Estás seguro que quieres eliminar esta categoría?
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
        var currentCategoryId;
        $('.open-delete-modal').on('click', function () {
            currentCategoryId = $(this).data('id');
            $('#btn-eliminar').data('id', currentCategoryId);
            $('#modalEliminar').modal('show');
        });
        $('#btn-eliminar').on('click', function () {
            var boton = $(this);
            var idCategoria = boton.data('id');
            $.ajax({
                url: '<?php echo base_url('dashboard/categorias/eliminar/'); ?>',
                type: 'POST',
                data: {
                    id: idCategoria,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#' + idCategoria).remove();
                        $('#modalEliminar').modal('hide')
                    }
                }
            });
        });
    });
</script>