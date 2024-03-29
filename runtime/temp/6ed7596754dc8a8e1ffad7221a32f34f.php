<?php /*a:4:{s:69:"D:\worker\phpstudy\WWW\qiyezhan\application\admin\view\excel\add.html";i:1569209975;s:71:"D:\worker\phpstudy\WWW\qiyezhan\application\admin\view\layout\main.html";i:1568194890;s:70:"D:\worker\phpstudy\WWW\qiyezhan\application\admin\view\inc\header.html";i:1568194890;s:70:"D:\worker\phpstudy\WWW\qiyezhan\application\admin\view\excel\form.html";i:1569211978;}*/ ?>
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
        <label class="layui-form-label">导入的文件</label>
        <div class="layui-input-block" id="uploadElem" data-type="file" data-done="file">
            <input type="file" name="file" value="">
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
                var index = parent.layer.getFrameIndex(window.name);
                parent.layer.close(index);
                parent.location.reload();
            }, times)
        }
    };
</script>
<script>
    layui.use(['form', 'layer','upload'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var upload = layui.upload;
        var url_insert = "<?php echo url('admin/excel/insert'); ?>";
        var url_update = "<?php echo url('admin/excel/update'); ?>";
        var url_upload = "<?php echo url('admin/excel/upload'); ?>";
        var url_info = "<?php echo url('admin/excel/info'); ?>";

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
        //上传文件
        upload_obj.init('uploadElem', url_upload);
    });
    ///你饿不饿  吃饭去吧 在吗
</script>


</body>
</html>