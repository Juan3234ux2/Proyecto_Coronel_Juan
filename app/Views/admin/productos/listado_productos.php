<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Productos</h1>
    <?php if (!empty(session()->getFlashdata('success'))) { ?>
        <span class="mb-2 text-center mensaje-flash"
            style="background-color: rgba(0, 255, 0, 0.2); display:block; padding:12px; color:green; font-weight:500; border-radius:2px">
            <?= session()->getFlashdata('success'); ?>
        </span>
        <?php
    } ?>
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2 mx-4">
        <div class="col-xl-4 col-5">
            <input type="text" class="form-input-dashboard" placeholder="Buscar por nombre, categoria, marca..."
                id="buscador">
        </div>
        <div class="d-flex align-items-center gap-3">
            <a class="m-0 btn-crud" href=" <?php echo base_url('dashboard/productos/agregar'); ?>">Agregar Producto</a>
            <a class="m-0 btn-crud" style="background-color: rgb(194, 24, 7);"
                href=" <?php echo base_url('dashboard/productos/eliminados'); ?>">Eliminados</a>
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
                    <th scope="col">Categoría</th>
                    <th scope="col">Marca</th>
                    <th scope="col" class="text-end px-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
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
                    class="btn" onclick="deleteProduct()" data-bs-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/js/crud/productos.js'); ?>"></script>