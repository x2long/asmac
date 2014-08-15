<?php /* Smarty version 2.6.26, created on 2014-08-14 21:28:46
         compiled from manage/dataStatistics.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>数据统计</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.layout.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.ebMenu.js"></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery-ui-1.8.10.custom.min.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/pageNavForAjax.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/topology.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/d3.v3.min.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.uniform.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.validationEngine-cn.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.validationEngine.js'></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/exporting.js"></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/grid.js"></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.colorbox-min.js'></script>
    <script type="text/javascript" src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/rms.js'></script>
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.qtip.min.js"></script>
    <link href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/layout_main.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
    <link href='<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/jquery-ui-1.8.10.custom.css' rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/colorbox.css" rel="stylesheet" type="text/css" />
    <link href='<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/validationEngine.jquery.css' rel="stylesheet" type="text/css" />
    <link href='<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/uniform.css' rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/rms.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        $(function(){
            $("#v-menu").ebMenu({
                viewMode : "full",
                activeFirstMenu : true
            });
            $('#tabs').tabs();
            showTabPage(2);
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('body').layout({
                north__spacing_open : 0,
                south__spacing_open : 0,
                north__minSize : 60,
                west__size : 200,
                west__spacing_closed : 20,
                west__togglerLength_closed : 100,
                west__togglerAlign_closed : "top",
                west__togglerContent_closed : "",
                west__togglerTip_closed : "Open & Pin Menu",
                west__sliderTip : "Slide Open Menu",
                west__closable : false,
                north__closable : false,
                west__slideTrigger_open : "mouseover"
            });
        });
    </script>
</head>
<body>
<div class="ui-layout-north">
    <div id="header">
        <div id="title">
            <img src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/images/title.png" />
        </div>
        <div id="usr">
            <a href="" id="usr-name"><?php echo $this->_tpl_vars['model']->username; ?>
</a>
            <span id='login-info' style='cursor:pointer'>...</span>|<a	href="<?php echo $this->_tpl_vars['base_url']; ?>
/site/logout">退出</a>
        </div>
    </div>
    <div id="nav">
        <div id="main-menu" style="position:absolute;left:200px">
            <ul>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac">首页</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage">人工审核</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">数据查询</a></li>
                <li class="active current"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac/create">策略管理</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="ui-layout-west">
    <head>
        <script type="text/javascript"
                src='<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/jquery.ebMenu.js'></script>
        <script>
            $(function() {
                $("#v-menu").ebMenu();
                var active = $("li.active");
                active.eq(1).children("*").css("display", "block");
                active.eq(1).children("a").removeClass("collapsed").addClass("expanded");
            });
        </script>
    </head>
    <div id="sidebar">
        <ul id="v-menu">
            <li ><a href="javascript:void(0)">人工审核</a>
                <ul>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage">最新数据列表</a></li>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/audit">审核历史查询</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">数据查询</a>
            <ul>
                <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/callHistory">历史呼叫查询</a></li>
                <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">历史拦截查询</a></li>
                </ul>
            </li>
            <li class='active'><a href="javascript:void(0)">数据统计</a>
                <ul>
                    <li class='active' style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计管理</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">策略管理</a>
                <ul>
					<li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac/list">策略号码管理</a></li>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac/create">策略频次设置</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="ui-layout-center">
    <div id="main" >
        <style>
            tr.selected.even td{
                background-color:#CD96CD;
            }
            tr.selected.odd td{
                background-color:#CD96CD;
            }
        </style>
        <div class="breadcrumb" >
            <span class="cur">我所在的位置：数据统计>>所有数据>>查看</span>
        </div>
        <div id="tabs" style="min-height: 150%">
            <ul>
                <li><a href="#tabs-2" onclick="showTabPage(2)">诈骗号码分析</a></li>
                <li><a href="#tabs-1" onclick="showTabPage(1)">疑似呼叫次数</a></li>
                <li><a href="#tabs-3" onclick="showTabPage(3)">拦截呼叫次数</a></li>
            </ul>
            <div id="tabs-1"></div>
            <div id="tabs-2"></div>
            <div id="tabs-3"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showTabPage(tabNum){
        for(var index=1;index<=3; index++){
            $("#tabs-"+index).html("");
        }
        var param = "tabNum="+tabNum;
        $.getJSON("<?php echo $this->_tpl_vars['base_url']; ?>
/manage/getStatisticsFrameCharts?"+param, function(result){
            $("#tabs-"+tabNum).html(result);
        });
    }
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>