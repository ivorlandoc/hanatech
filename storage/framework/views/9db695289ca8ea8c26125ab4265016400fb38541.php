

<script type="text/javascript">
    Morris.Area.prototype.fillForSeries = function(i)
    {
        var color;
        return "10-#63ceb3-#41b9af";
    }

    function Draw<?php echo e($model->id); ?>() {
        Morris.Area({
            element: "<?php echo e($model->id); ?>",
            resize: true,
            data: [
                <?php for($i = 0; $i < count($model->values); $i++): ?>
                    {
                        x: "<?php echo $model->labels[$i]; ?>",
                        y: <?php echo e($model->values[$i]); ?>

                    },
                <?php endfor; ?>
            ],
            xkey: 'x',
            ykeys: ['y'],
            labels: ["<?php echo $model->element_label; ?>"],
            hideHover: 'auto',
            fillOpacity: 0.6,
            lineWidth: 0.5,
            pointSize: 0,
            lineColors: ['#35978f', '#00bc8c', '#EF6F6C'],
            parseTime: false,

        })
    };
    Draw<?php echo e($model->id); ?>();
  $(".sidebar-toggle").on("click",function () {
      setTimeout(function () {
          $('#<?php echo e($model->id); ?>').empty();
          Draw<?php echo e($model->id); ?>();
      },10);
  });

</script>
<?php if(!$model->customId): ?>
    <?php echo $__env->make('charts::_partials.container.div', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>