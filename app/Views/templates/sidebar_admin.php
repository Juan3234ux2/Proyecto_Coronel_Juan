<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnInventario = document.getElementById('btn-inventario');
        btnInventario.addEventListener('click', function () {
            btnInventario.classList.toggle('active');
            const dropdownInventario = document.getElementById('dropdown-inventario');
            toggleDropdown(dropdownInventario);
        })
    })
</script>
<aside class="vh-100 bg-white position-fixed" style="width: 280px;">
    <div class="d-flex justify-content-center">
        <img class="my-4" src="<?php echo base_url('assets/img/logo.jpg'); ?>" alt="Logo Juanchos Lab">
    </div>
    <ul class="d-flex flex-column gap-3 fw-semibold" style="list-style: none; margin-top: 30px;">
        <li class="d-flex gap-2">
            <i class="bi bi-house"></i>
            <a class="text-black" href="<?php echo base_url('dashboard'); ?>">Inicio</a>
        </li>
        <li class="d-flex gap-2">
            <i class="bi bi-currency-dollar"></i>
            <a class="text-black" href="<?php echo base_url('dashboard/pedidos'); ?>">Ventas</a>
        </li>
        <li>
            <button id="btn-inventario" class="d-flex justify-content-between align-items-center w-100 p-0 fw-semibold"
                style="background-color: transparent; border: none;">
                <div class="d-flex gap-2">
                    <i class="bi bi-boxes"></i>
                    <span class="text-black">Inventario</span>
                </div>
                <i style="font-size: 12px;" class="bi bi-chevron-down mx-3"></i>
            </button>
            <div id="dropdown-inventario" class="d-none">
                <ul class="d-flex flex-column gap-3 fw-semibold" style="list-style: none;">
                    <li class="mt-3"><a class="text-black"
                            href="<?php echo base_url('dashboard/productos') ?>">Productos</a></li>
                    <li><a class="text-black" href="<?php echo base_url('dashboard/categorias') ?>">Categorias</a></li>
                    <li><a class="text-black" href="<?php echo base_url('dashboard/unidades') ?>">Unidades</a></li>
                    <li><a class="text-black" href="<?php echo base_url('dashboard/marcas') ?>">Marcas</a></li>
                </ul>
            </div>
        </li>


        <li class="d-flex gap-2">
            <i class="bi bi-people"></i>
            <a class="text-black" href="<?php echo base_url('dashboard/usuarios') ?>">Usuarios</a>
        </li>
        <li class="d-flex gap-2">
            <i class="bi bi-chat"></i>
            <a class="text-black" href="<?php echo base_url('dashboard/consultas'); ?>">Consultas</a>
        </li>

</aside>