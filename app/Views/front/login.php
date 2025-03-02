<section class="text-center container-lg mb-5 mb-sm-2" style="margin-top:130px">
    <form method="post" action="<?php echo base_url('login-user'); ?>">
        <h2 class="fw-bolder fs-1 pt-4 my-4 my-lg-5">Iniciar Sesión</h2>
        <div class="form__container d-flex justify-content-center align-items-center mt-2 mb-4">
            <div id="login-form" class="form__group col-11 col-sm-7 col-md-6 col-lg-5 col-xl-4">
                <?php if (!empty(session()->getFlashdata('fail'))) { ?>
                    <span class="mb-2 mensaje-error mensaje-flash">
                        <?= session()->getFlashdata('fail'); ?>
                    </span>
                    <?php
                } ?>
                <div class="position-relative">
                    <input class="mx-0 w-100 form-input" id="email-login" name="email" required
                        value="<?= set_value('email'); ?>" type="email" placeholder=" ">
                    <label class="form-label" for="email-login">Email</label>
                    <span style="font-size: 14px; display:inline-block;height:15px">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'email') : ' ' ?>
                    </span>
                </div>
                <div class="position-relative ">
                    <input class="mx-0 w-100 form-input" id="password-login" type="password" name="contraseña" required
                        value="<?= set_value('contraseña'); ?>" placeholder=" ">
                    <label class="form-label" for="password-login">Contraseña</label>
                    <i class="bi bi-eye position-absolute watch-password"
                        style="top:10px; right:15px; cursor:pointer; font-size:20px"></i>
                    <span style="font-size: 14px; display:inline-block;height:15px">
                        <?= isset($validacion) ? mostrarErroresFormulario($validacion, 'contraseña') : ' ' ?>
                    </span>
                </div>
                <div class="d-flex" style="margin-top:-10px">
                    <a class="login-text" href="<?php base_url('registrarse'); ?> ">Olvidaste tu contraseña?</a>
                </div>
                <button class="btn-enviar-datos w-100 mt-4 mb-4 text-uppercase">Iniciar Sesión</button>
                <a class="login-text mb-3" href="<?php echo base_url('registrarse'); ?>">¿No tiene una cuenta?
                    Regístrese</a>
            </div>
        </div>
    </form>
</section>