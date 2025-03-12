<script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/js/dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap5.js'); ?>"></script>
<script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'header': 1 }, { 'header': 2 }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'script': 'sub' }, { 'script': 'super' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],

        [{ 'size': ['small', false, 'large', 'huge'] }],

        [{ 'color': [] }, { 'background': [] }],
        [{ 'font': [] }],
        [{ 'align': [] }],

        ['clean']
    ];
</script>
<script type="module">
    import autoAnimate from 'https://cdn.jsdelivr.net/npm/@formkit/auto-animate'
    const contenedorPrensentaciones = document.getElementById('contenedor-presentaciones')
    if (contenedorPrensentaciones) {
        autoAnimate(contenedorPrensentaciones)
    } 
</script>
</body>

</html>