<?php
define("KARENDERIA","KARENDERIA");

return array(
	'name'=>'Karinderia',
	
	'defaultController'=>'store',
		
	'import'=>array(
		'application.models.*',
		'application.models.admin.*',
		'application.components.*',
		'application.vendor.*'
	),
	
	'language'=>'default',		
			
	'components'=>array(
		/*'urlManager'=>array(
			'urlFormat'=>'path',			
		),*/
	    'urlManager'=>array(
		    'urlFormat'=>'path',
		    'rules'=>array(
		        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
		        '<controller:\w+>'=>'<controller>/index',
		        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',		        
		    ),
		    'showScriptName'=>false,
		),
				
		'db'=>array(	        
		    'class'            => 'CDbConnection' ,
			'connectionString' => 'mysql:host=localhost;dbname=restaurant',
			'emulatePrepare'   => true,
			'username'         => 'root',
			'password'         => '',
			'charset'          => 'utf8',
			'tablePrefix'      => 'rt_',
	    ),
	    
	    'functions'=> array(
	       'class'=>'Functions'	       
	    ),
	    'validator'=>array(
	       'class'=>'Validator'
	    )
	),
);

function status_list()
{
	return array(
	 'publish'=>Yii::t("default",'Publish'),
	 'pending'=>Yii::t("default",'Pending for review'),
	 'draft'=>Yii::t("default",'Draft')
	);
}

function client_status()
{
	return array(
	 'active'=>Yii::t("default",'active'),
	 'suspended'=>Yii::t("default",'suspended'),
	 'blocked'=>Yii::t("default",'blocked')
	);
}
?>