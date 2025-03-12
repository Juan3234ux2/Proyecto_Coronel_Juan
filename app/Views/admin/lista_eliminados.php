<?php
$singular = substr($entidad, -2) == "es" ? substr($entidad, 0, -2) : substr($entidad, 0, -1);

?>
<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 mb-4 px-4"><?php echo $titulo ?></h1>
    <a class="btn-crud mx-4" href="<?php echo base_url('dashboard/' . $entidad) ?>"><i class="bi bi-arrow-left "></i>
        Regresar</a>
    <table class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col" class="text-end px-3">Acciones</th>
            </tr>
        </thead>
        <tbody> <?php if (empty($items)) { ?>
                <tr>
                    <td colspan="2">No hay <?php echo strtolower($titulo) ?>.</td>
                </tr>
            <?php } else {
            foreach ($items as $item) { ?>
                    <tr>
                        <td><?php echo $item['nombre']; ?> </td>
                        <td>
                            <div class="d-flex justify-content-end px-3 align-items-center">
                                <button class="rounded-btn" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="Activar <?php echo $singular ?>."
                                    onclick="restoreItem(<?php echo $item['id'] ?>)"><i
                                        class="bi bi-arrow-up fw-bold"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php }
        } ?>
        </tbody>
    </table>
</section>
<script src="<?php echo base_url('assets/js/crud/cruds.js'); ?>"></script>
<script>
    crearCrud('<?= $entidad ?>');
</script>