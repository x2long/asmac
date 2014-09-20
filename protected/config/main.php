<?php
$EBUPT_WEB_BASE_DIR = realpath(dirname(__FILE__).'/../../');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('lib',$EBUPT_WEB_BASE_DIR.'/lib');
$db_config = require_once($EBUPT_WEB_BASE_DIR.'/conf/db_config.php');
$import_config = require_once($EBUPT_WEB_BASE_DIR.'/conf/import_config.php');
$components_config = require_once($EBUPT_WEB_BASE_DIR.'/conf/components_config.php');
$mail_config = require_once($EBUPT_WEB_BASE_DIR.'/conf/mail_config.php');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'asmac',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>$import_config,

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			'ipFilters' => array('127.0.0.1', '*.*.*.*'),
		),
	),

	// application components
	'components'=>array(
		'user'=>$components_config['user'],
		'statePersister' => $components_config['statePersister'],
		'securityManager' => $components_config['securityManager'],
		'urlManager'=>$components_config['urlManager'],
		'db' => $db_config['develop'],
		//'db2' => $db_config['production_1'],
		'authManager'=>$components_config['authManager'],
		'smarty' => $components_config['smarty'],
		'phpExcelFactory' => $components_config['phpExcelFactory'],
        'phpExlWriter' => $components_config['phpExlWriter'],
		'errorHandler'=>$components_config['errorHandler'],
		'log'=>$components_config['log'],
		//'messenger' => $components_config['messenger'],
	),
	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=> array_merge(array(
            // recordFileBaseDir can be string or array
     	    /*
               for string 'recordFileBaseDir' => "dir"
               for array  'recordFileBaseDir' => array('dirnoe','dirtwo')
               notes that : jplayer need know the dir,so best in the same dir with each subdir
	    */ 
	    'recordFilesBaseDir'=> "$EBUPT_WEB_BASE_DIR/public/media",
            'environment'=>"develop",   //develop for mysql and others for informix
        ),$mail_config
    ),
);
