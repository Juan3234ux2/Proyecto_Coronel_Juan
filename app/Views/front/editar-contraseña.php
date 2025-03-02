<section style="margin-top: 12rem;margin-bottom: 5rem">
    <div class="d-flex gap-5 justify-content-center flex-column flex-md-row">
        <div class="panel-cuenta text-medium col-3 d-md-flex d-none">
            <a class="px-4 pt-4" href="<?php echo base_url('cuenta'); ?>">Mis pedidos</a>
            <div class="dropdown px-4">
                <button class="nav-link dropdown-toggle text-black" style="border: none; background-color:transparent;"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mis datos
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item py-0 link-cuenta"
                            href="<?php echo base_url('cuenta/modificar-datos') ?>"> Editar datos</a></li>
                    <li><a class="dropdown-item py-0 link-cuenta"
                            href="<?php echo base_url('cuenta/modificar-contraseia') ?>">Editar Contraseña</a></li>
                </ul>
            </div>
            <?php if ($usuario['esAdmin']) { ?>
                <a class="px-4" href="<?php echo base_url('dashboard'); ?>">Ir al dashboard</a>
            <?php } ?>
            <a class="px-4" href="<?php echo base_url('cerrar-sesion'); ?>">Cerrar sesión</a>
        </div>
        <form class="col-12 col-md-8" method="post" action="<?php echo base_url('cuenta/enviar-clave'); ?>">
            <h2 class="fw-bold text-center">Modificar mi contraseña</h2>
            <div class="form__container d-flex justify-content-center align-items-center my-4 flex-column">
                <div class="form__group" style="width: 350px;">
                    <?php if (!empty(session()->getFlashdata('fail'))) { ?>
                        <span class="mb-2 mensaje-error mensaje-flash">
                            <?= session()->getFlashdata('fail'); ?>
                        </span>
                        <?php
                    } ?>
                    <div class="position-relative">
                        <input class="mx-0 w-100 form-input" name="contraseña" id="password" type="password"
                            placeholder=" ">
                        <label class="form-label" for="password">Contraseña Actual</label>
                        <i class="bi bi-eye position-absolute watch-password"
                            style="top:10px; right:15px; cursor:pointer; font-size:20px"></i>
                        <span style="font-size: 14px; display:inline-block;">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'contraseña') : ' ' ?>
                        </span>
                    </div>
                    <div class="position-relative">
                        <input class="mx-0 w-100 form-input" name="nuevaContraseña" id="new-password" type="password"
                            placeholder="">
                        <label class="form-label" for="new-password">Nueva Contraseña</label>
                        <i class="bi bi-eye position-absolute watch-password"
                            style="top:10px; right:15px; cursor:pointer; font-size:20px"></i>
                        <span style="font-size: 14px; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'confContraseña') : ' ' ?>
                        </span>
                    </div>
                    <button class="btn-enviar-datos w-100 mb-3 ">Editar Contraseña</button>
                </div>
        </form>
    </div>
</section>