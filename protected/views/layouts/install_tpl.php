<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico" />

<!--START Google FOnts-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Podkova|Rosario|Abel|PT+Sans|Source+Sans+Pro:400,600,300|Roboto' rel='stylesheet' type='text/css'>
<!--END Google FOnts-->

<!--START BOOTSTRAP-->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!--END BOOTSTRAP-->

<!--FONT AWESOME-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<!--END FONT AWESOME-->


<!--STARTS JQPLOT-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jqplot/jquery.jqplot.min.css" rel="stylesheet">
<!--END JQPLOT-->

</head>
<body>

<div class="header">   
   <a class="site_title" href="#">
   <?php echo CHtml::encode($this->pageTitle); ?>
   </a>  
</div>

<div class="body_wrap">
<div class="menu_left">
</div>
<div class="main_content" style="padding:80px 20px;">  
  <?php echo $content;?>
  </div> <!--END main_conten_inner-->
</div> <!--END main_content-->
<div class="clear"></div>
</div> <!--END body_wrap-->


</body>

<script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>  

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.1.38/jquery.form-validator.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker-0.0.8.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin.js?ver=1" type="text/javascript"></script>  

<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/install/ajax';
var upload_url='<?php echo Yii::app()->request->baseUrl;?>/upload';
var admin_url='<?php echo Yii::app()->request->baseUrl;?>/admin';
</script>

</html>