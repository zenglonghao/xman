<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/Public/static/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/Public/static/css/jquery.toast.min.css" media="all"/>
    <link rel="stylesheet" href="/Public/static/css/index.css" media="all"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_798193_ew7wixsziw8.css" media="all"/>
    <link rel="stylesheet" href="/Public/static/js/nprogress/nprogress.css" media="all"/>
    <script type="text/javascript" src="/Public/static/js/nprogress/nprogress.js"></script>
    <link rel="stylesheet" href="/Public/static/css/custom.css" media="all"/>
    <?php echo ($style); ?>
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
    <!-- 顶部 -->
    <div class="layui-header header">
        <div class="layui-main mag0">
            <a href="#" class="logo">X-Man</a>
            <!-- 显示/隐藏菜单 -->
            <a href="javascript:;" class="hideMenu">
                <i class="layui-icon layui-icon-shrink-right"></i>
            </a>
            <!-- 顶级菜单 -->
            <ul class="layui-nav mobileTopLevelMenus" mobile>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="iconfont xman-menu"></i><cite>菜单</cite></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k; if($k == 1): ?><dd class="layui-this" data-menu="<?php echo ($v["id"]); ?>">
                                    <a href="javascript:void(0);">
                                        <i class="<?php echo ($v["icon"]); ?>"></i>
                                        <cite><?php echo ($v["name"]); ?></cite>
                                    </a>
                                </dd>
                                <?php else: ?>
                                <dd data-menu="<?php echo ($v["id"]); ?>">
                                    <a href="javascript:void(0);">
                                        <i class="<?php echo ($v["icon"]); ?>"></i>
                                        <cite><?php echo ($v["name"]); ?></cite>
                                    </a>
                                </dd><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
            </ul>
            <ul class="layui-nav topLevelMenus" pc>
                <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k; if($k == 1): ?><li class="layui-nav-item layui-this" data-menu="<?php echo ($v["id"]); ?>">
                            <a href="javascript:void(0);">
                                <i class="<?php echo ($v["icon"]); ?>"></i>
                                <cite><?php echo ($v["name"]); ?></cite>
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="layui-nav-item" data-menu="<?php echo ($v["id"]); ?>">
                            <a href="javascript:void(0);">
                                <i class="<?php echo ($v["icon"]); ?>"></i>
                                <cite><?php echo ($v["name"]); ?></cite>
                            </a>
                        </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <!-- 顶部右侧菜单 -->
            <ul class="layui-nav top_menu">
                <li class="layui-nav-item" data-minfo="清除缓存" pc>
                    <a href="javascript:;" class="clearCache"><i class="layui-icon"
                            data-icon="&#xe640;">&#xe640;</i></a>
                </li>
                <li class="layui-nav-item fullscreen" data-minfo="全屏" pc>
                    <a href="javascript:;"><i class="iconfont xman-fullscreen"></i></a>
                </li>
                <li class="layui-nav-item" id="userInfo">
                    <a href="javascript:;"><img src="/Public/static/images/face.png" class="layui-nav-img userAvatar"
                            width="35" height="35"><cite class="adminName"><?php echo ($user["nickname"]); ?></cite></a>
                    <dl class="layui-nav-child">
                        <!--							<dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="seraph icon-ziliao" data-icon="icon-ziliao"></i><cite>个人资料</cite></a></dd>-->
                        <dd><a href="javascript:;" data-url="/admin/index/changepass"><i class="iconfont xman-edit-square"
                                data-icon="iconfont xman-edit-square"></i><cite>修改密码</cite></a></dd>
                        <dd><a href="javascript:;" class="showNotice"><i class="iconfont xman-sound"
                                data-icon="iconfont xman-sound"></i><cite>系统公告</cite></a></dd>
                        <dd pc><a href="javascript:;" class="functionSetting"><i class="iconfont xman-setting"></i><cite>功能设定</cite><span
                                class="layui-badge-dot"></span></a></dd>
                        <dd pc><a href="javascript:;" class="changeSkin"><i
                                class="iconfont xman-skin"></i><cite>更换皮肤</cite><span class="layui-badge-dot"></span></a></dd>
                        <dd><a href="/admin/login/logout" class="signOut"><i
                                class="iconfont xman-logout"></i><cite>退出</cite></a></dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
    <!-- 左侧导航 -->
    <div class="layui-side layui-bg-black">
        <div class="layui-form component" style="margin:10px;">
            <select name="search" id="search" lay-search lay-filter="searchPage">
                <option value="">搜索导航</option>
            </select>
            <i class="layui-icon">&#xe615;</i>
        </div>
        <div class="navBar layui-side-scroll" id="navBar" style="border-bottom: 1px dashed #454545">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item layui-this">
                    <a href="javascript:;" data-url="/Public/static/page/main.html"><i class="layui-icon" data-icon=""></i><cite>后台首页</cite></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- 右侧内容 -->
    <div class="layui-body layui-form">
        <div class="layui-tab mag0" lay-filter="bodyTab" id="top_tabs_box">
            <ul class="layui-tab-title top_tab" id="top_tabs">
                <li class="layui-this" lay-id=""><i class="layui-icon">&#xe68e;</i> <cite>后台首页</cite></li>
            </ul>
            <ul class="layui-nav closeBox">
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon caozuo">&#xe643;</i> 页面操作</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" class="refresh refreshThis"><i
                                class="layui-icon layui-icon-refresh"></i> 刷新当前</a></dd>
                        <dd><a href="javascript:;" class="closePageOther"><i class="layui-icon layui-icon-close"></i> 关闭其他</a>
                        </dd>
                        <dd><a href="javascript:;" class="closePageAll"><i class="iconfont xman-close-square-fill"></i> 关闭全部</a>
                        </dd>
                    </dl>
                </li>
            </ul>
            <div class="layui-tab-content clildFrame">
                <div class="layui-tab-item layui-show">
                    <iframe src="<?php echo U('Index/main');?>"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- 底部 -->
    <div class="layui-footer footer" style="border-top:1px solid #dedede">
        <p><span>copyright @<?php echo date('Y');?> Xiny</span></p>
    </div>
</div>

<!--右键菜单 start-->
<ul class="ul-context-menu"
        style="position: absolute; text-align: center; width: 110px; background-color: rgb(51, 51, 51); display: none;z-index: 1000;">
    <li class="ui-context-menu-item">
        <a href="javascript:void(0);" class="refresh refreshThis">
            <i class="layui-icon layui-icon-refresh"></i>
            <span style="">刷新当前</span>
        </a>
    </li>
    <li class="ui-context-menu-item">
        <a href="javascript:void(0);" class="whoShow">
            <i class="layui-icon"></i>
            <span style="">关闭当前</span>
        </a>
    </li>
    <li class="ui-context-menu-item">
        <a href="javascript:void(0);" class="closePageOther">
            <i class="layui-icon layui-icon-close"></i>
            <span style="">关闭其他</span>
        </a>
    </li>
    <li class="ui-context-menu-item">
        <a href="javascript:void(0);" class="closePageAll">
            <i class="iconfont xman-close-square"></i>
            <span style="">关闭全部</span>
        </a>
    </li>
</ul>
<!--右键菜单 end-->
<!--皮肤更换-->
<div id="skinbox" style="display: none">
    <div class="layui-row">
        <div class="layui-col-md12">
            <form action="" lay-filter="form1" class="layui-form" style="width: 90%;padding: 5%;">
                <div class="layui-form-item">
                    <div class="layui-inline">
                    <label class="layui-form-label">
                        框架颜色
                    </label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline" style="width: 140px;">
                            <input type="text"  placeholder="请选择颜色" class="layui-input color" id="framecolor" name="framecolor" title="" value="#01AAED" data-class=".layui-nav-tree .layui-nav-child dd.layui-this, .layui-nav-tree .layui-nav-child dd.layui-this a, .layui-nav-tree .layui-this, .layui-nav-tree .layui-this > a, .layui-nav-tree .layui-this > a:hover, .hideMenu, .layui-nav-tree .layui-nav-bar, .layui-nav-itemed:before, .layui-nav .layui-nav-child dd.layui-this a, .layui-nav-child dd.layui-this,#nprogress .bar" data-imp="" data-other="1">
                        </div>
                        <div class="layui-inline" style="left: -11px;">
                            <div id="framecolor_show" class="layui-inline">
                            </div>
                        </div>
                        <!--<input type="color" name="framecolor" title="" value="#01AAED" data-class=".layui-nav-tree .layui-nav-child dd.layui-this, .layui-nav-tree .layui-nav-child dd.layui-this a, .layui-nav-tree .layui-this, .layui-nav-tree .layui-this > a, .layui-nav-tree .layui-this > a:hover, .hideMenu, .layui-nav-tree .layui-nav-bar, .layui-nav-itemed:before, .layui-nav .layui-nav-child dd.layui-this a, .layui-nav-child dd.layui-this" data-imp="" data-other="1" class="layui-input">-->
                    </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">
                            顶部背景
                        </label>
                        <div class="layui-input-block">
                            <!--<input type="color" name="topcolor" >-->
                            <div class="layui-input-inline" style="width: 140px;">
                                <input type="text"  placeholder="请选择颜色" class="layui-input color" id="topcolor" name="topcolor" title="" data-class=".layui-layout-admin .layui-header" data-imp="" value="#23262E">
                            </div>
                            <div class="layui-inline" style="left: -11px;">
                                <div id="topcolor_show" class="layui-inline">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                    <label class="layui-form-label">
                        左侧背景
                    </label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline" style="width: 140px;">
                            <input type="text"  placeholder="请选择颜色" class="layui-input color" id="leftcolor" name="leftcolor" title="" data-class=".layui-bg-black" data-imp="1"  value="#393D49">
                        </div>
                        <div class="layui-inline" style="left: -11px;">
                            <div id="leftcolor_show" class="layui-inline">
                            </div>
                        </div>
                        <!--<input type="color" name="leftcolor" title="" value="#393D49" data-class=".layui-bg-black" data-imp="1" class="layui-input">-->
                    </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">
                            底边选中
                        </label>
                        <div class="layui-input-block">
                            <!--<input type="color" name="topbottomcolor" title="" value="#FFD700" data-class=".layui-nav .layui-this:after, .layui-nav-bar, .layui-nav-tree .layui-nav-itemed:after" data-imp="" class="layui-input">-->
                            <div class="layui-input-inline" style="width: 140px;">
                                <input type="text"  placeholder="请选择颜色" class="layui-input color" id="topbottomcolor" name="topbottomcolor" title="" data-class=".layui-nav .layui-this:after, .layui-nav-bar, .layui-nav-tree .layui-nav-itemed:after" data-imp=""  value="#FFd700">
                            </div>
                            <div class="layui-inline" style="left: -11px;">
                                <div id="topbottomcolor_show" class="layui-inline">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">
                        三级菜单
                    </label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline" style="width: 140px;">
                            <input type="text"  placeholder="请选择颜色" class="layui-input color" id="menucolor" name="menucolor" title="" data-class=".layui-nav-item.layui-nav-itemed" data-imp="1"  value="#2b2e37">
                        </div>
                        <div class="layui-inline" style="left: -11px;">
                            <div id="menucolor_show" class="layui-inline">
                            </div>
                        </div>
                        <!--<input type="color" name="menucolor" title="" value="#2B2E37" data-class=".layui-nav-item.layui-nav-itemed" data-imp="1" class="layui-input">-->
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">内置皮肤</label>
                    <div class="layui-input-block system_skin_list">
                       <!-- <button class="layui-btn layui-btn-sm">主题1</button>
                        <button class="layui-btn layui-btn-sm">主题2</button>
                        <button class="layui-btn layui-btn-sm">主题3</button>-->
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <a class="layui-btn makeSkin">制作专属皮肤</a>
                        <a class="layui-btn layui-btn-primary defaultSkin">清除皮肤</a>
                    </div>
                </div>
                <!--<div class="layui-form-item">
                    <label class="layui-form-label">
                        顶部选中
                    </label>
                    <div class="layui-input-block">
                        <input type="color" title="" value="#595963" data-class=".topLevelMenus .layui-nav-item.layui-this a" data-imp="" class="layui-input">
                    </div>
                </div>-->
            </form>
        </div>
    </div>
</div>
<!-- 移动导航 -->
<div class="site-tree-mobile"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>
<script type="text/javascript" src="/Public/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/static/js/jquery.toast.min.js"></script>
<script type="text/javascript" src="/Public/static/js/alert.js"></script>
<script type="text/javascript" src="/Public/static/layui/layui.js"></script>
<script type="text/javascript" src="/Public/static/js/index.js"></script>
<script type="text/javascript" src="/Public/static/js/cache.js"></script>
<script type="text/javascript">
    NProgress.start();
    window.onload = function () {
        NProgress.done();
        getData($('.layui-nav-item .layui-this').data('menu'));
        $(".fullscreen").toggle(function () {
            full();
            $(this).data('minfo','退出全屏').find('i').removeClass('xman-fullscreen').addClass('xman-fullscreen-exit');
        }, function () {
            exitfull();
            $(this).data('minfo','全屏').find('i').removeClass('xman-fullscreen-exit').addClass('xman-fullscreen');
        });
        let timerSoll;
        $('#navBar').on('mouseleave', function(){
            //console.log('ffff');
            let that=this;
            /*clearTimeout(timerSoll);
            timerSoll=setTimeout(function(){*/
                $(that).css('width',220);
            /*},3000);*/
        }).on('mouseenter', function(){
           /* clearTimeout(timerSoll);*/
            $(this).css('width',210);
        });
    };
    layui.use(['layer','colorpicker'], function () {
        let layer = layui.layer;
        let colorpicker = layui.colorpicker;


        $(".color").on('change',function(){
            let _this = $(this);
            let id = _this.prop('id');
            if (id) {
                colorpicker.render({
                    elem: '#' + id + '_show'
                    ,color: _this.val()
                    ,change: function(color){
                        $('#' + id).val(color).change();
                    }
                    ,done: function(color){
                        $('#' + id).val(color).change();
                    }
                });
            }

            let cssStr = '';
            $(".color").each(function(index,n){
                let dom = $(n);
                cssStr += dom.data('class') + "{ background-color: "+dom.val();
                if (dom.data('imp')) {
                    cssStr += "!important;}" + "\n\r";
                } else {
                    cssStr += "}" + "\n\r";
                }
                if (dom.data('other')) {
                    cssStr += ".layui-tab-title .layui-this {color: " + dom.val() + ";border-bottom: 1px solid " + dom.val() +";}\n\r.layui-body {border-top: 5px solid " + dom.val() + ";}\n\r.layui-nav .layui-nav-child a:hover,.ui-context-menu-item a:hover{background-color: "+ dom.val() +";}\n\r.layui-nav .layui-nav-child a:hover, .layui-nav .layui-nav-child dd.layui-this a:hover{background-color: "+ dom.val() +"}\n\r.topLevelMenus .layui-nav-item.layui-this a{background-color: "+ dom.val() +"}\n\r#nprogress .spinner-icon{border-left-color:"+ dom.val() +";border-top-color:"+ dom.val() +";}\n\r#nprogress .peg{box-shadow: 0 0 10px "+ dom.val() +", 0 0 5px "+ dom.val() +";}";
                }
            });
            let head = $("head");
            head.find('style').remove();
            head.append("<style type='text/css'>" +cssStr+ "</style>");
        });
        let intips = '';
        $("li[data-minfo]").hover(function () {
            intips = layer.tips($(this).data('minfo'), $(this), {tips: [3, '#424242']});
        }, function () {
            layer.close(intips);
        });
        let topmenu = $("#top_tabs_box");
        $("body").on('mousedown', '#top_tabs_box li', function (e) {
            if (3 === e.which) {
                $(this).click();
                e = e || window.event;
                let xx = e.pageX || e.clientX + document.body.scroolLeft;
                let yy = e.pageY || e.clientY + document.body.scrollTop;
                /*let xx = e.originalEvent.x || e.originalEvent.layerX || 0;
                let yy = e.originalEvent.y || e.originalEvent.layerY || 0;*/
                menu1.css({'left': xx - 5, 'top': yy - 5}).show();
                $(document).one('click', '.ui-context-menu-item', function () {
                    menu1.hide();
                });
            }
        });
        topmenu.unbind("mousedown").bind("contextmenu", function (e) {
            e.preventDefault();
            return false;
        });
        let menu1 = $(".ul-context-menu");
        menu1.unbind("mousedown").bind("contextmenu", function (e) {
            e.preventDefault();
            return false;
        });
        let timer;
        menu1.on('mouseleave', function () {
            if ($(this).css('display') === 'none') {
                return false;
            }
            timer = setTimeout(function () {
                menu1.hide();
            }, 1000);
        });
        menu1.on('mouseenter', function () {
            if ($(this).css('display') === 'none') {
                return false;
            }
            if (timer) {
                clearTimeout(timer);
            }
        });
        topmenu.mousedown(function (e) {
            if (3 === e.which) {
                e = e || window.event;
                let xx = e.pageX || e.clientX + document.body.scroolLeft;
                let yy = e.pageY || e.clientY + document.body.scrollTop;
                menu1.css({'left': xx - 5, 'top': yy - 5}).show();
                $(document).one('click', '.ui-context-menu-item', function () {
                    menu1.hide();
                });
            }
            //return false;//阻止链接跳转
        });
        $(".whoShow").on('click', function () {
            let frame = $(".clildFrame .layui-tab-item.layui-show").find("iframe")[0];
            let id = $(frame).data('id');
            if (typeof id === "undefined") {
                return layer.msg('首页不可关闭');
            }
            $("i[data-id=" + id + "]").click();
        });
        $("input[type=color]").on('change',function(){
            let cssStr = '';
            $("input[type=color]").each(function(index,n){
                let dom = $(n);
                cssStr += dom.data('class') + "{ background-color: "+dom.val();
                if (dom.data('imp')) {
                    cssStr += "!important;}" + "\n\r";
                } else {
                    cssStr += "}" + "\n\r";
                }
                if (dom.data('other')) {
                    cssStr += ".layui-tab-title .layui-this {color: " + dom.val() + ";border-bottom: 1px solid " + dom.val() +";}\n\r.layui-body {border-top: 5px solid " + dom.val() + ";}\n\r.layui-nav .layui-nav-child a:hover,.ui-context-menu-item a:hover{background-color: "+ dom.val() +";}\n\r.layui-nav .layui-nav-child a:hover, .layui-nav .layui-nav-child dd.layui-this a:hover{background-color: "+ dom.val() +"}\n\r.topLevelMenus .layui-nav-item.layui-this a{background-color: "+ dom.val() +"}\n\r";
                }
            });
            let head = $("head");
            head.find('style').remove();
            head.append("<style type='text/css'>" +cssStr+ "</style>");
        });
        $(".makeSkin").on('click',function(){
            let i = layer.msg('制作中..',{'icon':16,time:false});
            $.post("/admin/index/makeSkin",{'paras':$('form').serialize()},function(data){
                layer.close(i);
                if (0 === data.code){
                    layer.closeAll();
                    layer.msg(data.info,{'icon':1});
                } else {
                    layer.msg(data.info,{'icon':2});
                }

            });
        });
        $(".defaultSkin").on('click',function(){
            let i = layer.msg('制作中..',{'icon':16,time:false});
            $.post("/admin/index/defaultSkin",function(data){
                layer.close(i);
                if(data.code === 0){
                    layer.closeAll();
                    $('head').find('style').remove();
                    layer.msg(data.info,{'icon':1});
                } else {
                    layer.msg(data.info,{'icon':2});
                }

            });
        });

    });

</script>
</body>
</html>