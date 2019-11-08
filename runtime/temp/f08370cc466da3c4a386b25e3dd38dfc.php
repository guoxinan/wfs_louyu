<?php /*a:4:{s:55:"D:\project\vfs_bms\application\admin\view\news\add.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\layout\main.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\inc\header.html";i:1573005997;s:56:"D:\project\vfs_bms\application\admin\view\news\form.html";i:1573110718;}*/ ?>
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
        <label class="layui-form-label">新闻标题</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" lay-verify="required" placeholder="标题">
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">新闻分类</label>
        <div class="layui-input-inline">
            <select name="one" id="selectOne" lay-filter="selectOne">
                <option value="">请选择</option>
                <?php if(is_array($one_list) || $one_list instanceof \think\Collection || $one_list instanceof \think\Paginator): $i = 0; $__LIST__ = $one_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo htmlentities($vo['id']); ?>"><?php echo htmlentities($vo['title']); ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
        <div class="layui-input-inline">
            <select name="cate_id" id="cateId" lay-filter="cateId" lay-verify="required">
                <option value="">请选择</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">房间配置</label>
        <div class="layui-input-block">
            <input type="checkbox" name="homeset" title="WIFI" />
            <input type="checkbox" name="homeset" title="床" />
            <input type="checkbox" name="homeset" title="衣柜" />
            <input type="checkbox" name="homeset" title="沙发" />
            <input type="checkbox" name="homeset" title="空调" />
            <input type="checkbox" name="homeset" title="洗衣机" />
            <input type="checkbox" name="homeset" title="电视机" />
            <input type="checkbox" name="homeset" title="电磁炉" />
            <input type="checkbox" name="homeset" title="床头柜" />
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">缩略图</label>
        <div class="layui-input-inline">
            <div id="uploadElem" data-type="news_banner" data-done="banner">
                <div class="layui-upload-list thumbBox mag0 magt3">
                    <img id="uploadImg" class="layui-upload-img thumbImg">
                </div>
            </div>
        </div>
        <input type="hidden" name="banner" value="" id="uploadImgId" lay-verify="required">
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">简介</label>
        <div class="layui-input-inline">
            <textarea name="description" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">详情</label>
        <div class="layui-input-block">
            <script id="content" name="content" type="text/plain"></script>
        </div>
    </div>

    <div class="layui-form-item layui-row layui-col-xs12">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="orderby" class="layui-input" lay-verify="required" placeholder="排序">
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

<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    //编辑器
    var ue = UE.getEditor('content', {
        autoFloatEnabled: true,
        initialFrameWidth: 600,
        initialFrameHeight: 400,
    });
</script>

<script>
    var form_obj = {
        formFilter: 'formFilter',
        formSubmit: 'formSubmit',
        get_select_cateId_html: function ($data) {
            var html = '<option value="">请选择</option>';
            $.each($data, function (i, n) {
                html += '<option value="' + n.id + '">' + n.title + '</option>';
            })
            return html;
        },
        select_one_change: function (url) {
            var that = this;
            var formFilter = that.formFilter;
            layui.form.on('select(selectOne)', function (data) {
                var value = data.value;
                if (value === '') {
                    $('#cateId').html('');
                } else {
                    $.post(url, {pid: value}, function (res) {
                        var data = res.data;
                        var html = that.get_select_cateId_html(data);
                        $('#cateId').html(html);
                        layui.form.render('select', formFilter);
                    }, 'json');
                }
            });
        },
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
                        $('#uploadImg').attr('src', info.banner_url);
                        info.status = info.status.toString();

                        if (info.cate_list) {
                            var cate_list = info.cate_list;
                            var html = that.get_select_cateId_html(cate_list);
                            $('#cateId').html(html);
                        }
                        layui.form.val(formFilter, info);
                        ue.setContent(info.content);
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
    layui.use(['form', 'layer', 'upload'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var upload = layui.upload;
        var url_insert = "<?php echo url('admin/news/insert'); ?>";
        var url_update = "<?php echo url('admin/news/update'); ?>";
        var url_upload = "<?php echo url('admin/ajax/upload'); ?>";
        var url_cate_son = "<?php echo url('admin/news_cate/sonList'); ?>";
        var url_info = "<?php echo url('admin/news/info'); ?>";
        var id = "<?php echo htmlentities((app('request')->get('id') ?: 0)); ?>";
        var postData = {id:id};
        //对页面数据进行初始化
        form_obj.init(url_info, postData, form);
        //监听提交
        var url_form = url_insert;
        if(id > 0){
            url_form = url_update;
        }
        form_obj.submit(url_form);
        //选择分类
        form_obj.select_one_change(url_cate_son);
        //上传图片
        //upload_obj.init('uploadElem', url_upload);
        //upload_obj.init('uploadElemCover', url_upload);
        //upload_obj.init_multiple('uploadElemCarousel', url_upload);
       // upload_obj.carousel_del();
    });
</script>


<script>
    layui.use(['form', 'layer', 'upload'], function () {
        $ = layui.jquery;
        var form = layui.form;
        var layer = layui.layer;
        var upload = layui.upload;
        var url_insert = "<?php echo url('admin/news/insert'); ?>";
        var url_update = "<?php echo url('admin/news/update'); ?>";
        var url_upload = "<?php echo url('admin/ajax/upload'); ?>";
        var url_info = "<?php echo url('admin/news/info'); ?>";
        var id = "<?php echo htmlentities((app('request')->get('id') ?: 0)); ?>";
        var postData = {id:id};
        //对页面数据进行初始化
        form_obj.init(url_info, postData, form);
        //监听提交
        form_obj.submit(url_insert);
        //上传图片
        upload_obj.init('uploadElem', url_upload);
    });
</script>

</body>
</html>