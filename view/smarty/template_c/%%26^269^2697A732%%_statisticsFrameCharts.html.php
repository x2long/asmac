<?php /* Smarty version 2.6.26, created on 2014-08-15 21:18:01
         compiled from manage/_statisticsFrameCharts.html */ ?>
<head>
    <script type="text/javascript">
        $(function (){
            $("#operTimeBegin").datepicker({
                dateFormat : 'yy-mm-dd'
            });
            $("#operTimeEnd").datepicker({
                dateFormat : 'yy-mm-dd'
            });
            showCharts(<?php echo $this->_tpl_vars['model']->page_selector; ?>
,null,null,null);
        });

        function showCharts(tabNum,kindsType,operTimeBegin,operTimeEnd){
            //根据具体情况去获取数据，绘图用的,查询口径统一
            var param = "tabNum="+tabNum
                    +"&kindsType="+kindsType
                    +"&operTimeBegin="+operTimeBegin
                    +"&operTimeEnd="+operTimeEnd;
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/getChartsData" +"?"+param;
            $.getJSON(url,function(data){
                if(data !== ""){
                    $("#chartJs").html(data);
                    //名字每次都变的，应该由其他来生成
                    createPie();
                    createColumn();
                    clearStatisticData();
                }else{
                    alert("网络异常，请稍后!");
                }
            })
        }
        function clearStatisticData(){
            $("#tableInfo").html("");
            $("#pageNavForAjax").html("");
            $("#intervalDataBody").html("");
        }
        //显示具体列表信息，也要根据数据来查询
        function showGridsTable(tabNum,kindsType,partName,operTimeBegin,operTimeEnd){
            var param = "tabNum="+tabNum
                    +"&kindsType="+kindsType
                    +"&partName="+partName
                    +"&operTimeBegin="+operTimeBegin
                    +"&operTimeEnd="+operTimeEnd;
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/manage/getStatisticsGrids" +"?"+param;
            $.getJSON(url, function(result){
                clearStatisticData();
                $("#intervalDataBody").html(result);
            });
        }

        function check(){
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
            if(operTimeBegin == "" ){
                operTimeBegin = null;
                operTimeEnd =null;
            }
            var kindsType = ""+$("#kindsType").val();
            //以所填规则去访问数据
            showCharts(<?php echo $this->_tpl_vars['model']->page_selector; ?>
,kindsType,operTimeBegin,operTimeEnd);
        }

        function rest() {
            $("#strategyType").val("");
            $("#operateType").val("");
            $("#operTimeBegin").val("");
            $("#operTimeEnd").val("");
        }
    </script>
</head>
<div id="chartJs"></div>
<div  class="main-unit" style="min-height: 30%">
    <div class="header">
        <span>
            <?php echo $this->_tpl_vars['model']->tabTitle; ?>

        </span>
    </div>
    <div class="unit-container" style="width:69%;float:left">
        <div class="hintmsg">[说明]&nbsp;所有查询条件，均支持模糊查询，输入部分关键字即可。</div>
        <form id='search-form' action="" method='get'>
            <table class="table-2col uniform-style">
                <tr>
                    <?php if ($this->_tpl_vars['model']->page_selector == 3): ?>
                    <th>选择策略:</th>
                    <td><select id="kindsType" name="kindsType" class="ipt-s">
                        <option selected value="-1">--请选择--</option>
                        <option value='3'>公检法</option>
                        <option value='4'>特服</option>
                        <option value='2'>110尾号</option>
                        <option value='1'>公众举报</option>
                        <option value='all'>全部</option>
                    </select></td>
                    <?php elseif ($this->_tpl_vars['model']->page_selector == 2): ?>
                    <th>选择类型:</th>
                    <td><select id="kindsType" name="kindsType" class="ipt-s">
                        <option selected value="-1">--请选择--</option>
                        <option value='fraud'>诈骗号码</option>
                        <option value='normal'>正常号码</option>
                        <option value='nandf'>正常+诈骗号码</option>
                        <option value='not'>未确认</option>
                        <option value='all'>全部</option>
                    </select></td>
                    <?php else: ?>
                    <th>选择数据源:</th>
                    <td><select id="kindsType" name="kindsType" class="ipt-s">
                        <option selected value="-1">--请选择--</option>
                        <option value='1'>网间国际</option>
                        <option value='2'>网间非国际</option>
                        <option value='3'>A口国际</option>
                        <option value='4'>SCP</option>
                        <option value='all'>所有</option>
                    </select></td>
                    <?php endif; ?>
                    <th>查询时间:</th>
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
    </div>
    <div id="strategyAnalysePie"  align="center" style="width:40%;height:60%;float:left;margin:0 5%">
        The chart will appear within this DIV. This text will be replaced by the chart.
    </div>
    <div id="strategyAnalyseColumn"  align="center" style="width:40%;height:60%;float:left;margin:0 5%">
        The chart will appear within this DIV. This text will be replaced by the chart.
    </div>
    <div style="clear:both"></div>
</div>
<div  class="main-unit" style="min-height: 10%">
    <div class="header">
        <span>明细信息总览</span>
    </div>
    <div class="unit-container" style="width:99%;float:left">
        <table id="detail-table" class="table-complex table-imgbtn highlight">
            <thead>
            <tr>
                <th>主叫号码</th>
                <?php if ($this->_tpl_vars['model']->page_selector == 3): ?>
                <th>入库时间</th>
                <th>拦截截止时间</th>
                <th>拦截次数</th>
                <?php else: ?>
                <th>呼叫开始时间</th>
                <th>呼叫结束时间</th>
                <th>呼叫次数</th>
                <?php endif; ?>
                <th>策略</th>
                <th>备注</th>
            </tr>
            </thead>
            <tbody id="intervalDataBody"></tbody>
        </table>
        <div style="width: 95%; height: 30px" >
            <div id="tableInfo" class="normal_info" style="height: 30px; position: absolute; left: 30px"></div>
            <!-- 分页实现 -->
            <div id="pageNavForAjax" style="position: absolute; right: 25px"></div>
            <!-- 分页实现 -->
            <a style="display:none;" id= "ajaxAttrProps" totalPage="6" countPerPage="10"></a>
        </div>
    </div>
    <div style="clear:both"></div>
</div>
<div style="clear:both"></div>