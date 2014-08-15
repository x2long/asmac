<?php /* Smarty version 2.6.26, created on 2014-08-14 13:33:00
         compiled from site/index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo $this->_tpl_vars['base_url']; ?>
/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="public/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="public/js/jquery.validationEngine-cn.js"></script>
<script type="text/javascript" src="public/js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="public/js/jquery.qtip.min.js"></script>
<link href="public/css/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<link href="public/css/jquery.qtip.min.css" rel="stylesheet" type="text/css" />
<link href="public/css/login.css" rel="stylesheet" type="text/css" />
<link href="public/css/style.css" rel="stylesheet" type="text/css" />
<title>国际诈骗电话管理平台</title>
<script type="text/javascript">
$(document).ready(function () {
    $("#login-form").validationEngine();
});
</script>
</head>
 <body>
<div id="login-panel">
    <div class="form">
        <div class="err">
            <?php if (! empty ( $this->_tpl_vars['model']->errorInfo )): ?>
            <div class="errorMessage">
                <div class="message-container">
                    <div class="msg-fail png_bg">
                        <?php echo $this->_tpl_vars['model']->errorInfo; ?>

                        <a class="close" onclick="$(this).parent().fadeOut('fast',function(){$(this).remove();});">关闭</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <form id="login-form" action="" method="post">
        <table>
            <tr>
                <th>用户名</th>
                <td ><input style="width:170px;" id="uid" name="j_username" class="validate[required]" value=""/></td>
            </tr>
            <tr>
                <th>密码</th>
                <td ><input type="password" style="width:170px;" id="password" name="j_password" class="validate[required]"/></td>
            </tr>
            <tr><td colspan=2 align='center'>
                <input id="btn-login" value="" type="submit" style="border:0px;margin-right:10px"/></td>
            </tr>
        </table>
        </form>
    </div>
</div>
</body>
</html>