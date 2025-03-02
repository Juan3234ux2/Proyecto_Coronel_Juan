<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Marcas</h1>
    <div class="d-flex justify-content-end align-items-center gap-3 mt-3 mb-2 mx-4">
        <a class="mb-2 btn-crud" href="<?php echo base_url('dashboard/marcas/agregar'); ?>">Agregar Marca</a>
        <a class="mb-2 btn-crud" style="background-color: rgb(194, 24, 7);"
            href="<?php echo base_url('dashboard/marcas/eliminados'); ?>">Eliminados</a>
    </div>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end px-3"><span>Acciones</span></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marcas as $marca) { ?>
                <tr id="<?php echo $marca['id']; ?>">
                    <td><?php echo $marca['nombre']; ?> </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center justify-content-end">
                            <a class="rounded-btn"
                                href="<?php echo base_url('dashboard/marcas/editar/') . $marca['id']; ?>"><i
                                    class="bi bi-pencil"></i></a>
                            <button type="button" class="rounded-btn open-delete-modal" data-id="<?= $marca['id']; ?>">
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
                <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar Marca</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Estás seguro que quieres eliminar esta marca?
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
        var currentBrandId;
        $('.open-delete-modal').on('click', function () {
            currentBrandId = $(this).data('id');
            $('#btn-eliminar').data('id', currentBrandId);
            $('#modalEliminar').modal('show');
        });

        $('#btn-eliminar').on('click', function () {
            var boton = $(this);
            var idMarca = boton.data('id');
            $.ajax({
                url: '<?php echo base_url('dashboard/marcas/eliminar/'); ?>',
                type: 'POST',
                data: {
                    id: idMarca,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        $('#' + idMarca).remove();
                        $('#modalEliminar').modal('hide')
                    } else {
                        alert('Este producto tiene productos asociados');
                    }
                }
            });
        });
    });
</script>