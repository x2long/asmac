<?php /* Smarty version 2.6.26, created on 2014-08-14 21:29:34
         compiled from manage/index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <title>人工审核</title>
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
    <script type="text/javascript" src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/ajaxfileupload.js"></script>
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
    <style type="text/css" media="screen">
        a {
            color: #2B4A78;
            text-decoration: none;
        }

        a:hover {
            color: #2B4A78;
            text-decoration: underline;
        }

        a:focus,input:focus {
            outline-style: none;
            outline-width: medium;
        }
    </style>
    <style type="text/css">
        <!--
        ul{ list-style:none;}
            /*选项卡1*/
        #Tab1{ margin:0px; padding:0px; margin:0 auto;}
            /*选项卡2*/
        #Tab2{ width:576px; margin:0px; padding:0px; margin:0 auto;}
            /*菜单class 346 */
        .Menubox { width:232px; background:url(<?php echo $this->_tpl_vars['base_url']; ?>
/public/images/tab_bg.gif); height:28px; line-height:28px; }
        .Menubox ul{ margin:0px; padding:0px; }
        .Menubox li{ float:left; display:block; cursor:pointer; width:114px; text-align:center; color:#949694; font-weight:bold; }
        .Menubox li.hover{ padding:0px; background:#fff; width:116px; border-left:1px solid #C0C5C1; border-top:1px solid #C0C5C1; border-right:1px solid #C0C5C1;
            background:#DADADA; color:#C0C5C1;; font-weight:bold; height:27px; line-height:27px; }
        .Contentbox{ clear:both; margin-top:0px; border:1px solid #C0C5C1; width:800px; height:200px; text-align:center; padding-top:8px; }
        -->
    </style>
    <script type="text/javascript">
        $(function() {
            $("#v-menu").ebMenu({
                viewMode : "full",
                activeFirstMenu : true
            });
            $('#auditionRecord').dialog({
                autoOpen: false,
                width: 500,
                modal: true
            });
            setTab('one',1,2);
        });
        function auditionRecord(stream_number){
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/getAuditRecords"+"?streamNumber="+stream_number;
            $.getJSON(url,{},function(data) {$("#auditionRecord").html(data);}
            );
            $('#auditionRecord').dialog('open');
        }
        function setTab(name,cursel,n){
            for(i=1;i<=n;i++){
                var menu=document.getElementById(name+i);
                var con=document.getElementById("con_"+name+"_"+i);
                menu.className=i==cursel?"hover":"";
                con.style.display=i==cursel?"block":"none";
            }
        }
        function addNoteOnRecord(stream_number,notes){
            var param = "notes="+notes
                    +"&streamNumber="+stream_number;
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/addNotes" +"?"+param;
            $.getJSON(url,function(data){
                if(data == "true"){
                    alert("备注修改成功！");
                    $("#notesFor-"+stream_number).html("<span style='color:red'><strong>"+notes+"</strong></span>");
                }else{
                    alert("网络异常，请稍后!");
                }
            })
        }
        function addSingle(){
            var phoneType = $("#phoneType").val();
            if ((phoneType == "")) {
                alert("请选择好号码类型！！");
                return false;
            }
            var param = "phoneType="+ phoneType
                    +"&phone_number="+$("#phone_number").val();
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/addSingle" +"?"+param;
            $.getJSON(url,function(data){
                alert(data);
            });
            rest();
        }

        function addBatch(){
            $.ajaxFileUpload({
                url: '<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/addBatch', //用于文件上传的服务器端请求地址
                secureuri: false, //是否需要安全协议，一般设置为false
                fileElementId: 'importFile', //文件上传域的ID
                dataType: 'JSON', //返回值类型 一般设置为json，且都是大写,尤其是在ff和chrome中
                success: function (data, status)  //服务器成功响应处理函数
                {
                    alert(data);
                },
                error: function (data, status, e)//服务器响应失败处理函数
                {
                    alert(e);
                }
            });
            rest();
            return false;
        }
        function fileTypeValidate(obj){
            // 文件后缀
            fileExt = obj.value.substr(obj.value.lastIndexOf(".")).toLowerCase();

            if( !(fileExt == ".xls") ){
                document.getElementById("importFile").value = "";
                alert("请选择Excel文件");
                return false;
            }
        }
        function check() {
            var operTimeBegin = $("#operTimeBegin").val();
            var operTimeEnd = $("#operTimeEnd").val();
            var confirmTimeBegin = $("#confirmTimeBegin").val();
            var confirmTimeEnd = $("#confirmTimeEnd").val();
            if ((operTimeBegin == "" && operTimeEnd != "")|| (operTimeBegin != "" && operTimeEnd == "")
              ||(confirmTimeBegin == "" && confirmTimeEnd != "")|| (confirmTimeBegin != "" && confirmTimeEnd == "")) {
                alert("操作起始时间作为查询条件，需要成对录入!");
                return false;
            }
            if ((operTimeBegin > operTimeEnd)||(confirmTimeBegin > confirmTimeEnd)) {
                alert("操作结束时间不应早于开始时间!");
                return false;
            }
            $("#search-form").submit();
        }
        function rest() {
            $("#phoneType").val("");
            $("#phone_number").val("");
            $("#importFile").val("");
            $("#numberType").val("");
            $("#callingNumber").val("");
            $("#calledNumber").val("");
            $("#notesDesc").val("");
            $("#strategyType").val("");
            $("#operTimeBegin").val("");
            $("#operTimeEnd").val("");
            $("#confirmTimeBegin").val("");
            $("#confirmTimeEnd").val("");
        }
    </script>
    <?php if ($this->_tpl_vars['model']->currentPage == 0): ?>
    <script type="text/javascript">
        $(function(){
            setInterval("getLatest()",60000);
        });

        function getLatest(){
            $.getJSON("<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/getIntervalData", function(result){
                $("#intervalDataBody").html(result);
            });
        }
    </script>
    <?php endif; ?>

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
            $("#confirmTimeBegin").datepicker({
                dateFormat : 'yy-mm-dd'
            });
            $("#confirmTimeEnd").datepicker({
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
                    +"&operTimeEnd=<?php echo $this->_tpl_vars['params']['operTimeEnd']; ?>
"
                    +"&confirmTimeBegin=<?php echo $this->_tpl_vars['params']['confirmTimeBegin']; ?>
"
                    +"&confirmTimeEnd=<?php echo $this->_tpl_vars['params']['confirmTimeEnd']; ?>
"
                    +"&needInterval=<?php echo $this->_tpl_vars['params']['needInterval']; ?>
"
                    +"&";
            if (totalPage > 1) {
                pageNav.url = "" + '?' + params;
                pageNav.pre = "上一页";
                pageNav.next = "下一页";
                pageNav.go(currentPage, totalPage);//共totalPage页
            }
            if(currentPage==1){
                htmlContent="当前范围：" + showLowerBound + "~" + showUpperBound + "/ 共" + count + "条数据";
            }else{
                htmlContent="当前范围：" + showLowerBound + "~" + showUpperBound + "/ 共" + count + "条数据，查看【<a href='<?php echo $this->_tpl_vars['base_url']; ?>
/manage'>最新数据</a>】";

            }
            $('#tableInfo').html(htmlContent);
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
                <li class="active current"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage">人工审核</a></li>
                <li ><a href="<?php echo $this->_tpl_vars['base_url']; ?>
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
            <li class='active'><a href="javascript:void(0)">人工审核</a>
                <ul>
                    <li class='active' style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage">最新数据列表</a></li>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/audit">审核历史查询</a></li>
                </ul>
            </li>
            <li ><a href="javascript:void(0)">数据查询</a>
                <ul>
                    <li style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
/manage/callHistory">历史呼叫查询</a></li>
                    <li  style="display: block"><a href="<?php echo $this->_tpl_vars['base_url']; ?>
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
            <span class="cur">我所在的位置：人工审核</span>
        </div>
        <div class="main-unit">
            <div class="header">
                <span id="header-title"><a >人工审核</a>-录入与查询</span>
            </div>
            <div class="unit-container">
                <div class="hintmsg" style="display:none;">[说明]&nbsp;提供疑似和确认数据录入，支持单条和批量两种模式。</div>
                <table class="table-2col uniform-style">
                    <tr>
                        <td>
                            <div id="Tab1">
                                <div class="Menubox">
                                    <ul>
                                        <li id="one1" onClick="setTab('one',1,2)" ><a class='hover'>单条增加</a></li>
                                        <li id="one2" onClick="setTab('one',2,2)" ><a>批量增加</a></li>
                                        <!--
                                        <li id="one3" onClick="setTab('one',3,3)" ><a>条件查询</a></li>
                                        -->
                                    </ul>
                                </div>

                                <!-- 单条增加 -->
                                <div class="Contentbox">
                                    <div id="con_one_1" class="hover" >
                                        <form id="createStb-form" name="createStb-form" action='' method="get" >
                                            <div id="createStb" style="padding: 5px;">
                                                <table class="table-2col uniform-style">
                                                    <th>号码类型:</th>
                                                    <td>
                                                        <select id="phoneType" name="phoneType" class="ipt-m">
                                                            <option selected value="-1">--请选择--</option>
                                                            <option value='1'>诈骗号码</option>
                                                            <option value='2'>疑似号码</option>
                                                        </select>
                                                    </td>
                                                    <tr>
                                                        <th>电话号码:</th>
                                                        <td><input type="text" name='phone_number' id='phone_number' class="ipt-m" value="" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </form>
                                        <center>
                                            <div class="btn-container" style="width: 300px">
                                                <a class="btn-save" onclick="addSingle()">单条增加</a>
                                                <a class="btn-save" onclick="rest()">重置</a>
                                            </div>
                                        </center>
                                    </div>

                                    <!-- 批量增加 -->
                                    <div id="con_one_2">
                                        <!-- 选择文件div -->
                                        <form id="batchFileStb" name="batchFileStb" action='' method="post" enctype="multipart/form-data" >
                                            <table class="table-2col uniform-style">
                                                <tr>
                                                    <th>注意：批量添加的主要步骤</th>
                                                </tr>
                                                <tr>
                                                    <td>1,下载数据模板；2，提交数据文件</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <a class="btn" href='<?php echo $this->_tpl_vars['base_url']; ?>
/public/templates/Model_kehutousuhaoma.xls' title="友情提示：为了保证操作成功，请务必按照模板填写数据！">导出文件模板</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th>选择文件(每行为一条记录)</th>
                                                    <td>
                                                        <input id="importFile" name="importFile" type="file" class="validate[required]" onchange="javascript:fileTypeValidate(this)"/>
                                                        <span class="required">*</span><span class="hint">(必填信息)</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <div class="btn-container">
                                                            <a class="btn-save" onclick="addBatch()" >批量增加</a>
                                                            <a class="btn-save" onclick="rest()">重置</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>

                                    <!-- 查询 -->
                                    <div id="con_one_3">
                                        <!-- 选择文件div -->
                                        <!--
                                        <form id="search-form" action="<?php echo $this->_tpl_vars['base_url']; ?>
/manage" method='get'>
                                            <table class="table-2col uniform-style" style="width: 800px">
                                                <tr>
                                                    <th>号码状态:</th>
                                                    <td><select id="numberType" name="numberType" class="ipt-s">
                                                        <option selected value="-1">--请选择--</option>
                                                        <option value='all'>ALL</option>
                                                        <option value='fraud'>诈骗</option>
                                                        <option value='normal'>正常</option>
                                                        <option value='yes'>已确认</option>
                                                        <option value='not'>未确认</option>
                                                    </select></td>
                                                    <th>主叫号码:</th>
                                                    <td><input type="text" name='callingNumber' id='callingNumber' class="ipt-s" value="" /></td>
                                                    <th>入库起止时间:</th>
                                                    <td colspan="4">
                                                        <input class="ipt-s" id="operTimeBegin" name="operTimeBegin" value="" />
                                                        <a>&nbsp—&nbsp&nbsp</a>
                                                        <input class="ipt-s" id="operTimeEnd" name="operTimeEnd" value="" />
                                                    </td>
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
                                                    <th>被叫号码:</th>
                                                    <td><input type="text" name='calledNumber' id='calledNumber' class="ipt-s" value="" /></td>
                                                    <th>审核起止时间:</th>
                                                    <td colspan="4">
                                                        <input class="ipt-s" id="confirmTimeBegin" name="operTimeBegin" value="" />
                                                        <a>&nbsp—&nbsp&nbsp</a>
                                                        <input class="ipt-s" id="confirmTimeEnd" name="operTimeEnd" value="" />
                                                        <input style="display:none;" type="text" name='needInterval' id='needInterval' class="ipt-s" value="false" />
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
                                        -->
                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="main-unit">
            <div class="header">
                <span>最新数据</span>
            </div>
            <div>
            </div>
            <div class="unit-container">
                <div class="hintmsg" style="display:none;">[说明]&nbsp;展示最新的15条数据。</div>
                <table id="entity-table" class="table-complex table-imgbtn highlight">
                    <thead>
                    <tr>
                        <th>主叫号码</th>
                        <th>首次疑似呼叫时间</th>
                        <th>最后疑似呼叫时间</th>
                        <th>疑似呼叫次数</th>
                        <th>状态</th>
                        <th>审核结果</th>
                        <th>取证样本</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody id="intervalDataBody">
                    <?php $_from = $this->_tpl_vars['suspect_records']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    <?php if ($this->_tpl_vars['k']%2 == 0): ?>
                    <tr class='even'>
                        <?php else: ?>
                    <tr class='odd'>
                        <?php endif; ?>
                        <td><?php echo $this->_tpl_vars['v']['phone_number']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['start_time']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['end_time']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['v']['call_times']; ?>
</td>
                        <td id="numstate-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['num_state']; ?>
</td>
                        <td id="illegalType-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['illegal_type']; ?>
</td>
                        <td>
                            <a class="opt-edit opt" href="javascript:auditionRecord('<?php echo $this->_tpl_vars['v']['stream_number']; ?>
')" title="编辑">试听</a>
                        </td>
                        <td id="notesFor-<?php echo $this->_tpl_vars['v']['stream_number']; ?>
"><?php echo $this->_tpl_vars['v']['susdesc']; ?>
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
        <div id ="auditionRecord" title="试听录音列表" class="main-unit"></div>
    </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>