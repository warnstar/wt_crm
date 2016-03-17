<?php
    use yii\helpers\Url;
    $session = Yii::$app->session;
    $session->open();
    $worker = $session->get("worker");

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title></title>
    <meta name="keywords" >

    <link href="css/bootstrap.min.css?v=3.4.0" rel="stylesheet">


    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="js/plugins/layer/skin/layer.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=2.2.0" rel="stylesheet">


    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/hplus.js?v=2.2.0"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- layer javascript -->
    <script src="js/plugins/layer/layer.min.js"></script>

    <!-- jQuery Validation plugin javascript-->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    <script src="js/plugins/validate/messages_zh.min.js"></script>
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/daterangepicker.js"></script>

    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker-bs3.css"/>

</head>

<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">

                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="img/profile_small.jpg" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=$worker['name']?></strong>
                             </span> <span class="text-muted text-xs block"><?=$worker['role_name'] . "(" .$worker['brand_name']  . ")"?></span> </span>
                        </a>

                    </div>
                    <div class="logo-element">
                        H+
                    </div>

                </li>

                 <?php if($worker['role_id'] == 1):?>
                <li >
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">品牌管理</span> </a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=Url::toRoute("brand/add")?>">添加品牌</a>
                        </li>
                        <li><a href="<?=Url::toRoute("brand/list")?>">品牌列表</a>
                        </li>

                    </ul>
                </li>
                <?php endif;?>

                <?php if($worker['role_id'] == 1 || $worker['role_id'] == 2):?>
                <li>
                    <a href="index.html#"><i class="fa fa fa-globe"></i> <span class="nav-label">用户管理</span></a>
                    <ul class="nav nav-second-level">

                        <li><a href="<?=Url::toRoute('users/list')?>">客户列表</a>
                        </li>
                        <?php if($worker['role_id'] == 2):?>

                        <li><a href="<?=Url::toRoute('users/add')?>">添加客户</a>
                        </li>
                        <?php endif;?>

                        <?php if($worker['role_id'] == 1):?>
                        <li><a href="<?=Url::toRoute('worker/list')?>">职员列表</a>
                        </li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>

                <?php if($worker['role_id'] == 1):?>
                <li>
                    <a href="index.html#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">节日管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=Url::toRoute("festival/list")?>">节日列表</a>
                        </li>
                        <li><a href="<?=Url::toRoute("festival/add")?>">添加节日</a>
                        </li>

                    </ul>
                </li>
                <?php endif;?>


                <li>
                    <a href="index.html#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">出团管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=Url::toRoute("group/list")?>">出团列表</a>
                        </li>
                        <li><a href="<?=Url::toRoute("group/add")?>">添加出团</a>
                        </li>

                    </ul>
                </li>

                <?php if($worker['role_id'] == 1 || $worker['role_id'] == 2):?>
                <li>
                    <a href="index.html#"><i class="fa fa-desktop"></i> <span class="nav-label">回访管理</span></a>
                    <ul class="nav nav-second-level">
                        <?php if($worker['role_id'] == 2):?>
                        <li><a href="<?=Url::toRoute("visit/un_visit_list")?>">待访客户</a>
                        </li>
                        <?php endif;?>

                        <li><a href="<?=Url::toRoute("visit/visit_list")?>">回访记录</a>
                        </li>

                        <?php if($worker['role_id'] == 1):?>
                        <li><a href="<?=Url::toRoute("note/note_type_list")?>">备注设置</a>
                        </li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>

                <?php if($worker['role_id'] == 1):?>
                <li>
                    <a href="index.html#"><i class="fa fa-edit"></i> <span class="nav-label">区域管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=Url::toRoute("area/list")?>">区域列表</a>
                        </li>
                        <li><a href="<?=Url::toRoute("area/add")?>">添加区域</a>
                        </li>

                    </ul>
                </li>
                <?php endif;?>

                <li>
                    <a href="index.html#"><i class="fa fa-flask"></i> <span class="nav-label">系统设置</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="<?=Url::toRoute("worker/password_reset")?>">修改密码</a>
                        </li>
                        <li><a href="<?=Url::toRoute("site/logout")?>">退出登录</a>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?=$content?>
    </div>

</div>

</body>

</html>