<?php $__env->startSection('title', '登录'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>登录</h5>
            </div>
            <div class="panel-body">
                <?php echo $__env->make('shared._errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group">
                        <label for="email">邮箱：</label>
                        <input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">密码（<a href="<?php echo e(route('password.request')); ?>">忘记密码</a>）：</label>
                        <input type="password" name="password" class="form-control" value="<?php echo e(old('password')); ?>">
                    </div>

                    <div class="checkbox">
                        <label><input type="checkbox" name="remember"> 记住我</label>
                    </div>

                    <button type="submit" class="btn btn-primary">登录</button>
                </form>

                <hr>

                <p>还没账号？<a href="<?php echo e(route('users.create')); ?>">现在注册！</a></p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>