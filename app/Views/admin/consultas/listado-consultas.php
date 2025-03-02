<section class="card-dashboard">
    <h1 class="fs-2 fw-bold mt-3 px-4">Consultas</h1>
    <table id="tablaDatos" class="table-dashboard">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Tipo Consulta</th>
                <th scope="col">Resuelto</th>
                <th scope="col" class="text-end px-4">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $consulta) { ?>
                <tr id="<?= $consulta['id']; ?>">
                    <td><?php echo $consulta['nombre']; ?> </td>
                    <td><?php echo $consulta['email']; ?> </td>
                    <td><?php echo $consulta['tipo_consulta']; ?> </td>
                    <td><span
                            class="tag <?php echo $consulta['resuelto'] ? 'tag--success' : 'tag--danger' ?>"><?php echo $consulta['resuelto'] ? 'Si' : 'No' ?></span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center justify-content-end">
                            <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ver Mensaje."
                                class="rounded-btn"
                                href="<?php echo base_url('dashboard/detalle-consulta/') . $consulta['id']; ?>"><i
                                    class="bi bi-eye"></i></a>
                            <button data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cambiar Estado."
                                data-resuelto="<?= $consulta['resuelto'] ?>" data-id="<?= $consulta['id'] ?>"
                                class="cambiar-estado mx-2 rounded-btn"><i class="bi bi-toggles2"></i></button>
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
        $('.cambiar-estado').on('click', function () {
            var button = $(this);
            var idConsulta = button.data('id');
            var estaResuelto = button.data('resuelto') ? 0 : 1;
            $.ajax({
                url: '<?php echo base_url('consultas/resolver-consulta'); ?>',
                type: 'POST',
                data: {
                    id: idConsulta,
                    isResolved: estaResuelto
                },
                success: function (response) {
                    if (response.status === 'success') {
                        button.data('resuelto', estaResuelto);
                        button.closest('tr').find('td:nth-child(4)').find('span').text(estaResuelto ? 'Sí' : 'No');
                        button.closest('tr').find('td:nth-child(4)').find('span').toggleClass('tag--success');
                        button.closest('tr').find('td:nth-child(4)').find('span').toggleClass('tag--danger');
                    } else {
                        alert('Error al actualizar la consulta');
                    }
                }
            });
        });
    });
</script>