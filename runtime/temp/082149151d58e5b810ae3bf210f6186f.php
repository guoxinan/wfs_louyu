<?php /*a:4:{s:59:"D:\project\vfs_bms\application\admin\view\wechat\index.html";i:1573005998;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\wechat\form.html";i:1573005998;}*/ ?>
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
        <label class="layui-form-label">公众号名称</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" lay-verify="required" placeholder="名称">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">缩略图</label>
        <div class="layui-input-inline">
            <div id="uploadElem" data-type="img_url" data-done="img_url">
                <div class="layui-upload-list thumbBox mag0 magt3">
                    <img id="uploadImg" class="layui-upload-img thumbImg">
                </div>
            </div>
        </div>
        <input type="hidden" name="img_id" value="" id="uploadImgId" lay-verify="required">
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">Appid</label>
        <div class="layui-input-block">
            <input type="text" name="appid" class="layui-input" lay-verify="required" placeholder="请输入Appid">
        </div>
    </div>
    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">AppSecret</label>
        <div class="layui-input-block">
            <input type="text" name="secret" class="layui-input" lay-verify="required" placeholder="请输入AppSecret">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">URL(服务器地址)</label>
        <div class="layui-input-block">
            <input type="text" name="service_url" class="layui-input" lay-verify="required" placeholder="请输入URL">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">Token(令牌)</label>
        <div class="layui-input-inline">
            <input type="text" name="token" class="layui-input" lay-verify="required" placeholder="请输入Token">
        </div>
    </div>


    <input type="hidden" id="id" name="id" value="">
    <div class="layui-form-item layui-row layui-col-xs12">
        <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-sm" lay-submit="" lay-filter="formSubmit">确定</button>
        </div>
    </div>
</form>

<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>



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
                        $('#uploadImg').attr('src', info.img_url);
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
    var upload_obj = {
        init: function (id, url) {
            var that = this;
            var elem = '#' + id;
            var type = $(elem).data('type');
            var done = $(elem).data('done');
            layui.upload.render({
                elem: elem,
                url: url,
                data: {type: type},
                done: function (res) {
                    var message = res.message;
                    if (res.code === 0) {
                        layer.msg(message, {icon: 1, time: 2000});
                        var data = res.data;
                        that.callback(data, done);
                    } else {
                        layer.msg(message, {icon: 2, time: 2000});
                    }
                }
            });
        },
        callback: function (data, done) {
            var that = this;
            var done = done || 'default';
            if (done == 'default') {
                $('#uploadImg').attr('src', data.fileurl);
                $('#uploadImgId').val(data.id);
            } else {
                $('#uploadImg').attr('src', data.fileurl);
                $('#uploadImgId').val(data.id);
            }
        },
    };
    var layer_obj = {
        close: function (times) {
            setTimeout(function () {
                window.location.reload();
            }, times)
        }
    };
</script>


<script>
    layui.use(['form', 'layer', 'upload'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var upload = layui.upload;
        var url_insert = "<?php echo url('admin/wechat/insert'); ?>";
        var url_update = "<?php echo url('admin/wechat/update'); ?>";
        var url_upload = "<?php echo url('admin/ajax/upload'); ?>";
        var url_info = "<?php echo url('admin/wechat/info'); ?>";
        var postData = {id:1};
        //对页面数据进行初始化
        form_obj.init(url_info, postData, form);
        //监听提交
        form_obj.submit(url_update);
        //上传图片
        upload_obj.init('uploadElem', url_upload);
    });
</script>

</body>
</html>