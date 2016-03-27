<!DOCTYPE html>
<?php $this->beginPage() ?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="renderer" content="webkit">

    <title>登录</title>
    <meta name="keywords" >
    <meta name="description" >

    <link href="css/bootstrap.min.css?v=3.4.0" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css?v=4.3.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=2.2.0" rel="stylesheet">

</head>
<?php $this->beginBody() ?>
<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">H+</h1>

            </div>
            <h3>登录页面</h3>

            <form class="m-t" role="form" >
                <div class="form-group">
                    <input   class="form-control login_phone" placeholder="请输入手机号" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control login_password" placeholder="密码" required="">
                </div>
<!--                <div class="form-group">-->
<!--                    --><?php
//                        echo \yii\captcha\Captcha::widget([
//                            'name' => 'captcha',
//                            'template' => '<div class="input-group input-group-lg "></i></span>{input}<div class="input-group-addon" style="padding:0;">{image}</div></div>',
//                            'options' => ['class' => 'form-control captcha','placeholder'=>"验证码"]
//                        ]);
//                    ?>
<!--                </div>-->
                <a id="submit" class="btn btn-primary block full-width ">登 录</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js?v=3.4.0"></script>
    <script>
        //简单验证
        function validate_form(){
            var flag = false;
            if($(".login_phone").val() && $(".login_password").val()){
                flag = true;
            }
            return flag;
        }

        //提交数据
        function commit_data(){
            var url = "<?=\yii\helpers\Url::toRoute("site/login_validate")?>";
            var data ={
                phone       :   $(".login_phone").val(),
                password    :   $(".login_password").val()
            };

            $.post(url,data,function(msg){
                if(msg.status){
                    location.href = msg.url;
                }else{
                    alert("账户名或密码错误！");
                }
            },'json');
        }
        $("body").on("click","#submit",function(){
            if(validate_form()){
                commit_data();
            }else{
                alert("不能有空值");
            }

        })

    </script>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>