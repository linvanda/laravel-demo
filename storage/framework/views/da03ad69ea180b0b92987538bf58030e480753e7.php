<a href="<?php echo e(route('users.show', $user->id)); ?>">
    <img src="<?php echo e($user->avatar()); ?>" class="gravatar">
</a>
<h1><?php echo e($user->name); ?></h1>