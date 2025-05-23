<script type="module">
    import { toggleDropdown } from '<?php echo base_url('assets/js/utils.js'); ?>';
    window.toggleDropdown = toggleDropdown;
</script>
<nav class="w-100 bg-white" style="height: 55px;">
    <div class="d-flex justify-content-end align-items-center h-100 mx-5 position-relative">
        <button id="btn-user-dashboard" class="popover-trigger" onclick="toggleDropdown('popover-user')">
            <span style=" background-color: rgb(21, 31, 31);border-radius:3px; padding: 3px 11px; font-size: 14px; color:
            white;">
                <?php echo $usuario['nombre'][0]; ?>
            </span>
            <span class="fw-semibold" style="font-size: 13px;">
                <?php echo $usuario['nombre']; ?>
            </span>
        </button>
        <div id="popover-user" class="d-none popover">
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
</nav>
<div class="contenedor-toast" id="contenedor-toast">
    <!-- Plantilla de toast
                <div class="toast exito" id="1">
                    <div class="contenido">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"
                                />
                            </svg>
                        </div>
                        <div class="texto">
                            <p class="titulo">Exito!</p>
                            <p class="descripcion">La operación fue exitosa.</p>
                        </div>
                    </div>
                    <button class="btn-cerrar">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                />
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="toast error" id="2">
                    <div class="contenido">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                />
                            </svg>
                        </div>
                        <div class="texto">
                            <p class="titulo">Error!</p>
                            <p class="descripcion">Hubo un error al intentar procesar la operación.</p>
                        </div>
                    </div>
                    <button class="btn-cerrar">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                />
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="toast info" id="3">
                    <div class="contenido">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                                />
                            </svg>
                        </div>
                        <div class="texto">
                            <p class="titulo">Info</p>
                            <p class="descripcion">Esta es una notificacion informativa.</p>
                        </div>
                    </div>
                    <button class="btn-cerrar">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                />
                            </svg>
                        </div>
                    </button>
                </div>
                <div class="toast warning" id="4">
                    <div class="contenido">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                                />
                            </svg>
                        </div>
                        <div class="texto">
                            <p class="titulo">Advertencia</p>
                            <p class="descripcion">Esta notificación es para advertirte sobre algo.</p>
                        </div>
                    </div>
                    <button class="btn-cerrar">
                        <div class="icono">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                                />
                            </svg>
                        </div>
                    </button>
                </div> -->
</div>