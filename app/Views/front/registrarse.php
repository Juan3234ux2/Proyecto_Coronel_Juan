<section class="text-center container-lg mb-5 mb-sm-2" style="margin-top:130px">
    <form method="post" action="<?php echo base_url('registrarse'); ?>">
        <h2 class="fw-bolder fs-1 pt-4 my-4 my-lg-5">Crear una cuenta</h2>
        <div class="form__container d-flex justify-content-center align-items-center my-4">
            <div class="form__group col-10 col-sm-8 col-md-7 col-lg-5 col-xl-5">
                <div class="d-flex gap-0 gap-sm-2 flex-column flex-md-row">
                    <div class="position-relative" style="flex-grow:1;">
                        <input class="mx-0 position w-100 form-input" name="nombre" value="<?= set_value('nombre'); ?>" required id="name" type="text" placeholder=" ">
                        <label class="form-label" for="name">Tu nombre</label>
                        <span style="font-size: 14px; display:inline-block;height:15px">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'nombre') : ' ' ?>
                        </span>
                    </div>
                    <div class="position-relative" style="flex-grow:1;">
                        <input class="mx-0 w-100 form-input" name="apellido" value="<?= set_value('apellido'); ?>" id="surname" required type="text" placeholder=" ">
                        <label class="form-label" for="surname">Tu Apellido</label>
                        <span style="font-size: 14px; display:inline-block">
                            <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'apellido') : ' ' ?>
                        </span>
                    </div>
                </div>
                <div class=" position-relative">
                    <input class="mx-0 w-100 form-input" name="email" id="email" value="<?= set_value('email'); ?>" required type="email" placeholder=" ">
                    <label class="form-label" for="email">Tu email</label>
                    <span style="font-size: 14px; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'email') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative">
                    <input class="mx-0 w-100 form-input" name="contraseña" required id="password" value="<?= set_value('contraseña'); ?>" type="password" placeholder=" ">
                    <label class="form-label" for="password">Tu Contraseña</label>
                    <i class="bi bi-eye position-absolute watch-password" style="top:10px; right:15px; cursor:pointer; font-size:20px"></i>
                    <span style="font-size: 14px; display:inline-block;">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'contraseña') : ' ' ?>
                    </span>
                </div>
                <div class=" position-relative">
                    <input class="mx-0 w-100 form-input" name="confContraseña" value="<?= set_value('confContraseña'); ?>" required id="confirm-password" type="password" placeholder="">
                    <label class="form-label" for="confirm-password">Confirme su contraseña</label>
                    <i class="bi bi-eye position-absolute watch-password" style="top:10px; right:15px; cursor:pointer; font-size:20px"></i>
                    <span style="font-size: 14px; display:inline-block">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'confContraseña') : ' ' ?>
                    </span>
                </div>
                <button class=" btn-enviar-datos w-100 mb-3 mt-2 text-uppercase">Crear Cuenta</button>
                <a class="login-text mb-3" href="<?php echo base_url('iniciar-sesion'); ?>" >¿Ya tienes tienes una cuenta?</a>
            </div>
        </div>
    </form>
</section>