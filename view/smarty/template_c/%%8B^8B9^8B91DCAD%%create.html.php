<?php /* Smarty version 2.6.26, created on 2014-08-15 20:49:36
         compiled from asmac/create.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>策略管理</title>
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
/public/js/pagenav.js'></script>
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
        $(function() {
            $("#v-menu").ebMenu({
                viewMode : "full",
                activeFirstMenu : true
            });
            $('#strategyModify').dialog({
                autoOpen: false,
                width: 500,
                modal: true
            });
        });
        function edit(stream_number){
            $("#strategy").attr("value",stream_number);
            $('#strategyModify').dialog('open');
        }
        function check() {
            var desc = $("#desc").val();
            var value = $("#value").val();
            if (value == "") {
                alert("请确定输入有效的value值!");
                return false;
            }
            $("#search-form").submit();
        }
        function rest() {
            $("#desc").val("");
            $("#value").val("");
			$("#phone").val("");
            $("#name").val("");
			$("#province").val("");
            $("#city").val("");
			$("#match_type").val("");
            $("#status").val("");
        }
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
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计</a></li>
                <li class="active current"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
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
            <li ><a href="javascript:void(0)">数据统计</a>
                <ul>
                    <li  style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计管理</a></li>
                </ul>
            </li>
            <li class='active'><a href="javascript:void(0)">策略管理</a>
                <ul>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac/list">策略号码管理</a></li>
                    <li class='active' style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac/create">策略频次设置</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="ui-layout-center">
    <div id="main" >
        <div class="breadcrumb">
            <span class="cur">我所在的位置：策略管理>>查看策略>>管理</span>
        </div>
        <div class="main-unit">
            <div class="header">
                <span>策略数据列表</span>
            </div>
            <div>
            </div>
            <div class="unit-container">
                <div class="hintmsg">[说明]&nbsp;展示策略相关信息，支持修改。</div>
                <table id="entity-table" class="table-complex table-imgbtn highlight">
                    <thead>
                    <tr>
                        <th>策略类型</th>
                        <th>中文描述</th>
                        <th>门限值</th>
                        <th>编辑</th>
                    </tr>
                    </thead>
                    <tbody id="intervalDataBody">
                    <?php $_from = $this->_tpl_vars['stratety_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <?php if ($this->_tpl_vars['k']%2 == 0): ?>
                    <tr class='even'>
                        <?php else: ?>
                    <tr class='odd'>
                        <?php endif; ?>
                        <td><?php echo $this->_tpl_vars['array'][$this->_tpl_vars['v']['strategy']]; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['desc']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['value']; ?>
</td>
                        <td>
                            <a class="opt-edit opt" href="javascript:edit('<?php echo $this->_tpl_vars['v']['strategy']; ?>
')" title="编辑">编辑</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id ="strategyModify" title="策略修改" class="main-unit">
            <form id="search-form" name="search-form" action="" method="post">
                <table class="table-2col" style="width:400px;">
                    <tr>
                        <th>中文描述:</th>
                        <td><input type="text" name='desc' id='desc' class="ipt-s" value="" /></td>
                    </tr>
                    <tr>
                        <th>门限值:</th>
                        <td><input type="text" name='value' id='value' class="ipt-s" value="" /></td>
                        <input style="display:none;" type="text" name='strategy' id='strategy' class="ipt-s" value="" />
                    </tr>
                </table>

                <center>
                    <div class="btn-container" style="width: 400px">
                        <a class="btn-save" onclick="check()">提交</a>
                        <a class="btn-save" onclick="rest()">重置</a>
                    </div>
                </center>
            </form>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>