<?php
    use yii\helpers\Url;
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
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Beaut-zihan</strong>
                             </span> <span class="text-muted text-xs block">超级管理员 <b class="caret"></b></span> </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="form_avatar.html">修改头像</a>
                            </li>
                            <li><a href="profile.html">个人资料</a>
                            </li>
                            <li><a href="contacts.html">联系我们</a>
                            </li>
                            <li><a href="mailbox.html">信箱</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="login.html">安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        H+
                    </div>

                </li>
                <li >
                    <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">品牌管理</span> </a>
                    <ul class="nav nav-second-level">
                        <li><a href="品牌管理-添加品牌.html">添加品牌</a>
                        </li>
                        <li><a href="品牌管理-品牌列表.html">品牌列表</a>
                        </li>

                    </ul>
                </li>

                <li class="active">
                    <a href="index.html#"><i class="fa fa fa-globe"></i> <span class="nav-label">用户管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="用户管理-客户列表.html">客户列表</a>
                        </li>
                        <li><a href="<?=Url::toRoute('worker/list')?>">职员列表</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="index.html#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">节日管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="出团管理-节日列表.html">节日列表</a>
                        </li>
                        <li><a href="出团列表-添加节日.html">添加节日</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="index.html#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">出团管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="出团管理-出团列表.html">出团列表</a>
                        </li>
                        <li><a href="出团列表-添加出团.html">添加出团</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">角色管理 </span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="角色管理-角色列表.html">角色列表</a>
                        </li>
                        <li><a href="角色列表-添加角色.html">添加角色</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="index.html#"><i class="fa fa-edit"></i> <span class="nav-label">区域管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="区域管理-区域列表.html">区域列表</a>
                        </li>
                        <li><a href="区域列表-添加区域.html">添加区域</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="index.html#"><i class="fa fa-desktop"></i> <span class="nav-label">回访管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="回访管理-回访记录.html">回访记录</a>
                        </li>
                        <li><a href="回访记录-备注设置.html">备注设置</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="index.html#"><i class="fa fa-files-o"></i> <span class="nav-label">管理员管理</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="管理员管理-管理员列表.html">管理员列表</a>
                        </li>
                        <li><a href="管理员列表-添加管理员.html">添加管理员</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="index.html#"><i class="fa fa-flask"></i> <span class="nav-label">系统设置</span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="系统设置-修改密码.html">修改密码</a>
                        </li>
                        <li><a href="#">退出登录</a>
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