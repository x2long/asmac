<?php /* Smarty version 2.6.26, created on 2014-08-14 20:34:50
         compiled from site/generate.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>录入数据</title>
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
        });
    </script>
    <script type="text/javascript">
        var count = parseInt("<?php echo $this->_tpl_vars['model']->totalNum; ?>
");//从后台获取总记录数
        var currentPage = parseInt("<?php echo $this->_tpl_vars['model']->currentPage; ?>
") + 1;
        var countPerPage = parseInt("<?php echo $this->_tpl_vars['model']->countPerPage; ?>
");  //count per page
        var showLowerBound = count == 0 ? 0 : (currentPage - 1) * countPerPage + 1;
        var showUpperBound = count > currentPage * countPerPage ? currentPage
                * countPerPage : count;
        var totalPage = parseInt((count + countPerPage - 1) / countPerPage);
        $(function() {
            $("#operTimeBegin").datepicker({
                dateFormat : 'yy-mm-dd'
            });
            $("#operTimeEnd").datepicker({
                dateFormat : 'yy-mm-dd'
            });
            //params 一些初始值由后台传入
            var params = "numberType=<?php echo $this->_tpl_vars['params']['numberType']; ?>
"
                    +"&callingNumber=<?php echo $this->_tpl_vars['params']['callingNumber']; ?>
"
                    +"&calledNumber=<?php echo $this->_tpl_vars['params']['calledNumber']; ?>
"
                    +"&notesDesc=<?php echo $this->_tpl_vars['params']['notesDesc']; ?>
"
                    +"&strategyType=<?php echo $this->_tpl_vars['params']['strategyType']; ?>
"
                    +"&operTimeBegin=<?php echo $this->_tpl_vars['params']['operTimeBegin']; ?>
"
                    +"&countPerPage="+countPerPage
                    +"&operTimeEnd=<?php echo $this->_tpl_vars['params']['operTimeEnd']; ?>
"+"&";
            if (totalPage > 1) {
                pageNav.url = "" + '?' + params;
                pageNav.pre = "上一页";
                pageNav.next = "下一页";
                pageNav.go(currentPage, totalPage);//共totalPage页
            }
            $('#tableInfo').html( "当前范围：" + showLowerBound + "~" + showUpperBound + "/ 共" + count + "条数据");
        });

        function check() {
            var operTimeBegin = $("#operTimeBegin").val();
            var operTimeEnd = $("#operTimeEnd").val();
            if ((operTimeBegin == "" && operTimeEnd != "")
                    || (operTimeBegin != "" && operTimeEnd == "")) {
                alert("操作起始时间作为查询条件，需要成对录入!");
                return false;
            }
            if (operTimeBegin > operTimeEnd) {
                alert("操作结束时间不应早于开始时间!");
                return false;
            }
            $("#search-form").submit();
        }

        function rest() {
            $("#numberType").val("");
            $("#callingNumber").val("");
            $("#calledNumber").val("");
            $("#notesDesc").val("");
            $("#strategyType").val("");
            $("#operTimeBegin").val("");
            $("#operTimeEnd").val("");
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
            <a href="" id="usr-name">Admin</a>
            <span id='login-info' style='cursor:pointer'>...</span>|<a	href="">您好</a>
        </div>
    </div>
    <div id="nav">
        <div id="main-menu" style="position:absolute;left:200px">
            <ul>
                <!--<li <?php if ($this->_tpl_vars['pageselector'] == 'index'): ?> class="active current" <?php endif; ?>><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac">首页</a></li>-->
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/asmac">首页</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/audit">人工审核</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">数据查询</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计</a></li>
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
/manage/audit">历史呼叫查询</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">数据查询</a>
                <ul>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">数据查询</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">数据统计</a>
                <ul>
                    <li  style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataStatistic">数据统计管理</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="ui-layout-center">
    <div id="main" >
        <div class="breadcrumb">
            <span class="cur">我所在的位置：数据查询>>录入数据>>查看</span>
        </div>
        <div class="main-unit">
            <div class="header">
                <span>历史数据列表</span>
            </div>
            <div>
            </div>
            <div class="unit-container">
                <div class="hintmsg">[说明]&nbsp;所有查询条件，均支持模糊查询，输入部分关键字即可。</div>
                <form id='search-form' action="" method='post'>
                    <table class="table-2col uniform-style">
                        <tr>
                            <th>ArName</th>
                            <td>
                                <select id="classname" name="classname" class="ipt-s">
                                    <?php $_from = $this->_tpl_vars['classes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                                    <?php if ($this->_tpl_vars['v'] == $this->_tpl_vars['classname']): ?>
                                    <option selected value="<?php echo $this->_tpl_vars['classname']; ?>
"><?php echo $this->_tpl_vars['classname']; ?>
</option>
                                        <?php else: ?>
                                    <option value='<?php echo $this->_tpl_vars['v']; ?>
'><?php echo $this->_tpl_vars['v']; ?>
</option>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </select>
                            </td>
                            <th>number:</th>
                            <td><input type="text" name='number' id='number' class="ipt-s" value="" /></td>
                        </tr>
                        <tr>
                            <?php $_from = $this->_tpl_vars['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                            <?php if (( $this->_tpl_vars['k']+1 ) % 4 == 0): ?>
                            <th><?php echo $this->_tpl_vars['v']; ?>
</th>
                            <td><input type="text" name='<?php echo $this->_tpl_vars['v']; ?>
' id='<?php echo $this->_tpl_vars['v']; ?>
' class="ipt-s" value="" /></td>
                            </tr><tr>
                            <?php else: ?>
                            <th><?php echo $this->_tpl_vars['v']; ?>
</th>
                            <td><input type="text" name='<?php echo $this->_tpl_vars['v']; ?>
' id='<?php echo $this->_tpl_vars['v']; ?>
' class="ipt-s" value="" /></td>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                    </tr>
                        <hr />
                        <tr>
                            <th>save:<?php echo $this->_tpl_vars['classname']; ?>
</th>
                            <td><input type="text" name='save' id='save' class="ipt-s" value="" /></td>
                            <th>加密项</th>
                            <td><input type="text" name='encryption' id='encryption' class="ipt-s" value="" /></td>
                        </tr>
                    </table>
                    <?php $_from = $this->_tpl_vars['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <th>【<?php echo $this->_tpl_vars['k']; ?>
=></th>
                    <td><?php echo $this->_tpl_vars['v']; ?>
】;</td>
                    <?php endforeach; endif; unset($_from); ?>
                    <th>【保存成功=></th>
                    <td><?php echo $this->_tpl_vars['save']; ?>
】;</td>

                    <center>
                        <div class="btn-container" style="width: 400px">
                            <a class="btn-save" onclick="check()">录入</a>
                            <a class="btn-save" onclick="rest()">重置</a>
                        </div>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>