<nav class="w-100 bg-white" style="height: 55px;">
    <div class="d-flex justify-content-end align-items-center h-100 mx-5 position-relative">
        <button id="btn-user-dashboard">
            <span style=" background-color: rgb(21, 31, 31);border-radius:3px; padding: 3px 11px; font-size: 14px; color:
            white;">
                <?php echo $usuario['nombre'][0]; ?>
            </span>
            <span class="fw-semibold" style="font-size: 13px;">
                <?php echo $usuario['nombre']; ?>
            </span>
        </button>
        <div class="d-none d-flex justify-content-end align-items-center" id="popover-user-container">
            <div class="popover-user">
                <span class="mt-4" style="background-color: rgb(21, 31, 31);border-radius:3px; padding: 3px 11px; font-size: 14px; color:
                    white;">
                    <?php echo $usuario['nombre'][0]; ?>
                </span>
                <span class="fw-semibold mt-1 mb-3" style="font-size: 12px;">
                    <?php echo $usuario['nombre']; ?>
                </span>
                <a href="<?php echo base_url('/') ?>" class="mb-2"><i class="bi bi-door-open"></i> Web Comercial</a>
                <a style="color: rgb(150, 1, 1); background-color: rgb(248, 180, 180);"
                    href="<?php echo base_url('/cerrar-sesion') ?>"><i class="bi bi-box-arrow-right"></i>Cerrar
                    Sesión</a>

            </div>
        </div>
    </div>
</nav>