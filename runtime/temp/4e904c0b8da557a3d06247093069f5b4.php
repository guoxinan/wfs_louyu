<?php /*a:4:{s:63:"D:\project\vfs_bms\application\admin\view\wechat_menu\edit.html";i:1573005998;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;s:63:"D:\project\vfs_bms\application\admin\view\wechat_menu\form.html";i:1573005998;}*/ ?>
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
        <label class="layui-form-label">上级分类</label>
        <div class="layui-input-inline">
            <select name="pid" id="selectOne" lay-filter="selectOne" lay-verify="required">
                <option value="">请选择</option>
                <option value="0">顶级分类</option>

                <?php if(is_array($wechat_menu) || $wechat_menu instanceof \think\Collection || $wechat_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $wechat_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vv['id']); ?>"><?php echo htmlentities($vv['menu']['title']); ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-inline">
            <select name="menu_id" id="selectOne" lay-filter="selectOne" lay-verify="required">
                <option value="">请选择</option>
                <?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="orderby" class="layui-input" lay-verify="required" placeholder="排序">
        </div>
        <div class="layui-form-mid layui-word-aux">越大越靠前</div>
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
        var url_insert = "<?php echo url('admin/wechat_menu/insert'); ?>";
        var url_update = "<?php echo url('admin/wechat_menu/update'); ?>";
        var url_info = "<?php echo url('admin/wechat_menu/info'); ?>";
        var id = "<?php echo htmlentities((app('request')->get('id') ?: 0)); ?>";
        var postData = {id:id};
        //对页面数据进行初始化
        form_obj.init(url_info, postData);
        //监听提交
        form_obj.submit(url_update);
    });
</script>

</body>
</html>