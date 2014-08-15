<?php /* Smarty version 2.6.26, created on 2014-08-14 13:36:50
         compiled from commonUtils/_statisticsChartsJs.html */ ?>
<script type="text/javascript">
    function createPie(){
        Highcharts.getOptions().plotOptions.pie.colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
            return {
                radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
                stops: [
                    [0, color],
                    [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });
        $('#strategyAnalysePie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: "<?php echo $this->_tpl_vars['charData']['charName'][0]; ?>
"
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    },
                    events: {
                        click: function(e){
                            //alert(e.point.name+"xxl"+e.point.y);
                            showGridsTable(<?php echo $this->_tpl_vars['params']['tabNum']; ?>
,"<?php echo $this->_tpl_vars['params']['kindsType']; ?>
",e.point.name,<?php echo $this->_tpl_vars['params']['operTimeBegin']; ?>
,<?php echo $this->_tpl_vars['params']['operTimeEnd']; ?>
);
                            //showGridsTable(<?php echo $this->_tpl_vars['params']['tabNum']; ?>
,"name",e.point.name,<?php echo $this->_tpl_vars['params']['operTimeBegin']; ?>
,<?php echo $this->_tpl_vars['params']['operTimeEnd']; ?>
);
                        }
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: "<?php echo $this->_tpl_vars['charData']['seriesName'][0]; ?>
",
                data: [
                    <?php $_from = $this->_tpl_vars['charData']['data']['pie']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                    ["<?php echo $this->_tpl_vars['k']; ?>
",  <?php echo $this->_tpl_vars['v']; ?>
],
        <?php endforeach; endif; unset($_from); ?>
        ]
        }]
    });
    }

    function createColumn(){
        $('#strategyAnalyseColumn').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: "<?php echo $this->_tpl_vars['charData']['charName'][1]; ?>
"
            },
            subtitle: {
                text: 'Source: www.ebupt.com'
            },
            xAxis: {
                categories: [
                    "该时段内"
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: '<?php echo $this->_tpl_vars['charData']['seriesName'][1]; ?>
'+'(次)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} 次</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column:{
                    dataLabels:{
                        enabled:false //是否显示数据标签
                    },
                    events: {
                        click: function(e){
                            // alert(e.point.series.name+"xxl"+e.point.y);
                            //showGridsTable(tabNum,type,partName,operTimeBegin,operTimeEnd);
                            showGridsTable(<?php echo $this->_tpl_vars['params']['tabNum']; ?>
,"<?php echo $this->_tpl_vars['params']['kindsType']; ?>
",e.point.series.name,<?php echo $this->_tpl_vars['params']['operTimeBegin']; ?>
,<?php echo $this->_tpl_vars['params']['operTimeEnd']; ?>
);
                        }
                    }
                },
                series: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [
                <?php $_from = $this->_tpl_vars['charData']['data']['column']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
        {
            name: "<?php echo $this->_tpl_vars['k']; ?>
",
                    data: [<?php echo $this->_tpl_vars['v']; ?>
]

    },
    <?php endforeach; endif; unset($_from); ?>
    ]
    });
    }
</script>