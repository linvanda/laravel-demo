<?php $__env->startSection('title', 'home page one'); ?>
<?php $__env->startSection('content'); ?>

    <?php if(Auth::check()): ?>
        <div class="row">
            <div class="col-md-8">
                <section class="status_form">
                    <?php echo $__env->make('shared._status_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </section>
                <h3>微博列表</h3>
                <?php echo $__env->make('shared._feed', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <aside class="col-md-4">
                <section class="user_info">
                    <?php echo $__env->make('shared._user_info', ['user' => Auth::user()], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </section>
                <section class="stats">
                    <?php echo $__env->make('shared._stats', ['user' => Auth::user()], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </section>
            </aside>
        </div>
    <?php else: ?>
        <div class="jumbotron">
            <h1>Hello Laravel</h1>
            <p class="lead">
                你现在所看到的是 <a href="https://fsdhub.com/books/laravel-essential-training-5.1">Laravel 入门教程</a> 的示例项目主页。
            </p>
            <p>
                一切，将从这里开始。哈哈哈哈哦哦哦哦
            </p>
            <p>
                <a class="btn btn-lg btn-success" href="<?php echo e(route('users.create')); ?>" role="button">现在注册</a>
            </p>
        </div>
    <?php endif; ?>
    <example></example>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>