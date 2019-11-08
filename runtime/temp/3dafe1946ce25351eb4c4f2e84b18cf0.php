<?php /*a:4:{s:56:"D:\project\vfs_bms\application\admin\view\admin\add.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\admin\form.html";i:1573005997;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<title>采购总后台</title>

<link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all" />
<link rel="stylesheet" href="/static/admin/css/public.css" media="all" />
<link rel="stylesheet" href="/static/admin/css/admin.css" media="all" />
<link rel="stylesheet" href="/static/admin/css/font_400842_q6tk84n9ywvu0udi.css" media="all" />

<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/vfs/jquery.min.js"></script>
</head>
<body class="childrenBody">


<form class="layui-form" style="width:80%;" lay-filter="formFilter">

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-inline">
            <input type="text" name="username" class="layui-input" lay-verify="required" placeholder="名称">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">手机号</label>
        <div class="layui-input-inline">
            <input type="text" name="mobile" class="layui-input" lay-verify="required" placeholder="手机号">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-inline">
            <input type="text" name="password" class="layui-input" placeholder="密码">
        </div>
        <div class="layui-form-mid layui-word-aux">不填,默认为123456</div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">角色</label>
        <div class="layui-input-inline">
            <select name="role_id" id="role_id" lay-verify="required">
                <option value="">请选择</option>
                <?php if(is_array($role_list) || $role_list instanceof \think\Collection || $role_list instanceof \think\Paginator): $i = 0; $__LIST__ = $role_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
            <?php if(is_array($status_list) || $status_list instanceof \think\Collection || $status_list instanceof \think\Paginator): $i = 0; $__LIST__ = $status_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <input type="radio" name="status" value="<?php echo htmlentities($vo['id']); ?>" title="<?php echo htmlentities($vo['title']); ?>">
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <input type="hidden" id="id" name="id" value="">
    <div class="layui-form-item layui-row layui-col-xs12">
        <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-sm" lay-submit="" lay-filter="formSubmit">确定</button>
        </div>
    </div>
</form>

<script>
    var form_obj = {
        formFilter: 'formFilter',
        formSubmit: 'formSubmit',
        init: function (url, postData) {
            var that = this;
            var formFilter = that.formFilter;
            $.ajax({
                url: url,
                data: postData,
                type: 'post',
                async: true,
                success: function (res) {
                    var info = res.data.info;
                    if (info.id !== undefined) {
                        info.status = info.status.toString();
                        layui.form.val(formFilter, info);
                    }
                },
                dataType: 'json',
            });
        },
        submit: function (url) {
            var that = this;
            var formSubmit = that.formSubmit;
            layui.form.on('submit(' + formSubmit + ')', function (data) {
                var formData = data.field;
                $.post(url, formData, function (res) {
                    var message = res.message;
                    if (res.code == 0) {
                        layer.msg(message, {icon: 1, time: 2000});
                        layer_obj.close(2000);
                    } else {
                        layer.msg(message, {icon: 2, time: 2000});
                    }
                }, 'json')
                return false;
            });
        }
    };
    var layer_obj = {
        close: function (times) {
            setTimeout(function () {
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
                parent.location.reload();
            }, times)
        }
    };
</script>
<script>
    layui.use(['form', 'layer'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var url_insert = "<?php echo url('admin/admin/insert'); ?>";
        var url_update = "<?php echo url('admin/admin/update'); ?>";
        var url_info = "<?php echo url('admin/admin/info'); ?>";
        var id = "<?php echo htmlentities((app('request')->get('id') ?: 0)); ?>";
        var url_form = url_insert;
        if(id > 0){
            url_form = url_update;
        }
        var postData = {id:id};
        //对页面数据进行初始化
        form_obj.init(url_info, postData);
        //监听提交
        form_obj.submit(url_form);
    });
</script>


</body>
</html>