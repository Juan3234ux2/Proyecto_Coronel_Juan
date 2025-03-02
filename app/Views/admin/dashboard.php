<section>

</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var monto = <?= $montos ?>;
    var options = {
        series: [{
            name: "Recaudado",
            data: monto
        }],
        chart: {
            type: 'area',
            height: 500,
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: 'Ventas última semana',
            align: 'top'
        },
        labels: <?= $fechas ?>,
        yaxis: {
            opposite: false
        },
        legend: {
            horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
<script>
    var options = {
        series: <?= $porcentajes ?>,
        chart: {
            width: 400,
            type: 'pie',
        },
        labels: <?= $categorias ?>,
        title: {
            text: 'Ventas por categoría',
            align: 'right'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 250
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#categorias"), options);
    chart.render();
</script>