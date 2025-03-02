<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 mb-4 px-4">Unidades Eliminadas</h1>
    <a class="btn-crud mx-4" href="<?php echo base_url('dashboard/unidades') ?>"><i class="bi bi-arrow-left "></i>
        Regresar</a>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Nombre Corto</th>
                <th scope="col" class="text-end px-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($unidades as $unidad) { ?>
                <tr>
                    <td><?php echo $unidad['nombre']; ?> </td>
                    <td><?php echo $unidad['nombre_corto']; ?> </td>
                    <td>
                        <div class="d-flex justify-content-end px-3 align-items-center">
                            <a class="rounded-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Activar Unidad."
                                href="<?php echo base_url('dashboard/unidades/activar/') . $unidad['id']; ?>"><i
                                    class="bi bi-arrow-up fw-bold"></i></a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>