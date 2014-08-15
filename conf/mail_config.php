<?php

$defaultCc = '';
$defaultVipCc = '';

return array(
	'LARGE_WITHDRAW_AMOUNT' => 5000,
	'MAIL_FROM' => 'Eblib_admin@ebupt.com',
	'MAIL_FROM_NAME' => 'SiWen Team',
	'REMIND_SETTINGS' => array (
		'remindToGetInvoice' => array(
			'pendingTime' => 7 * 24 * 3600,
		),		
	),
	'MAIL_SETTINGS' => array (
		'resetPassword' => array(
     		//'disabled' => false,
			'to'=>'',
			'cc'=>$defaultCc,
			'vipcc'=>$defaultVipCc,
			'subject'=>'SiWen密码重置',
			'template'=>'resetPassword.htm',
			//'attachments'=>array(),
		),
        'confirmRegister' => array(
            //'disabled' => false,
            'to'=>'',
            'cc'=>$defaultCc,
            'vipcc'=>$defaultVipCc,
            'subject'=>'SiWen注册确认',
            'template'=>'confirmRegister.htm',
            //'attachments'=>array(),
        ),
	),
);
