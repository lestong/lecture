<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo (cookie('admin_logo_title')); ?></title>
<!-- bootstrap - css -->
<link href="/Public/BJUI/themes/css/bootstrap.css" rel="stylesheet">
<!-- core - css -->
<link href="/Public/BJUI/themes/css/style.css" rel="stylesheet">
<link href="/Public/BJUI/themes/blue/core.css" id="bjui-link-theme" rel="stylesheet">
<!-- plug - css -->
<link href="/Public/BJUI/plugins/kindeditor_4.1.10/themes/default/default.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/niceValidator/jquery.validator.css" rel="stylesheet">
<link href="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.css" rel="stylesheet">
<link href="/Public/BJUI/themes/css/FA/css/font-awesome.min.css" rel="stylesheet">
<!--[if lte IE 7]>
<link href="/Public/BJUI/themes/css/ie7.css" rel="stylesheet">
<![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lte IE 9]>
    <script src="/Public/BJUI/other/html5shiv.min.js"></script>
    <script src="/Public/BJUI/other/respond.min.js"></script>
<![endif]-->
<!-- jquery -->
<script src="/Public/BJUI/js/jquery-1.7.2.min.js"></script>
<script src="/Public/BJUI/js/jquery.cookie.js"></script>
<!--[if lte IE 9]>
<script src="/Public/BJUI/other/jquery.iframe-transport.js"></script>    
<![endif]-->
<!-- BJUI.all 分模块压缩版 -->
<!-- <script src="/Public/BJUI/js/bjui-all.js"></script> -->
<!-- 以下是B-JUI的分模块未压缩版，建议开发调试阶段使用下面的版本 -->

<script src="/Public/BJUI/js/bjui-core.js"></script>
<script src="/Public/BJUI/js/bjui-regional.zh-CN.js"></script>
<script src="/Public/BJUI/js/bjui-frag.js"></script>
<script src="/Public/BJUI/js/bjui-extends.js"></script>
<script src="/Public/BJUI/js/bjui-basedrag.js"></script>
<script src="/Public/BJUI/js/bjui-slidebar.js"></script>
<script src="/Public/BJUI/js/bjui-contextmenu.js"></script>
<script src="/Public/BJUI/js/bjui-navtab.js"></script>
<script src="/Public/BJUI/js/bjui-dialog.js"></script>
<script src="/Public/BJUI/js/bjui-taskbar.js"></script>
<script src="/Public/BJUI/js/bjui-ajax.js"></script>
<script src="/Public/BJUI/js/bjui-alertmsg.js"></script>
<script src="/Public/BJUI/js/bjui-pagination.js"></script>
<script src="/Public/BJUI/js/bjui-util.date.js"></script>
<script src="/Public/BJUI/js/bjui-datepicker.js"></script>
<script src="/Public/BJUI/js/bjui-ajaxtab.js"></script>
<script src="/Public/BJUI/js/bjui-datagrid.js"></script>
<script src="/Public/BJUI/js/bjui-tablefixed.js"></script>
<script src="/Public/BJUI/js/bjui-tabledit.js"></script>
<script src="/Public/BJUI/js/bjui-spinner.js"></script>
<script src="/Public/BJUI/js/bjui-lookup.js"></script>
<script src="/Public/BJUI/js/bjui-tags.js"></script>
<script src="/Public/BJUI/js/bjui-upload.js"></script>
<script src="/Public/BJUI/js/bjui-theme.js"></script>
<script src="/Public/BJUI/js/bjui-initui.js"></script>
<script src="/Public/BJUI/js/bjui-plugins.js"></script>
<script src="/Public/BJUI/js/bjui-language.js"></script>

<!-- plugins -->
<!-- swfupload for uploadify && kindeditor -->
<script src="/Public/BJUI/plugins/swfupload/swfupload.js"></script>
<!-- kindeditor -->
<script src="/Public/BJUI/plugins/kindeditor_4.1.10/kindeditor-all.min.js"></script>
<script src="/Public/BJUI/plugins/kindeditor_4.1.10/lang/zh_CN.js"></script>
<!-- colorpicker -->
<script src="/Public/BJUI/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- ztree -->
<script src="/Public/BJUI/plugins/ztree/jquery.ztree.all-3.5.js"></script>
<!-- nice validate -->
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.js"></script>
<script src="/Public/BJUI/plugins/niceValidator/jquery.validator.themes.js"></script>
<!-- bootstrap plugins -->
<script src="/Public/BJUI/plugins/bootstrap.min.js"></script>
<script src="/Public/BJUI/plugins/bootstrapSelect/bootstrap-select.min.js"></script>
<script src="/Public/BJUI/plugins/bootstrapSelect/defaults-zh_CN.min.js"></script>
<!-- icheck -->
<script src="/Public/BJUI/plugins/icheck/icheck.min.js"></script>
<!-- dragsort -->
<script src="/Public/BJUI/plugins/dragsort/jquery.dragsort-0.5.1.min.js"></script>
<!-- HighCharts -->
<script src="/Public/BJUI/plugins/highcharts/highcharts.js"></script>
<script src="/Public/BJUI/plugins/highcharts/highcharts-3d.js"></script>
<script src="/Public/BJUI/plugins/highcharts/themes/gray.js"></script>
<!-- ECharts -->
<script src="/Public/BJUI/plugins/echarts/echarts.js"></script>
<!-- other plugins -->
<script src="/Public/BJUI/plugins/other/jquery.autosize.js"></script>
<link href="/Public/BJUI/plugins/uploadify/css/uploadify.css" rel="stylesheet">
<script src="/Public/BJUI/plugins/uploadify/scripts/jquery.uploadify.min.js"></script>
<script src="/Public/BJUI/plugins/download/jquery.fileDownload.js"></script>
<!-- init -->
<script type="text/javascript">
$(function() {
    BJUI.init({
        JSPATH       : '/Public/BJUI/',         //[可选]框架路径
        PLUGINPATH   : '/Public/BJUI/plugins/', //[可选]插件路径
        loginInfo    : {url:'login_timeout.html', title:'登录', width:400, height:200}, // 会话超时后弹出登录对话框
        statusCode   : {ok:200, error:300, timeout:301}, //[可选]
        ajaxTimeout  : 50000, //[可选]全局Ajax请求超时时间(毫秒)
        pageInfo     : {total:'total', pageCurrent:'pageCurrent', pageSize:'pageSize', orderField:'orderField', orderDirection:'orderDirection'}, //[可选]分页参数
        alertMsg     : {displayPosition:'topcenter', displayMode:'slide', alertTimeout:3000}, //[可选]信息提示的显示位置，显隐方式，及[info/correct]方式时自动关闭延时(毫秒)
        keys         : {statusCode:'statusCode', message:'message'}, //[可选]
        ui           : {
                         windowWidth      : 0, //框架显示宽度，0=100%宽，> 600为则居中显示
                         showSlidebar     : true, //[可选]左侧导航栏锁定/隐藏
                         clientPaging     : true, //[可选]是否在客户端响应分页及排序参数
                         overwriteHomeTab : false //[可选]当打开一个未定义id的navtab时，是否可以覆盖主navtab(我的主页)
                       },
        debug        : true,    // [可选]调试模式 [true|false，默认false]
        theme        : 'sky' // 若有Cookie['bjui_theme'],优先选择Cookie['bjui_theme']。皮肤[五种皮肤:default, orange, purple, blue, red, green]
    })
    
    // main - menu
    $('#bjui-accordionmenu')
        .collapse()
        .on('hidden.bs.collapse', function(e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                
                if ($a.hasClass('collapsed')) $heading.removeClass('active')
            })
        })
        .on('shown.bs.collapse', function (e) {
            $(this).find('> .panel > .panel-heading').each(function() {
                var $heading = $(this), $a = $heading.find('> h4 > a')
                
                if (!$a.hasClass('collapsed')) $heading.addClass('active')
            })
        })
        
    $(document).on('click', 'ul.menu-items li > a', function(e) {
        var $a = $(this), $li = $a.parent(), options = $a.data('options').toObj(), $children = $li.find('> .menu-items-children')
        var onClose = function() {
            $li.removeClass('active')
        }
        var onSwitch = function() {
            $('#bjui-accordionmenu').find('ul.menu-items li').removeClass('switch')
            $li.addClass('switch')
        }
        
        $li.addClass('active')
        if (options) {
            options.url      = $a.attr('href')
            options.onClose  = onClose
            options.onSwitch = onSwitch
            if (!options.title) options.title = $a.text()
            
            if (!options.target)
                $a.navtab(options)
            else
                $a.dialog(options)
        }
        if ($children.length) {
            $li.toggleClass('open')
        }
        
        e.preventDefault()
    })
    
    //时钟
    var today = new Date(), time = today.getTime()
    $('#bjui-date').html(today.formatDate('yyyy/MM/dd'))
    setInterval(function() {
        today = new Date(today.setSeconds(today.getSeconds() + 1))
        $('#bjui-clock').html(today.formatDate('HH:mm:ss'))
    }, 1000)
})

//菜单-事件
function MainMenuClick(event, treeId, treeNode) {
    event.preventDefault()
    
    if (treeNode.isParent) {
        var zTree = $.fn.zTree.getZTreeObj(treeId)
        
        zTree.expandNode(treeNode, !treeNode.open, false, true, true)
        return
    }
    
    if (treeNode.target && treeNode.target == 'dialog')
        $(event.target).dialog({id:treeNode.tabid, url:treeNode.url, title:treeNode.name})
    else
        $(event.target).navtab({id:treeNode.tabid, url:treeNode.url, title:treeNode.name, fresh:treeNode.fresh, external:treeNode.external})
}
//切换语音
$(function(){
	$("#think_language  li > a").click(function(){
		alert(1)
	});
});
</script>
<!-- for doc begin -->
<link type="text/css" rel="stylesheet" href="/Public/js/syntaxhighlighter-2.1.382/styles/shCore.css"/>
<link type="text/css" rel="stylesheet" href="/Public/js/syntaxhighlighter-2.1.382/styles/shThemeEclipse.css"/>
<script type="text/javascript" src="/Public/js/syntaxhighlighter-2.1.382/scripts/brush.js"></script>
<link href="/Public/css/doc.css" rel="stylesheet">
<script type="text/javascript">
$(function(){
    SyntaxHighlighter.config.clipboardSwf = '/Public/js/syntaxhighlighter-2.1.382/scripts/clipboard.swf'
    $(document).on(BJUI.eventType.initUI, function(e) {
        SyntaxHighlighter.highlight();
    })
})
</script>
<!-- for doc end -->
</head>
<body>
    <!--[if lte IE 7]>
        <div id="errorie"><div>您还在使用老掉牙的IE，正常使用系统前请升级您的浏览器到 IE8以上版本 <a target="_blank" href="http://windows.microsoft.com/zh-cn/internet-explorer/ie-8-worldwide-languages">点击升级</a>&nbsp;&nbsp;强烈建议您更改换浏览器：<a href="http://down.tech.sina.com.cn/content/40975.html" target="_blank">谷歌 Chrome</a></div></div>
    <![endif]-->
    <div id="bjui-window">
    <header id="bjui-header">
        <div class="bjui-navbar-header">
            <button type="button" class="bjui-navbar-toggle btn-default" data-toggle="collapse" data-target="#bjui-navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <a class="bjui-navbar-logo" href="#"><img src="<?php echo (cookie('admin_logo')); ?>" height="40"></a>
        </div>
        <nav id="bjui-navbar-collapse">
            <ul class="bjui-navbar-right">
                <li class="datetime"><div><span id="bjui-date"></span> <span id="bjui-clock"></span></div></li>
                <!-- <li><a href="#">消息 <span class="badge">4</span></a></li> -->
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo (cookie('username')); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo U('System/changePassword');?>" data-toggle="dialog" data-id="changepwd_page" data-mask="true" data-width="600" data-height="260">&nbsp;<span class="glyphicon glyphicon-lock"></span> <?php echo L('btn_change_password');?>&nbsp;</a></li>
                        <li><a href="<?php echo U('System/profile');?>" data-toggle="dialog" data-id="System_profile" data-mask="true" data-width="600" data-height="260">&nbsp;<span class="glyphicon glyphicon-user"></span> <?php echo L('btn_profile');?></a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo U('Publics/logout');?>" class="red">&nbsp;<span class="glyphicon glyphicon-off"></span> <?php echo L('btn_logout');?></a></li>
                        
                    </ul>
                </li>
                
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" id="think_language">Language <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" id="bjui-language">
                        <li><a href="javascript:;" class="language_zh-cn" data-language="zh-cn" data-toggle="language" >&nbsp;简体&nbsp;</a></li>
                        <li><a href="javascript:;"class="language_zh-tw" data-language="zh-tw" data-toggle="language">&nbsp;繁體&nbsp;</a></li>
                    </ul>
                </li>
                <!-- <li><a href="#" title="切换为树状导航(宽版)" style="background-color:#ff7b61;">树状导航栏(宽版)</a></li> -->
                <li class="dropdown"><a href="#" class="dropdown-toggle theme blue" data-toggle="dropdown" title="切换皮肤"><i class="fa fa-tree"></i></a>
                    <ul class="dropdown-menu" role="menu" id="bjui-themes">
                        <li><a href="javascript:;" class="theme_default" data-toggle="theme" data-theme="default">&nbsp;<i class="fa fa-tree"></i> <?php echo L('theme_default');?>&nbsp;&nbsp;</a></li>
                        <li><a href="javascript:;" class="theme_orange" data-toggle="theme" data-theme="orange">&nbsp;<i class="fa fa-tree"></i> <?php echo L('theme_orange');?></a></li>
                        <li><a href="javascript:;" class="theme_purple" data-toggle="theme" data-theme="purple">&nbsp;<i class="fa fa-tree"></i> <?php echo L('theme_purple');?></a></li>
                        <li class="active"><a href="javascript:;" class="theme_blue" data-toggle="theme" data-theme="blue">&nbsp;<i class="fa fa-tree"></i> <?php echo L('theme_blue');?></a></li>
                        <li><a href="javascript:;" class="theme_green" data-toggle="theme" data-theme="green">&nbsp;<i class="fa fa-tree"></i> <?php echo L('theme_green');?></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="bjui-hnav">
            <button type="button" class="btn-default bjui-hnav-more-left" title="<?php echo L('btn_move_left');?>"><i class="fa fa-angle-double-left"></i></button>
            <div id="bjui-hnav-navbar-box">
                <ul id="bjui-hnav-navbar">
                <?php if(is_array($menu)): foreach($menu as $oneKey=>$oneLevel): ?><li <?php if(($oneKey) == "0"): ?>class="active"<?php endif; ?>><a href="javascript:;" data-toggle="slidebar"><i class="fa fa-<?php echo ((isset($oneLevel["icon"]) && ($oneLevel["icon"] !== ""))?($oneLevel["icon"]):'cog'); ?>"></i> <?php echo ($oneLevel["name"]); ?></a>
                        <div class="items hide" data-noinit="true">
                            <?php if(is_array($oneLevel["_child"])): foreach($oneLevel["_child"] as $key=>$twoLevel): if(!empty($twoLevel["_child"])): ?><ul class="menu-items" data-tit="<?php echo ($twoLevel["name"]); ?>" data-faicon="<?php echo ((isset($twoLevel["icon"]) && ($twoLevel["icon"] !== ""))?($twoLevel["icon"]):'cog'); ?>">
                                <?php if(is_array($twoLevel["_child"])): foreach($twoLevel["_child"] as $key=>$threeLevel): if(!empty($threeLevel["_child"])): ?><li><a href="<?php echo U($threeLevel[c].'/'.$threeLevel[a]);?>" data-options="{id:'<?php echo ($threeLevel[c]); ?>_<?php echo ($threeLevel[a]); ?>', faicon:'<?php echo ((isset($threeLevel["icon"]) && ($threeLevel["icon"] !== ""))?($threeLevel["icon"]):'cog'); ?>'}"><?php echo ($threeLevel["name"]); ?></a><b><i class="fa fa-angle-down"></i></b>
                                    <ul class="menu-items-children">
                                    
                                    <?php if(is_array($threeLevel['_child'])): foreach($threeLevel['_child'] as $fourLevel): ?>
                                    <li><a href="<?php echo U($fourLevel[c].'/'.$fourLevel[a]);?>" data-options="{id:'<?php echo ($fourLevel[c]); ?>_<?php echo ($fourLevel[a]); ?>', faicon:'<?php echo ((isset($fourLevel["icon"]) && ($fourLevel["icon"] !== ""))?($fourLevel["icon"]):'cog'); ?>'}"><?php echo ($fourLevel["name"]); ?></a></li>
                                    <?php endforeach; endif; ?>
                                    
                                    </ul>
                                </li>
                                <?php else: ?>
                                <li><a href="<?php echo U($threeLevel[c].'/'.$threeLevel[a]);?>" data-options="{id:'<?php echo ($threeLevel[c]); ?>_<?php echo ($threeLevel[a]); ?>', faicon:'<?php echo ((isset($threeLevel["icon"]) && ($threeLevel["icon"] !== ""))?($threeLevel["icon"]):'cog'); ?>'}"><?php echo ($threeLevel["name"]); ?></a></li><?php endif; endforeach; endif; ?>
                            </ul>
                            <?php else: ?>
                            <ul class="menu-items" data-faicon="<?php echo ((isset($twoLevel["icon"]) && ($twoLevel["icon"] !== ""))?($twoLevel["icon"]):'cog'); ?>">
                                <li><a href="<?php echo U($twoLevel[c].'/'.$twoLevel[a]);?>" data-options="{id:'<?php echo ($twoLevel[c]); ?>_<?php echo ($twoLevel[a]); ?>', faicon:'<?php echo ((isset($twoLevel["icon"]) && ($twoLevel["icon"] !== ""))?($twoLevel["icon"]):'cog'); ?>'}"><?php echo ($twoLevel["name"]); ?></a></li>
                            </ul><?php endif; endforeach; endif; ?>
                        </div>
                    </li><?php endforeach; endif; ?>    
                </ul>
            </div>
            <button type="button" class="btn-default bjui-hnav-more-right" title="<?php echo L('btn_move_right');?>"><i class="fa fa-angle-double-right"></i></button>
        </div>
    </header>
    <div id="bjui-container" class="clearfix">
        <div id="bjui-leftside">
            <div id="bjui-sidebar-s">
                <div class="collapse"></div>
            </div>
            <div id="bjui-sidebar">
                <div class="toggleCollapse"><h2><i class="fa fa-bars"></i> <?php echo L('btn_navigation');?> <i class="fa fa-bars"></i></h2><a href="javascript:;" class="lock"><i class="fa fa-lock"></i></a></div>
                <div class="panel-group panel-main" data-toggle="accordion" id="bjui-accordionmenu">
                </div>
            </div>
        </div>
        <div id="bjui-navtab" class="tabsPage">
            <div class="tabsPageHeader">
                <div class="tabsPageHeaderContent">
                    <ul class="navtab-tab nav nav-tabs">
                        <li data-url="<?php echo U('AdminCP/welcome');?>" data-faicon="home"><a href="javascript:;"><span><i class="fa fa-home"></i> #maintab#</span></a></li>
                    </ul>
                </div>
                <div class="tabsLeft"><i class="fa fa-angle-double-left"></i></div>
                <div class="tabsRight"><i class="fa fa-angle-double-right"></i></div>
                <div class="tabsMore"><i class="fa fa-angle-double-down"></i></div>
            </div>
            <ul class="tabsMoreList">
                <li><a href="javascript:;">#maintab#</a></li>
            </ul>
            <div class="navtab-panel tabsPageContent">
                <div class="navtabPage unitBox">
                    <div class="bjui-pageContent" style="background:#FFF;">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="bjui-footer">
        Copyright © 2014.优优汇联 <a href="http://www.uulian.com" target="_blank">uulian.com</a> All rights reserved.
    </footer>
    </div>
</body>
</html>