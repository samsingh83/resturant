<?php
/*******************************************
@author : bastikikang 
@author email: basti@codemywebapps.com
@author website : http://codemywebapps.com
*******************************************/

/* ********************************************************
 *   Restaurant Made Easy Version 1.0.1
 *   Last Update June 5,2014   V.1.0.2
 *   Last Update June 22,2014  V.1.0.3
 *   Last Update June 28,2014  V.1.0.4
 *   Last Update Aug 1,2014  V.1.0.5
 *   Last Update Oct. 10,2014  V.1.0.6
 *   Last Update Feb. 03,2015  V.1.0.7
 ***********************************************************/

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_ENABLE_EXCEPTION_HANDLER', false);
ini_set("display_errors",true);

// include Yii bootstrap file
require_once(dirname(__FILE__).'/yiiframework/yii.php');
$config=dirname(__FILE__).'/protected/config/main.php';

// create a Web application instance and run
Yii::createWebApplication($config)->run();