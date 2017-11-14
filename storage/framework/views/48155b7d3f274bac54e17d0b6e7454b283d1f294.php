<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e(config('app.name')); ?> - Authorization</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        .passport-authorize .container {
            margin-top: 30px;
        }

        .passport-authorize .scopes {
            margin-top: 20px;
        }

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }
    </style>
</head>
<body class="passport-authorize">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Authorization Request
                    </div>
                    <div class="panel-body">
                        <!-- Introduction -->
                        <p><strong><?php echo e($client->name); ?></strong> is requesting permission to access your account.</p>

                        <!-- Scope List -->
                        <?php if(count($scopes) > 0): ?>
                            <div class="scopes">
                                    <p><strong>This application will be able to:</strong></p>

                                    <ul>
                                        <?php $__currentLoopData = $scopes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($scope->description); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                            </div>
                        <?php endif; ?>

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="/oauth/authorize">
                                <?php echo e(csrf_field()); ?>


                                <input type="hidden" name="state" value="<?php echo e($request->state); ?>">
                                <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">
                                <button type="submit" class="btn btn-success btn-approve">Authorize</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="/oauth/authorize">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('DELETE')); ?>


                                <input type="hidden" name="state" value="<?php echo e($request->state); ?>">
                                <input type="hidden" name="client_id" value="<?php echo e($client->id); ?>">
                                <button class="btn btn-danger">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
