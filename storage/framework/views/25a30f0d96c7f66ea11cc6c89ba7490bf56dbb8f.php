<?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msgKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session()->has($msgKey)): ?>
        <div class="flash-message">
            <p class="alert alert-<?php echo e($msgKey); ?>">
                <?php echo e(session()->get($msgKey)); ?>

            </p>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>