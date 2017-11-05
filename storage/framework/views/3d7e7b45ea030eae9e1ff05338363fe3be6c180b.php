<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title', 'laravel demo'); ?></title>
    <link rel="stylesheet" href="<?php echo e(mix('/css/app.css')); ?>">
</head>
<body>
    <?php echo $__env->make('layouts._header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="container" id="app">
        <div class="col-md-offset-1 col-md-10">
            <?php echo $__env->make('shared._messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('layouts._footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    </div>

    <script src="<?php echo e(mix('/js/manifest.js')); ?>"></script>
    <script src="<?php echo e(mix('/js/vendor.js')); ?>"></script>
    <script src="<?php echo e(mix('/js/app.js')); ?>"></script>
</body>
</html>