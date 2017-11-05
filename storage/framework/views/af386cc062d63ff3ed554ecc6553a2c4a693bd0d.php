<li id="status-<?php echo e($status->id); ?>">
    <a href="<?php echo e(route('users.show', $user->id )); ?>">
        <img src="<?php echo e($user->avatar()); ?>" alt="<?php echo e($user->name); ?>" class="gravatar"/>
    </a>
    <span class="user">
    <a href="<?php echo e(route('users.show', $user->id )); ?>"><?php echo e($user->name); ?></a>
  </span>
    <span class="timestamp">
    <?php echo e($status->created_at->diffForHumans()); ?>

  </span>
    <span class="content"><?php echo e($status->content); ?></span>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy', $status)): ?>
        <form action="<?php echo e(route('statuses.destroy', $status->id)); ?>" method="POST">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('DELETE')); ?>

            <button type="submit" class="btn btn-sm btn-danger status-delete-btn">删除</button>
        </form>
    <?php endif; ?>
</li>