<?php /*a:4:{s:55:"D:\project\vfs_bms\application\admin\view\role\add.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;s:56:"D:\project\vfs_bms\application\admin\view\role\form.html";i:1573005997;}*/ ?>
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
        <label class="layui-form-label">名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" lay-verify="required" placeholder="名称">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">分配节点</label>
        <div class="layui-input-block">
            <div id="boxNodeList" class="demo-tree-more"></div>
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
                    layui.form.val(formFilter, info);
                    var node_list = info.node_list;
                    tree_obj.render(node_list);
                    var node_id_arr = info.node_id_arr;
                    tree_obj.set_checked(node_id_arr);

                },
                dataType: 'json',
            });
        },
        type_change: function (url) {
            var that = this;
            layui.form.on('select(type)', function (data) {
                var value = data.value;
                if (value != '') {
                    tree_obj.init(url);
                } else {
                    var id = tree_obj.id;
                    $('#' + id).html('');
                }
            });
        },
        submit: function (url) {
            var that = this;
            var formSubmit = that.formSubmit;
            layui.form.on('submit(' + formSubmit + ')', function (data) {
                var formData = data.field;
                var node_id_arr = tree_obj.get_checked('id');
                formData.node_id_arr = node_id_arr;
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

    var tree_obj = {
        tree_id: 'TreeObjId',
        id: 'boxNodeList',
        init: function (url) {
            var that = this;
            var type = $('#type').val();
            if (type == '') {
                return false;
            }
            var obj = {type: type};
            $.post(url, obj, function (res) {
                var data = res.data;
                that.render(data);
            }, 'json');
        },
        set_checked: function ($arr) {
            var that = this;
            var tree_id = that.tree_id;
            layui.tree.setChecked(tree_id, $arr);
        },
        get_checked: function (type) {
            var that = this;
            var tree_id = that.tree_id;
            var type = type || 'id';
            var check_data = layui.tree.getChecked(tree_id);
            var type_arr = [];
            that.get_repeat_by_type(type_arr, check_data, type);
            return type_arr;
        },
        get_repeat_by_type: function (type_arr, data, type) {
            var that = this;
            $.each(data, function(i, n){
                var children = n.children;
                type_arr.push(n[type]);
                if(children.length != 0){
                    that.get_repeat_by_type(type_arr, children, type);
                }
            });
            return type_arr;
        },
        render: function (data) {
            var that = this;
            var tree_id = that.tree_id;
            var elem = '#' + that.id;
            layui.tree.render({
                elem: elem,
                data: data,
                showCheckbox: true,  //是否显示复选框
                id: tree_id,
                isJump: true, //是否允许点击节点时弹出新窗口跳转,
                click: function (obj) {
                    //var data = obj.data;  //获取当前点击的节点数据
                    //layer.msg('状态：' + obj.state + '<br>节点数据：' + JSON.stringify(data));
                }
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
    layui.use(['form', 'layer', 'tree', 'util'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var tree = layui.tree;
        var util = layui.util;
        var url_insert = "<?php echo url('admin/role/insert'); ?>";
        var url_update = "<?php echo url('admin/role/update'); ?>";
        var url_info = "<?php echo url('admin/role/info'); ?>";
        var url_node_list = "<?php echo url('admin/node/allList'); ?>";
        var id = "<?php echo htmlentities((app('request')->get('id') ?: 0)); ?>";
        var postData = {id: id};
        var url_submit = url_insert;
        if (id > 0) {
            url_submit = url_update;
        }
        //对页面数据进行初始化
        form_obj.init(url_info, postData);
        //监听提交
        form_obj.submit(url_submit);
        form_obj.type_change(url_node_list);
    });
</script>


</body>
</html>