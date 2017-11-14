<form action="<?php echo e(route('statuses.store')); ?>" method="POST">
    <?php echo $__env->make('shared._errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo e(csrf_field()); ?>

    <textarea class="form-control" rows="3" placeholder="聊聊新鲜事儿..." name="content"><?php echo e(old('content')); ?></textarea>
    <button type="submit" class="btn btn-primary pull-right">发布</button>
</form>