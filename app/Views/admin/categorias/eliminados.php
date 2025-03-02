<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 mb-4 px-4">Categorías Eliminadas</h1>
    <a class="btn-crud mx-4" href="<?php echo base_url('dashboard/categorias') ?>"><i class="bi bi-arrow-left "></i>
        Regresar</a>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end px-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria) { ?>
                <tr>
                    <td><?php echo $categoria['nombre']; ?> </td>
                    <td>
                        <div class="d-flex justify-content-end px-3 align-items-center">
                            <a class="rounded-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Activar Categoria."
                                href="<?php echo base_url('dashboard/categorias/activar/') . $categoria['id']; ?>"><i
                                    class="bi bi-arrow-up fw-bold"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>