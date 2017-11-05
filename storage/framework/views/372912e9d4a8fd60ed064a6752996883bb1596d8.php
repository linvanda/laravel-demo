<?php $__env->startSection('title', '更新用户资料'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>更新个人资料</h5>
            </div>
            <div class="panel-body">

                <?php echo $__env->make('shared._errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="gravatar_edit">
                    <a href="http://gravatar.com/emails" target="_blank">
                        <img src="<?php echo e($user->avatar('200')); ?>" alt="<?php echo e($user->name); ?>" class="gravatar"/>
                    </a>
                </div>

                <form method="POST" action="<?php echo e(route('users.update', $user->id )); ?>">
                    <?php echo e(method_field('PATCH')); ?>

                    <?php echo e(csrf_field()); ?>


                    <div class="form-group">
                        <label for="name">名称：</label>
                        <input type="text" name="name" class="form-control" value="<?php echo e($user->name); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">邮箱：</label>
                        <input type="text" name="email" class="form-control" value="<?php echo e($user->email); ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="password">密码：</label>
                        <input type="password" name="password" class="form-control" value="<?php echo e(old('password')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">确认密码：</label>
                        <input type="password" name="password_confirmation" class="form-control" value="<?php echo e(old('password_confirmation')); ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">更新</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>