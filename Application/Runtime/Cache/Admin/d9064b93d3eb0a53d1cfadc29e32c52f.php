<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>添加</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/Public/static/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/Public/static/layui/iconpick.css" media="all" />
    <link rel="stylesheet" href="/Public/static/css/public.css" media="all" />
    <link rel="stylesheet" href="//at.alicdn.com/t/font_495240_oxbe4zwl9tem6lxr.css" media="all"/>
</head>
<body class="childrenBody">
<form class="layui-form layui-form-pane">
    <input type="hidden" name="pid" value="<?php echo ($_GET['pid']); ?>">
    <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-block">
            <input type="text" lay-verify="required" lay-vertype="tips" title="菜单名称" name="name" placeholder="菜单名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">打开位置</label>
        <div class="layui-input-block">
            <input type="radio" name="target" value="default" title="右侧" checked>
            <input type="radio" name="target" value="_blank" title="新页面" >
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">图标</label>
        <div class="layui-inline">
            <a class="layui-btn layui-btn-primary fl-l mr-5 icon-pick" style="width: 41px;padding: 0 10px;"><i class="iconfont icon-menu1" style="font-size:18px;color:#76838f;"></i></a>
        </div>
        <div class="layui-inline" style="width: 50%">
            <input type="text"  lay-verify="required" lay-vertype="tips" title="排序" name="icon" placeholder="图标" readonly id="iconpick" value="iconfont icon-menu1"  class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">链接</label>
        <div class="layui-input-block">
            <select name="rule_id" lay-search>
                <option value="">选择地址</option>
                <?php if(is_array($urlist)): $i = 0; $__LIST__ = $urlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["_name"]); ?>-<?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="addData">提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<script type="text/javascript" src="/Public/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/static/layui/layui.js"></script>
<script type="text/javascript">
    layui.config({
        base: '/Public/static/layui/'
    }).extend({
        iconpick: 'iconpick'
    });
    layui.use(['form','layer','iconpick'],function(){
        let form = layui.form,
            iconpick = layui.iconpick;


        $("#iconpick").on('click',function(e){
            $(".icon-pick").click();
            e.stopPropagation();
        });

        iconpick.pickinit('icon-pick','iconpick');


        form.on("submit(addData)",function(data){
            //弹出loading
            //var index = layer.msg('数据提交中，请稍候',{icon: 16,time:false});
            $.post("/admin/auth/add_menu",{paras:$('form').serialize()},function(res){
                //layer.close(index);
                if(0 === res.code){
                    window.parent.window.parent.toast(res.info,0);
                    parent.layer.closeAll();
                    window.parent.tablist.reload();
                }else{
                    window.parent.window.parent.toast(res.info,1);
                }
            });
            return false;
        });
        /*//图表展示页面
        $('input[name=icon]').on('click',function (e) {
            icon_open = layer.open({
                title: '选择图标',
                type: 1,
                content: '<?php echo ($icons); ?>',
                closeBtn: false,
                area: ['100%', '100%']
            });
        });*/
    })
</script>
</body>
</html>