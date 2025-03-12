<?php
if (!isset($entidad)) {
    $entidad = strtolower($titulo);
}

$singular = substr($titulo, -2) == "es" ? substr($titulo, 0, -2) : substr($titulo, 0, -1);

?>
<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4"><?= $titulo ?></h1>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2 mx-4">
        <div class="col-3">
            <input type="text" id="buscador" class="form-input-dashboard" placeholder="Buscar por nombre...">
        </div>
        <div class="d-flex gap-3">
            <button class="mb-0 btn-crud" data-bs-toggle="modal" data-bs-target="#modal-<?= $entidad ?>-form"
                id="btn-agregar">Agregar
                <?= $singular ?></button>
            <a class="mb-0 btn-crud" style="background-color: rgb(194, 24, 7);"
                href="<?php echo base_url('dashboard/' . $entidad . '/eliminados'); ?>">Eliminados</a>
        </div>
    </div>
    <div class="position-relative" id="tableContainer">
        <div id="table-loading" class="loading-overlay d-none">
            <div class="spinner-border text-light" role="status"></div>
        </div>
        <table class="table-dashboard">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col" class="text-end px-3"><span>Acciones</span></th>
                </tr>
            </thead>
            <tbody style="height: 50px;">
            </tbody>
        </table>
        <div class="d-flex justify-content-between gap-2 mx-4 align-items-center py-2">
            <div class="d-flex gap-2 align-items-center">
                <span class="fw-semibold" style="font-size: 14px; min-width: fit-content;">Por Página</span>
                <select class="form-select-dashboard" id="porPagina">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div id="indicadoresPaginacion" class="d-flex gap-2">

            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEliminarLabel">Eliminar <?= $singular ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Estás seguro que quieres eliminar esta <?= substr($entidad, 0, -1) ?>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" onclick="deleteItem()" style="background-color: rgb(160, 13, 0); color: white;"
                    class="btn eliminar-producto" data-bs-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-<?= $entidad ?>-form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="modal-<?= $entidad ?>-form-label">Agregar
                    <?= $singular ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div style="flex-grow:1;">
                    <label style="font-size: 13px;" class="fw-semibold mb-2" for="nombre">Nombre</label>
                    <input class="form-input-dashboard" autocomplete="off" name="nombre" id="nombre" require type="text"
                        placeholder="Ingrese el nombre del <?= strtolower($singular) ?>">
                    <span style="font-size: .9rem; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                    </span>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn-crud m-0 mx-2"
                    style="color:gray; background-color: rgb(240, 240, 240);" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-crud m-0 d-flex align-items-center gap-2" id="btn-guardar"
                    onclick="onSubmit()"><span class="loader-btn d-none"></span>Guardar</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/crud/cruds.js'); ?>"></script>
<script>
    crearCrud('<?= $entidad ?>');
</script>