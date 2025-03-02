<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Usuarios</h1>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Permisos Administración</th>
                <th scope="col" class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario) {
                if ($usuario['id'] == session()->get('loggedUser'))
                    continue;
                ?>

                <tr>
                    <td><?php echo $usuario['nombre']; ?> </td>
                    <td><?php echo $usuario['email']; ?> </td>
                    <td><span
                            class="tag <?php echo $usuario['esAdmin'] ? 'tag--success' : 'tag--danger' ?>"><?php echo $usuario['esAdmin'] ? 'Si' : 'No' ?></span>
                    </td>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-end">
                            <button data-bs-toggle="tooltip" data-bs-placement="top" class="cambiar-admin mx-2 rounded-btn"
                                data-bs-title="Cambiar Permiso." data-id="<?= $usuario['id'] ?>"
                                data-admin="<?= $usuario['esAdmin'] ?>"><i class="bi bi-toggles2"></i></button>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('.cambiar-admin').on('click', function () {
            var button = $(this);
            var idUsuario = button.data('id');
            var esAdmin = button.data('admin') ? 0 : 1;
            $.ajax({
                url: '<?php echo base_url('dashboard/usuarios/cambiar-admin'); ?>',
                type: 'POST',
                data: {
                    id: idUsuario,
                    esAdmin: esAdmin
                },
                success: function (response) {
                    if (response.status === 'success') {
                        button.data('admin', esAdmin);
                        button.closest('tr').find('td:nth-child(3)').find('span').text(esAdmin ? 'Sí' : 'No');
                        button.closest('tr').find('td:nth-child(3)').find('span').toggleClass('tag--success');
                        button.closest('tr').find('td:nth-child(3)').find('span').toggleClass('tag--danger');
                    } else {
                        alert('Error al actualizar el usuario');
                    }
                }
            });
        });
    });
</script>