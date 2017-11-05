<header class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="col-md-offset-1 col-md-10">
            <a href="/" id="logo">Weibo</a>
            <nav>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(Auth::check()): ?>
                        <li><a href="<?php echo e(route('users.index')); ?>">用户列表</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php echo e(Auth::user()->name); ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo e(route('users.show', Auth::user()->id)); ?>">个人中心</a></li>
                                <li><a href="<?php echo e(route('users.edit', Auth::user()->id)); ?>">编辑资料</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a id="logout" href="#">
                                        <form action="<?php echo e(route('logout')); ?>" method="POST">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('DELETE')); ?>

                                            <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                                        </form>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="<?php echo e(route('help')); ?>">帮助</a></li>
                        <li><a href="<?php echo e(route('login')); ?>">登录</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>
