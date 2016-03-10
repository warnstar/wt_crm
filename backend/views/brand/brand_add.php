<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
    <div class="col-lg-10">
        <h2>品牌管理-添加品牌</h2>
    </div>

</div>
<!-- 标题 -->

<div class="row">
    <div class="col-lg-12 animated fadeInRight">
        <div class="ibox float-e-margins">

            <div class="ibox-title">
                <h5>添加品牌</h5>
            </div>

            <div class="ibox-content">
                <form method="post" class="form-horizontal" id="signupForm" >
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品牌名称</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control"  name="name" >
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品牌介绍</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" style="height:68px;"></textarea>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">注意事项</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" name="notice" style="height:68px;"></textarea>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">品牌经理</label>

                        <div class="col-sm-10">
                            <select class="form-control m-b" name="manager">
                                <option>空</option>
                                <option>张三</option>
                                <option>李四</option>
                                <option>王五</option>
                            </select>
                        </div>


                    </div>


                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-3">
                            <button class="btn btn-primary" type="submit">提交</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- jQuery Validation plugin javascript-->
<script src="js/plugins/validate/jquery.validate.min.js"></script>
<script src="js/plugins/validate/messages_zh.min.js"></script>
<script type="text/javascript">
    //以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
    //以下是数据验证
    $.validator.setDefaults({
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function (element) {
            element.closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorElement: "span",
        errorClass: "help-block m-b-none",
        validClass: "help-block m-b-none"


    });

    //以下为官方示例
    $().ready(function () {
        // validate the comment form when it is submitted


        // validate signup form on keyup and submit
        $("#signupForm").validate({
            rules: {
                name: "required",
                notice: "required"

            },
            messages: {
                name: "请输入品牌名称",

                notice: "请输入该品牌的注意事项"

            }
        });


    });

</script>