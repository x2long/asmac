<?php

return array(
	'develop'=>array(
		'class'=>'system.db.CDbConnection',
		'connectionString' => 'mysql:host=localhost;port=4428;dbname=asmac',
		'emulatePrepare' => true,
		'username' => 'root',
		'password' => '123456',
		'charset' => 'utf8',
	),
    'production_0' => array(
        //'connectionString' => 'informix:host=host;service=port;database=database;server=server;protocol=onsoctcp;CLIENT_LOCALE=en_US.utf8;DB_LOCALE=en_US.8859-1;EnableScrollableCursors=1',
        'connectionString' => 'informix:server=dbserver1; service=7779;database=asmac_zj;protocol=onsoctcp;CLIENT_LOCALE=en_US.819;DB_LOCALE=en_US.819;EnableScrollableCursors=1',
        'username' => 'asmaczj',
        'password' => '1qaz@WSX',
        'class' => 'lib.extensions.yiinformix.CInformixConnection',
        //'charset' => 'utf8',
        'emulatePrepare' => true,
        'initSQLs' => array(
            //"SET NAMES 'UTF-8'",
        ),
    ),
    'production_1' => array(
        //'connectionString' => 'informix:host=host;service=port;database=database;server=server;protocol=onsoctcp;CLIENT_LOCALE=en_US.utf8;DB_LOCALE=en_US.8859-1;EnableScrollableCursors=1',
        'connectionString' => 'informix:server=dbserver1; service=7779;database=asmac_zj;protocol=onsoctcp;CLIENT_LOCALE=en_US.819;DB_LOCALE=en_US.819;EnableScrollableCursors=1',
        'username' => 'asmaczj',
        'password' => '1qaz@WSX',
        'class' => 'lib.extensions.yiinformix.CInformixConnection',
        //'charset' => 'utf8',
        'emulatePrepare' => true,
        'initSQLs' => array(
            //"SET NAMES 'UTF-8'",
        ),
    ),
);
