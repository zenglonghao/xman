<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/Public/static/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/Public/static/css/public.css" media="all"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_495240_oxbe4zwl9tem6lxr.css" media="all"/>
    <link rel="stylesheet" href="/Public/static/js/jquery-ui/jquery-ui.min.css" media="all" />
    <style type="text/css">
        body{overflow-y: scroll;}
    </style>
</head>
<body class="childrenBody">
        <blockquote class="layui-elem-quote layui-quote-nm"><a class="layui-btn  layui-btn-green layui-btn-sm add_btn layui-btn-radius" title="添加">
            <i class="layui-icon   layui-icon-add-circle"></i>添加菜单项
        </a>
            <a class="layui-btn layui-btn-sm layui-btn-radius tttt" title="刷新当前页" href="javascript:void(0);"
                    onclick="layer.load(1);window.location.reload(true);"><i class="layui-icon">&#xe669;</i>刷新当前页</a>
            <a class="layui-btn layui-btn-sm layui-btn-radius layui-btn-normal sorthelp" title="排序功能提示" href="javascript:void(0);"
            ><i class="layui-icon layui-icon-help"></i>排序功能</a>
            <a class="layui-btn layui-btn-sm layui-btn-radius  cancelsort " style="display: none;background-color:#ee0000" title="取消排序" href="javascript:void(0);"
            ><i class="iconfont icon-chushaixuanxiang"></i>取消排序</a>
        </blockquote>
    <table id="table" lay-filter="table"></table>
    <!--操作-->
    <script type="text/html" id="tool">
        <div class="layui-btn-group">
            <a class="layui-btn layui-btn-green layui-btn-xs" lay-event="add" title="添加子菜单">
                <i class="layui-icon layui-icon-add-circle"></i>
            </a>
        <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="edit" title="编辑">
            <i class="layui-icon layui-icon-edit"></i>
        </a>
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del" title="删除">
            <i class="layui-icon layui-icon-delete"></i>
        </a>
            <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="drop" title="单击拖拽，开启排序功能">
                拖拽 ↑↓
            </a>
        </div>
    </script>
<script type="text/javascript" src="/Public/static/js/jquery-3.2.0.min.js"></script>
        <script type="text/javascript" src="/Public/static/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/Public/static/layui/layui.js"></script>
<script type="text/javascript">
    //数组是否相同的比较方法
    // Warn if overriding existing method
    if(Array.prototype.equals)
        console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");
    // attach the .equals method to Array's prototype to call it on any array
    Array.prototype.equals = function (array) {
        // if the other array is a falsy value, return
        if (!array)
            return false;
        // compare lengths - can save a lot of time
        if (this.length != array.length)
            return false;
        for (var i = 0, l = this.length; i < l; i++) {
            // Check if we have nested arrays
            if (this[i] instanceof Array && array[i] instanceof Array) {
                // recurse into the nested arrays
                if (!this[i].equals(array[i]))
                    return false;
            }
            else if (this[i] != array[i]) {
                // Warning - two different object instances will never be equal: {x:20} != {x:20}
                return false;
            }
        }
        return true;
    };
    // Hide method from for-in loops
    Object.defineProperty(Array.prototype, "equals", {enumerable: false});
    var tablist = '';
    layui.use(['form', 'layer', 'laydate', 'table', 'laytpl'], function () {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : top.layer,
            $ = layui.jquery,
            laydate = layui.laydate,
            laytpl = layui.laytpl,
            table = layui.table;

        //提示排序功能帮助信息
        $('.sorthelp').on('click',function(){
            layer.alert('1.单击 <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="drop" title="单击拖拽，开启排序功能">拖拽 ↑↓</a> 按钮，会开启排序功能<br>2.只支持同级别内排序',{
                title:'排序功能帮助',
                closeBtn:0
            });
        });
        $('.cancelsort').on('click',function(){
            tablist.reload();
            $(this).hide();
        });
        //数据表格渲染
        tablist = table.render({
            elem: '#table',
            url: '/admin/auth/menus',
            method: 'post',
            cellMinWidth: 95,
            id: "table",
            cols: [[
                {field: 'id', title: 'ID', width: 60, align: "center"},
                {field: '_name', title: '菜单名',width:200,templet:function(d){
                    return '<div data-pid="' + d.pid + '">' + d._name + '</div>';
                    }},
                {field: 'link', title: '链接', align: 'center',templet:function(d){
                    if(d.link === null){
                        return 'no';
                    }else{
                        return "<div class='layui-blue'><span>"+d.link+"</span></div>";
                    }
                    }},
                {field: 'icon', title: '图标', align: 'center',templet:function(d){
                    return "<div><i class='"+ d.icon +"'></i></div>";
                    },width:90},
                {title: '操作', width: 180, templet: '#tool',  align: "center"}
            ]]
            ,done:function(){
                $("tbody tr[data-index]").each(function(index,e){
                    var pid = $(e).find("div[data-pid]").data('pid');
                    var id = $(e).find("div:first").html();
                    $(e).attr('data-pid',pid);
                    $(e).attr('data-id',id);
                });
            }
        });
        //编辑/添加函数
        function addoredit(url,name) {
            var index = layui.layer.open({
                title: name,
                type: 2,
                content: url,
                area:['60%','96%']
            });
        }

        //添加一级菜单
        $(".add_btn").on('click',function () {
            addoredit('/admin/auth/add_menu/pid/0','添加<span class="layui-red"> 一级菜单 </span>项');
        });

        var oldsort = [];//存放未排序前的数据
        var newsort = [];//新的排序数据
        //列表操作
        table.on('tool(table)', function (obj) {
            var layEvent = obj.event,
                data = obj.data;
            if (layEvent === 'edit') { //编辑
                addoredit('/admin/auth/edit_menu/id/'+data.id,'编辑 <span class="layui-red">'+ data.name +'</span> 数据');
            } else if (layEvent === 'del') { //删除
                layer.confirm('确定删除 <span class="layui-red">'+ data.name+'</span> ？', {icon: 3, title: '提示'}, function (index) {
                    layer.close(index);
                    $.post("/admin/auth/del_menu",{'id':data.id},function(data){
                        window.parent.toast(data.info,data.code);
                        if(data.code === 0)
                        tablist.reload();
                    });
                });
            }else if(layEvent === 'add'){
                addoredit('/admin/auth/add_menu/pid/'+data.id,'添加 <span class="layui-red">' + data.name +'</span> 子菜单项');
            }else if(layEvent === 'drop'){
                if($(this).hasClass('layui-bg-cyan')){
                    return false;
                }
                var pid = data.pid;
                $('tr').not("tr[data-pid="+pid+"]").addClass('ui-state-disabled');
                //记录旧顺序
                var ob = $('tr:not(.ui-state-disabled)');
                oldsort = [];
                ob.each(function(i,e){
                    oldsort.push($(e).attr('data-id'));
                });
                ob.find("a[lay-event=drop]").addClass('layui-bg-cyan');
                $(".layui-table-main tbody").sortable({
                    canel:'tr:not(.ui-state-disabled)'
                    ,axis:'y'
                    ,containment:'.layui-table-main tbody'
                    ,cursor: "move"
                    , delay: 150
                    ,forcePlaceholderSize:true
                    ,handle:'a[lay-event=drop]'
                    ,opacity:1
                    ,scroll:true
                    ,scrollSensitivity:500
                    ,scrollSpeed:50
                    ,update:function(e,ui){
                        newsort = [];
                        $('tr:not(.ui-state-disabled)').each(function(i,e){
                            newsort.push($(e).attr('data-id'));
                        });
                        if(!newsort.equals(oldsort)){
                            $.post("/admin/auth/change_menu_sort",{oldsort:oldsort,newsort:newsort},function(data){
                                window.parent.toast(data.info,data.code);
                                $('.cancelsort').hide();
                                tablist.reload();
                            });
                        }
                    }
                });
                $('.cancelsort').show();
            }
        });
    });
</script>
</body>
</html>