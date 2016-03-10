<!-- 标题 -->
<div class="row wrapper border-bottom white-bg page-heading title">
    <div class="col-lg-10">
        <h2>品牌管理-品牌列表</h2>
    </div>

</div>
<!-- 标题 -->

<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">

            <div class="ibox">
                <div class="ibox-title">
                    <h5>所有品牌</h5>
                    <div class="ibox-tools">
                        <a href="<?=\yii\helpers\Url::toRoute("brand/add")?>" class="btn btn-primary btn-xs">创建新品牌</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row m-b-sm m-t-sm">
                        <div class="col-md-1">
                            <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                        </div>

                    </div>

                    <div class="project-list">

                        <table class="table table-hover">
                            <thead>
                            <tr align="center">
                                <td>序号</td>
                                <td>品牌名称</td>
                                <td>品牌介绍</td>
                                <td>品牌经理</td>
                                <td>操作</td>
                            </tr>
                            </thead>
                            <tbody align="center">
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="project-status">1</td>
                                <td class="project-title">泰太美</td>
                                <td class="project-title">这个是品牌介绍，太长了建议隐藏一下</td>
                                <td class="project-title">张三</td>
                                <td >
                                    <button class=" btn btn-white btn-sm">查看详情</button>
                                    <button class="btn-delete btn btn-white btn-sm">删除</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.btn-delete').on('click', function(){
        var obj = $(this).parent().parent();//记录一下当前元素
        $.layer({
            shade: [0],
            area: ['auto','auto'],
            dialog: {
                msg: '您确定要删除这条数据吗？',
                btns: 2,
                type: 0,
                btn: ['确定','取消'],
                yes: function(){

                    obj.remove();//删除当前行
                    layer.msg('删除成功！',3 , {
                        type:1,
                        rate: 'bottom',
                        shade: [0]
                    });
                }, no: function(){
                    layer.msg('删除失败！',3 , {
                        type:8,
                        rate: 'bottom',
                        shade: [0]
                    });
                }
            }
        });
    });


</script>