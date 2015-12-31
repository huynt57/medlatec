<body class="hold-transition login-page">
    <div class="login-box">
        <div class="box-body">
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Cảnh báo !</h4>
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Thành công !</h4>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="login-logo">
            <b>Quản trị</b> Medlatec
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc của bạn</p>
            <form action="<?php echo Yii::app()->createUrl('user/processLogin') ?>" method="post">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <!--                    <div class="col-xs-8">
                                            <div class="checkbox icheck">
                                                <label>
                                                    <input type="checkbox"> Remember Me
                                                </label>
                                            </div>
                                        </div> /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                    </div><!-- /.col -->
                </div>
            </form>

            <!--            <div class="social-auth-links text-center">
                            <p>- OR -</p>
                            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                        </div> /.social-auth-links 
            
                        <a href="#">I forgot my password</a><br>
                        <a href="register.html" class="text-center">Register a new membership</a>-->

        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


</body>