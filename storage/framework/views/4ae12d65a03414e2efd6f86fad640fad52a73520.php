<?php if($user->id !== Auth::user()->id): ?>
    <div id="follow_form">
        <?php if(Auth::user()->isFollowing($user->id)): ?>
            <form action="<?php echo e(route('followers.destroy', $user->id)); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('DELETE')); ?>

                <button type="submit" class="btn btn-sm">取消关注</button>
            </form>
        <?php else: ?>
            <form action="<?php echo e(route('followers.store', $user->id)); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <button type="submit" class="btn btn-sm btn-primary">关注</button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>