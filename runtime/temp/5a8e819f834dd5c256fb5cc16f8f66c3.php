<?php /*a:5:{s:58:"D:\project\vfs_bms\application\admin\view\index\index.html";i:1573005997;s:56:"D:\project\vfs_bms\application\admin\view\index\top.html";i:1573005997;s:57:"D:\project\vfs_bms\application\admin\view\index\left.html";i:1573005997;s:58:"D:\project\vfs_bms\application\admin\view\index\right.html";i:1573005997;s:59:"D:\project\vfs_bms\application\admin\view\index\bottom.html";i:1573005997;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>企业后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/static/admin/css/index.css" media="all"/>
    <link rel="stylesheet" href="/static/admin/css/font_400842_q6tk84n9ywvu0udi.css" media="all" />
</head>
<body class="main_body" style="min-width:1200px;">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header">
    <div class="layui-main mag0">
        <a href="javascript:void(0);" class="logo">企业后台</a>
        <!-- 显示/隐藏菜单 -->
        <a href="javascript:;" class="seraph hideMenu icon-caidan"></a>
        <!-- 顶级菜单 -->
        <ul class="layui-nav mobileTopLevelMenus" mobile>
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="seraph icon-caidan"></i><cite>菜单列表</cite></a>
                <dl class="layui-nav-child">
                    <?php if(is_array($top_node_list) || $top_node_list instanceof \think\Collection || $top_node_list instanceof \think\Paginator): $k = 0; $__LIST__ = $top_node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k == 1): ?>
                    <dd data-menu="<?php echo htmlentities($vo['alias']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" data-title="<?php echo htmlentities($vo['title']); ?>">
                        <?php else: ?>
                    <dd class="layui-this" data-menu="<?php echo htmlentities($vo['alias']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" data-title="<?php echo htmlentities($vo['title']); ?>">
                        <?php endif; ?>
                        <a href="javascript:;">
                            <i class="layui-icon" data-icon="icon-icon10"></i>
                            <cite><?php echo htmlentities($vo['title']); ?></cite>
                        </a>
                    </dd>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav topLevelMenus" pc>
            <?php if(is_array($top_node_list) || $top_node_list instanceof \think\Collection || $top_node_list instanceof \think\Paginator): $k = 0; $__LIST__ = $top_node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;if($k == 1): ?>
            <li class="layui-nav-item layui-this" pc data-menu="<?php echo htmlentities($vo['alias']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" data-title="<?php echo htmlentities($vo['title']); ?>">
                <?php else: ?>
            <li class="layui-nav-item" pc data-menu="<?php echo htmlentities($vo['alias']); ?>" data-id="<?php echo htmlentities($vo['id']); ?>" data-title="<?php echo htmlentities($vo['title']); ?>">
                <?php endif; ?>
                <a href="javascript:;">
                    <i class="layui-icon" data-icon="icon-icon10"></i>
                    <cite><?php echo htmlentities($vo['title']); ?></cite>
                </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- 顶部右侧菜单 -->
        <ul class="layui-nav top_menu">
            <li class="layui-nav-item" pc>
                <a href="javascript:;" class="clearCache"><i class="layui-icon" data-icon="&#xe640;">&#xe640;</i><cite>清除缓存</cite><span
                        class="layui-badge-dot"></span></a>
            </li>
            <li class="layui-nav-item" id="userInfo">
                <a href="javascript:;">
                    <img src="/static/admin/images/face.jpg" class="layui-nav-img userAvatar" width="35" height="35">
                    <cite class="adminName"><?php echo session('admin.username'); ?></cite>
                </a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="<?php echo url('admin/admin/detail'); ?>">
                            <i class="seraph icon-ziliao" data-icon="icon-ziliao"></i><cite>个人资料</cite>
                        </a>
                    </dd>
                    <dd>
                        <a href="javascript:;" data-url="<?php echo url('admin/admin/password'); ?>">
                            <i class="seraph icon-xiugai" data-icon="icon-xiugai"></i><cite>修改密码</cite>
                        </a>
                    </dd>
                    <dd pc>
                        <a href="javascript:;" class="changeSkin">
                            <i class="layui-icon">&#xe61b;</i><cite>更换皮肤</cite>
                        </a>
                    </dd>
                    <dd>
                        <a href="<?php echo url('admin/login/logout'); ?>" class="signOut">
                            <i class="seraph icon-tuichu"></i><cite>退出</cite>
                        </a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>
    <div class="layui-side layui-bg-black">
    <div class="user-photo">
        <a class="img" title="我的头像" ><img src="/static/admin/images/face.jpg" class="userAvatar"></a>
        <p>你好！<span class="userName"><?php echo session('admin.username'); ?></span>, 欢迎登录</p>
    </div>
    <div class="navBar layui-side-scroll" id="navBar">
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item layui-this">
                <a href="javascript:;" data-url="<?php echo url('admin/index/home'); ?>">
                    <i class="layui-icon" data-icon=""></i><cite>后台首页</cite>
                </a>
            </li>
        </ul>
    </div>
</div>
    <div class="layui-body layui-form">
    <div class="layui-tab" lay-filter="bodyTab" id="top_tabs_box" style="margin: 0;">
        <ul class="layui-tab-title top_tab" id="top_tabs">
            <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>后台首页</cite></li>
        </ul>
        <ul class="layui-nav closeBox">
            <li class="layui-nav-item">
                <a href="javascript:;"><i class="layui-icon caozuo">&#xe643;</i> 页面操作</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;" class="refresh refreshThis"><i class="layui-icon">&#x1002;</i> 刷新当前</a></dd>
                    <dd><a href="javascript:;" class="closePageOther"><i class="seraph icon-prohibit"></i> 关闭其他</a></dd>
                    <dd><a href="javascript:;" class="closePageAll"><i class="seraph icon-guanbi"></i> 关闭全部</a></dd>
                </dl>
            </li>
        </ul>
        <div class="layui-tab-content clildFrame">
            <div class="layui-tab-item layui-show">
                <iframe src="<?php echo url('admin/index/home'); ?>"></iframe>
            </div>
        </div>
    </div>
</div>
    <div class="layui-footer footer">
    <p>
        <span><?php echo htmlentities((isset($config_arr['copyright']) && ($config_arr['copyright'] !== '')?$config_arr['copyright']:'copyright @2019 微风尚')); ?></span>
    </p>
</div>
</div>

<!-- 一些隐藏元素, 供js使用 -->
<div style="display: none;">
    <input type="hidden" id="urlLeftNodeList" value="<?php echo url('admin/node/leftAll'); ?>">
    <input type="hidden" id="urlCacheClear" value="<?php echo url('admin/ajax/cacheClear'); ?>">
    <input type="hidden" id="topFirstId" value="<?php echo htmlentities($top_first_id); ?>">
</div>

<!-- 移动导航 -->
<div class="site-tree-mobile"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

<script type="text/javascript" src="/static/admin/layui/layui.js"></script>
<script type="text/javascript" src="/static/admin/js/index.js"></script>
<script type="text/javascript" src="/static/admin/js/cache.js"></script>

</body>
</html>
