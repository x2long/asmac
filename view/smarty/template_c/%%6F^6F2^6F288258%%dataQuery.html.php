<?php /* Smarty version 2.6.26, created on 2014-08-15 21:19:12
         compiled from manage/dataQuery.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>数据查询</title>
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
            <a href="" id="usr-name"><?php echo $this->_tpl_vars['model']->username; ?>
</a>
            <span id='login-info' style='cursor:pointer'>...</span>|<a	href="<?php echo $this->_tpl_vars['base_url']; ?>
/site/logout">退出</a>
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
/manage">人工审核</a></li>
                <li class="active current"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">数据查询</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
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
            <li class='active'><a href="javascript:void(0)">数据查询</a>
            <ul>
                <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/callHistory">历史呼叫查询</a></li>
                <li class='active' style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery">历史拦截查询</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">数据统计</a>
                <ul>
                    <li  style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
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
        <div class="breadcrumb">
            <span class="cur">我所在的位置：数据查询>>拦截信息>>查看</span>
        </div>
        <div class="main-unit">
            <div class="header">
                <span>确认信息列表</span>
            </div>
            <div>
            </div>
            <div class="unit-container">
                <div class="hintmsg">[说明]&nbsp;所有查询条件，均支持模糊查询，输入部分关键字即可。</div>
                <form id='search-form' action="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/dataQuery" method='get'>
                    <table class="table-2col uniform-style" style="width: 760px">
                        <tr>
                            <th>号码状态:</th>
                            <td><select id="numberType" name="numberType" class="ipt-s">
                                <option selected value="-1">--请选择--</option>
                                <option value='fraud'>诈骗号码</option>
                                <option value='normal'>正常号码</option>
                                <option value='nandf'>正常+诈骗号码</option>
                                <option value='all'>全部</option>
                            </select></td>
                            <th>触发省份:</th>
                            <td><select id="chuFaSheFen" name="chuFaSheFen" class="ipt-s">
                                <option selected value="-1">--请选择--</option>
                                <option value='1'>公众举报</option>
                                <option value='2'>110尾号</option>
                                <option value='3'>公检法号码</option>
                                <option value='4'>特服尾号</option>
                                <option value='all'>ALL</option>
                            </select></td><th>主叫号码:</th>
                            <td><input type="text" name='callingNumber' id='callingNumber' class="ipt-s" value="" /></td>
                        </tr>
                        <tr>
                            <th>策略类型:</th>
                            <td><select id="strategyType" name="strategyType" class="ipt-s">
                                <option selected value="-1">--请选择--</option>
                                <option value='3'>公检法</option>
                                <option value='4'>特服</option>
                                <option value='2'>110尾号</option>
                                <option value='1'>公众举报</option>
                                <option value='all'>全部</option>
                            </select></td>
                            <th>运营商类型:</th>
                            <td><select id="yunYinType" name="yunYinType" class="ipt-s">
                                <option selected value="-1">--请选择--</option>
                                <option value='1'>中国移动</option>
                                <option value='2'>中国联通</option>
                                <option value='3'>全部</option>
                            </select></td>
                            <th>起始时间:</th>
                            <td colspan="4">
                                <input class="ipt-s" id="operTimeBegin" name="operTimeBegin" value="" />
                                <a>&nbsp—&nbsp&nbsp</a>
                                <input class="ipt-s" id="operTimeEnd" name="operTimeEnd" value="" />
                            </td>
                        </tr>
                    </table>

                    <center>
                        <div class="btn-container" style="width: 400px">
                            <a class="btn-save" onclick="check()">查询</a>
                            <a class="btn-save" onclick="rest()">重置</a>
                        </div>
                    </center>
                </form>
                <table id="entity-table" class="table-complex table-imgbtn highlight">
                    <thead>
                    <tr>
                        <th>主叫号码</th>
                        <th>拦截截止时间</th>
                        <th>拦截次数</th>
                        <th>策略类型</th>
                    </tr>
                    </thead>
                    <tbody id="intervalDataBody">
                    <?php $_from = $this->_tpl_vars['kinds_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <?php if ($this->_tpl_vars['k']%2 == 0): ?>
                    <tr class='even'>
                        <?php else: ?>
                    <tr class='odd'>
                        <?php endif; ?>
                        <td><?php echo $this->_tpl_vars['v']['phone_number']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['intercept_valid']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['intercept_times']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['illegal_type']; ?>
</td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?>
                    </tbody>
                </table>
                <div style="width: 100%; height: 30px">
                    <div id="tableInfo" class="normal_info" style="height: 30px; position: absolute; left: 20px"></div>
                    <!-- 分页实现 -->
                    <div id="pageNav" style="position: absolute; right: 20px"></div>
                    <!-- 分页实现 -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>