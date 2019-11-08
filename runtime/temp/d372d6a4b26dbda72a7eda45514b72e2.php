<?php /*a:1:{s:58:"D:\project\vfs_bms\application\admin\view\login\login.html";i:1573005997;}*/ ?>
<!DOCTYPE html>
<html class="loginHtml">
<head>
    <meta charset="utf-8">
    <title>登录--采购总后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/static/admin/css/public.css" media="all"/>
</head>
<body class="loginBody">
<form class="layui-form">
    <div class="login_face"><img src="/static/admin/images/face.jpg" class="userAvatar"></div>
    <div class="layui-form-item input-item input_j">
        <label>用户名</label>
        <input type="text" placeholder="请输入用户名" autocomplete="off" name="username" class="layui-input lay_j" lay-verify="required">
    </div>
    <div class="layui-form-item input-item">
        <label>密码</label>
        <input type="password" placeholder="请输入密码" autocomplete="off" name="password" class="layui-input lay_j" lay-verify="required">
    </div>
    <div class="layui-form-item input-item" id="imgCode">
        <label>验证码</label>
        <input type="text" placeholder="请输入验证码" autocomplete="off" name="code" class="layui-input lay_j" lay-verify="required">
        <img id="verify" src="<?php echo url('admin/login/verify'); ?>" width="180" height="59">
    </div>
    <div class="layui-form-item">
        <button class="layui-btn layui-block block_j" lay-filter="login" lay-submit>登录</button>
    </div>
</form>
<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript">
    layui.use(['form', 'jquery'], function () {
        var $ = layui.jquery;
        var form = layui.form;
        //监听提交
        form.on('submit(login)', function (data) {
            var url = "<?php echo url('admin/login/login'); ?>";
            var formData = data.field;
            //$(this).text("登录中...").attr("disabled", "disabled").addClass("layui-disabled");
            $.post(url, formData, function (res) {
                layer.msg(res.message);
                if (res.code === 0) {
                    window.location.href = res.url;
                } else {
                    change_verify();
                }
            }, 'json')
            return false;
        });
        $('#verify').click(function () {
            change_verify();
        });
        function change_verify() {
            var src = "<?php echo url('admin/login/verify'); ?>?seed="+ Math.random();
            $('#verify').attr('src', src);
        }
    });

</script>
</body>
</html>