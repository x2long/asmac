<?php /* Smarty version 2.6.26, created on 2014-08-15 20:43:28
         compiled from manage/_recordList.html */ ?>
<head>
    <link rel="stylesheet" href="<?php echo $this->_tpl_vars['base_url']; ?>
/public/css/jQuery.jPlayer/blue.monday/jplayer.blue.monday.css" type="text/css" media="all" />
    <script src="<?php echo $this->_tpl_vars['base_url']; ?>
/public/js/music/jquery.jplayer.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $("#v-menu").ebMenu({
                viewMode : "full",
                activeFirstMenu : true
            });
            $('#showRecordPlayer').dialog({
                autoOpen: false,
                width: 500,
                modal: true,
                close: function() {
                    $("#jquery_jplayer_1").jPlayer("stop");
                }
            });
        });
        function showRecordPlayer(name){
            $("#jquery_jplayer_1").jPlayer("clearMedia");
            $("#jquery_jplayer_1").jPlayer("destroy");
            $("#jquery_jplayer_1").jPlayer({
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        title:name,
                        mp3: "<?php echo $this->_tpl_vars['base_url']; ?>
/public/media/"+name,
                        wav: "<?php echo $this->_tpl_vars['base_url']; ?>
/public/media/"+name
                    }).jPlayer("play"); // auto play
                },
                ended: function (event) {
                    $(this).jPlayer("play");
                },
                swfPath: "<?php echo $this->_tpl_vars['base_url']; ?>
/public/swf",
                supplied: "mp3,wav",
                fullScreen: true,
                wmode: "window",
                smoothPlayBar: true,
                keyEnabled: true,
                remainingDuration: true,
                toggleDuration: true
            }).bind($.jPlayer.event.play, function() { // pause other instances of player when current one play
                $(this).jPlayer("pauseOthers");
            });
            $('#showRecordPlayer').dialog('open');
        }
        function confirmTheNum(type){
            var param = "streamNumber=<?php echo $this->_tpl_vars['streamNumber']; ?>
" +"&type="+type;
            var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/makeRecordAudited" +"?"+param;
            $.getJSON(url,function(data){
                if(data[0] == "true"){
                    alert("审核提交成功！");
                    $('#auditionRecord').dialog('close');
                    //hit red and close
                    $("#numstate-"+data[1]).html(data[2]);
                    $("#illegalType-"+data[1]).html(data[3]);
                }else{
                    alert("网络异常，请稍后!");
                }
            })
        }
        function confirmNums(){
            var phoneType = $("#phone_type").val();
            confirmTheNum(phoneType);
            var notes = $("#notesFor-input").val();
            if(notes !=""){
                addNoteOnRecord('<?php echo $this->_tpl_vars['streamNumber']; ?>
',notes);
            }
        }
        function confirmDelete(){
            var msg = "您确认删除该数据?\n系统将默认删除有关疑似和确认的所有数据，请谨慎操作！";
            if (confirm(msg)==true){
                $("#delete").hide();
                var param = "streamNumber=<?php echo $this->_tpl_vars['streamNumber']; ?>
";
                var url = "<?php echo $this->_tpl_vars['base_url']; ?>
/commonUtils/makeRecordDeleted" +"?"+param;
                $.getJSON(url,
                        function(json){
                            if(json>=0){
                                alert("清除历史日志数据成功！\n共清除[" + json + "]条数据。");
                            }else{
                                alert("网络异常，请稍后!");
                            }
                            rest();
                            $("#search-form").submit();
                        });
            }
        }
        function showForChoose() {
            var phoneType = $("#phone_type").val();
            var infoArray =new Array("正常号码，可以不填描述","诈骗电话，备注填写诈骗场景","填写诈骗的数量，正常的数量","注意根据不同情况，输入具体要求内容");
            $("#forChoose").html("<span style='color:red'><strong>"+infoArray[phoneType]+"</strong></span>");
            if(phoneType==2){
                //$("#notesFor-input").attr("placeholder","test");
                $("#notesFor-input").val("正常： x 次，诈骗： y 次");
            }
        }
    </script>
</head>
<div class="unit-container">
    <form id="attach-form" name="attach-form" action="" method="post">
    <table id="attach-table" class="table-complex table-imgbtn highlight">
        <thead>
        <tr>
            <th>录音列表</th>
            <th>Time</th>
            <th>播放</th>
            <th>描述信息</th>
        </tr>
        </thead>
        <tbody>
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
            <td>
                <a class="opt-play opt" href="javascript:showRecordPlayer('<?php echo $this->_tpl_vars['v']['record_name']; ?>
')" title="播放">试听</a>
            </td>
            <td><?php echo $this->_tpl_vars['v']['susdesc']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
    </form>
    <hr>
    <?php if ($this->_tpl_vars['auditOper'] != 'none'): ?>
    <table class="table-2col" style="width:400px;">
        <tr>
            <th>审核类型:</th>
            <td>
                <select id="phone_type" name="phone_type" class="ipt-m" onchange="javascript:showForChoose()">
                    <option selected value="3">--请选择--</option>
                    <option value='1'>诈骗号码</option>
                    <option value='0'>正常号码</option>
                    <option value='2'>正常+诈骗号码</option>
                </select>
            </td>
        </tr>
        <tr>
            <th>输入提示:</th>
            <td id="forChoose">
                注意根据不同情况，输入具体要求内容
            </td>
        </tr>
        <tr>
            <th>号码描述:</th>
            <td><input type="text" name='operModule' id='notesFor-input' class="ipt-m" value="" /></td>
        </tr>
    </table>
    <div class="btn-container" style="margin-left: 10px" >
        <a class="btn-save" onclick="confirmNums();">提交审核</a>
        <a style="display:none;" class="btn-del" onclick="confirmDelete();">删除号码</a>
    </div>
    <?php endif; ?>
</div>
<div id ="showRecordPlayer" title="试听录音播放" class="main-unit">
    <div id="jquery_jplayer_1" class="jp-jplayer"></div>
    <div id="jp_container_1" class="jp-audio">
        <div class="jp-type-single">
            <div class="jp-gui jp-interface">
                <ul class="jp-controls">
                    <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                    <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                    <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                    <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                    <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                    <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                </ul>
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
                <div class="jp-time-holder">
                    <div class="jp-current-time"></div>
                    <div class="jp-duration"></div>

                    <ul class="jp-toggles">
                        <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                        <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                    </ul>
                </div>
            </div>
            <div class="jp-details">
                <ul>
                    <li><span class="jp-title"></span></li>
                </ul>
            </div>
            <div class="jp-no-solution">
                <span>Update Required</span>
                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
            </div>
        </div>
    </div>

</div>