<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Quản trị viên</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Điều hướng chính</li>
                <?php if (!empty(Yii::app()->session['meboo_admin'])): ?>
                <li>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('order/index') ?>">
                        <span>Quản lý đặt khám Meboo</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty(Yii::app()->session['provider_admin'])): ?>
                <li>
                    <a href="<?php echo Yii::app()->createAbsoluteUrl('orderMed/index') ?>">
                        <span>Quản lý đặt khám Đối tác</span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('result/index') ?>">
                    <span>Quản lý kết quả đặt khám</span>
                </a>
            </li>
            <li>
                <a href="<?php echo Yii::app()->createAbsoluteUrl('service/index') ?>">
                    <span>Quản lý dịch vụ</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
