<?php /*a:3:{s:64:"D:\project\vfs_bms\application\admin\view\sys_article\index.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;}*/ ?>
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


<!--<blockquote class="layui-elem-quote quoteBox">-->
    <!--<form class="layui-form">-->
        <!--<div class="layui-inline" style="display: none;">-->
            <!--<div class="layui-input-inline">-->
                <!--<input name="title" type="text" class="layui-input" placeholder="请输入搜索的内容"/>-->
            <!--</div>-->
            <!--<a class="layui-btn search_btn" lay-submit lay-filter="tablelistReload" id="tablelistReload">搜索</a>-->
        <!--</div>-->
    <!--</form>-->
<!--</blockquote>-->

<div id="boxTableNone">

    <script type="text/html" id="toolbarHtml">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
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
            lists: {href: "<?php echo url('admin/sys_article/lists'); ?>", title: '列表'},
            edit: {href: "<?php echo url('admin/sys_article/edit'); ?>", title: '编辑'},
        };
        tablelistobj.cols = [[
            {field: 'id', width: 80, title: 'ID', sort: true},
            {field: 'title', title: '名称'},
            {field: 'content', title: '内容'},
            {field: '', title: '操作', align: 'center', toolbar: '#toolbarHtml', width: 150}
        ]];
        tablelistobj.render(table);
        //搜索表单
        tablelistobj.search(table, form);
        //操作按钮
        tablelistobj.form_width = 1000;
        tablelistobj.form_height = 700;
        tablelistobj.tool(table, layer);
        //头工具栏事件
        tablelistobj.toolbar(table, layer);
    });
</script>

</body>
</html>