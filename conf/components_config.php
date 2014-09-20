<?php
return array(
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
            'stateKeyPrefix' => 'ebupt_asmac_id_',
            'loginUrl'=>array('site/index'),
        ),
        'statePersister' => array(
            'stateFile' => $EBUPT_WEB_BASE_DIR.'/protected/runtime/state.bin',
        ),
        'securityManager' => array(
            'validationKey' => 'ebupt_validate_key@#>2014<#@ebupt.com'
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
            'showScriptName'=>false,
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),

        'smarty' => array(
            'class'=>'lib.extensions.CSmarty',
            'templatePath' => $EBUPT_WEB_BASE_DIR.'/view',
        ),

        'phpExcelFactory'=>array(
            'class'=>'lib.extensions.CPhpExcelFactory',
        ),

        'phpExlWriter'=>array(
            'class'=>'lib.extensions.PhpExlWrite',
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'/',
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                    'categories' => 'system',
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'kaoqin.system.wf.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'profile,trace,error',
                    'categories' => 'application',
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'asmac.wf.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info',
                    'categories' => 'application',
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'asmac.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'debug, trace',
                    'categories' => 'application.*',
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'asmac.debug.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'debug, trace',
                    'categories' => 'dto',
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'asmac.dto.log',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'profile,info',     //级别为trace时跟踪数据库访问细节
                    'categories'=>'system.db.*', //只显示关于数据库信息,包括数据库连接,数据库执行语句
                    'logPath' => $EBUPT_WEB_BASE_DIR.'/log',
                    'logFile' => 'asmac.sql.log',
                ),
            ),
        ),
		
		'messenger' => array(
			'class' => 'lib.common.EbuptMessenger',
			'mailer' => 'smtp',
			'options' => array(
				'auth' => true,
				'host' => 'smtp.exmail.qq.com',
				'username' => 'Eblib_admin@ebupt.com',
				'password' => '1qaz@WSX',
			),
		),
);
