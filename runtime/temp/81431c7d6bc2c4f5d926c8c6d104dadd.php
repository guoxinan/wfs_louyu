<?php /*a:3:{s:58:"D:\project\vfs_bms\application\admin\view\excel\index.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;}*/ ?>
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


<blockquote class="layui-elem-quote quoteBox">
    <form class="layui-form" enctype="multipart/form-data">
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input name="username" type="text" class="layui-input" placeholder="请输入搜索的内容"/>
            </div>
            <div class="layui-input-inline">
                <select name="status" id="status">
                    <option value="">状态</option>
                    <?php if(is_array($status_list) || $status_list instanceof \think\Collection || $status_list instanceof \think\Paginator): $i = 0; $__LIST__ = $status_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <a class="layui-btn search_btn" lay-submit lay-filter="tablelistReload" id="tablelistReload">搜索</a>
        </div>
    </form>
</blockquote>

<div id="boxTableNone">
    <script type="text/html" id="tplToolbar">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm" id="buttonAdd" lay-event="buttonAdd">
                <i class="layui-icon"></i>导入
            </button>
        </div>
    </script>

    <script type="text/html" id="toolbarHtml">
        {{#  if(d.id !== 1){ }}
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs" lay-event="del">删除</a>
        {{#  } }}
    </script>

    <table class="layui-hide layui-table x-admin" id="tablelist" lay-filter="tablelist"></table>
</div>
<script type="text/javascript" src="/static/vfs/tablelistobj.js"></script>
<script>
    layui.use(['form', 'table', 'jquery', 'layer', 'upload'], function () {
        var table = layui.table;
        var form = layui.form;
        var layer = layui.layer;
        var $ = layui.jquery;
        //渲染列表
        tablelistobj.$ = $;
        tablelistobj.tool_obj = {
            lists: {href: "<?php echo url('admin/admin/lists'); ?>", title: '列表'},
            add: {href: "<?php echo url('admin/excel/add'); ?>", title: '导入'},
            edit: {href: "<?php echo url('admin/admin/edit'); ?>", title: '编辑'},
            del: {href: "<?php echo url('admin/admin/del'); ?>", title: '删除'},
        };
        tablelistobj.cols = [[
            //{field: 'id', type: 'checkbox', width: 80},
            {field: 'id', width: 80, title: 'ID', sort: true},
            {field: 'username', title: '用户名'},
            {field: 'mobile', title: '手机号'},
            {field: 'role_name', title: '角色'},
            {field: 'status_name', title: '状态',},
            {field: '', title: '操作', align: 'center', toolbar: '#toolbarHtml', width: 150}
        ]];
        tablelistobj.render(table);
        //搜索表单
        tablelistobj.search(table, form);
        //操作按钮
        tablelistobj.form_width = 700;
        tablelistobj.form_height = 500;
        tablelistobj.tool(table, layer);
        //头工具栏事件
        tablelistobj.toolbar(table, layer);
    });
</script>

</body>
</html>