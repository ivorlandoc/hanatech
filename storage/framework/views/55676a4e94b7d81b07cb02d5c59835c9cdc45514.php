<script type="text/javascript">
    google.charts.setOnLoadCallback(drawPieChart)

    function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
            ['Element', 'Value'],
            <?php for($i = 0; $i < count($model->values); $i++): ?>
                ["<?php echo $model->labels[$i]; ?>", <?php echo e($model->values[$i]); ?>],
            <?php endfor; ?>
        ])

        var options = {
            <?php echo $__env->make('charts::_partials.dimension.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            fontSize: 12,

            <?php echo $__env->make('charts::google.colors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        };

        var chart = new google.visualization.PieChart(document.getElementById("<?php echo e($model->id); ?>"))
        chart.draw(data, options)
    }

    $(".sidebar-toggle").on("click",function () {
        setTimeout(function () {
            drawPieChart();
        });
    });
    $(window).on('resize', function () {
        setTimeout(function () {
            drawPieChart();
        });
    });
</script>

<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials.container.div', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>
