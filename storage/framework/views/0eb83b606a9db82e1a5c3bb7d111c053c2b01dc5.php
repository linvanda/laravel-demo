<?php if(count($feed_items)): ?>
    <ol class="statuses">
        <?php $__currentLoopData = $feed_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('statuses._status', ['user' => $status->user], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php echo $feed_items->render(); ?>

    </ol>
<?php endif; ?>