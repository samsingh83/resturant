<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/css/admin.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" />

<link rel="shortcut icon" href="<?php echo  Yii::app()->request->baseUrl; ?>/favicon.ico" />

<!--START Google FOnts-->
<link href='//fonts.googleapis.com/css?family=Open+Sans|Podkova|Rosario|Abel|PT+Sans|Source+Sans+Pro:400,600,300|Roboto' rel='stylesheet' type='text/css'>
<!--END Google FOnts-->

<!--START BOOTSTRAP-->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="//cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
<!--END BOOTSTRAP-->

<!--FONT AWESOME-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<!--END FONT AWESOME-->


<!--STARTS JQPLOT-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/jqplot/jquery.jqplot.min.css" rel="stylesheet">
<!--END JQPLOT-->

<!--UIKIT-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/uikit.gradient.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.addons.min.css" rel="stylesheet" />
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/css/addons/uikit.gradient.addons.min.css" rel="stylesheet" />
<!--UIKIT-->

<!--COLOR PICK-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/colorpick/css/colpick.css" rel="stylesheet" />
<!--COLOR PICK-->

<!--ICHECK-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/iCheck/skins/all.css" rel="stylesheet" />
<!--ICHECK-->

<link href="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/chosen/chosen.css" rel="stylesheet" />

</head>
<body>


<div class="login-wrapper">
<?php echo $content;?>
</div>

</body>

<script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>  
<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/admin/ajax';
var upload_url='<?php echo Yii::app()->request->baseUrl;?>/upload';
var admin_url='<?php echo Yii::app()->request->baseUrl;?>/admin';
var sites_url='<?php echo Yii::app()->request->baseUrl;?>';
<?php $js_lang=Yii::app()->functions->jsLanguageAdmin();?>
var js_lang=<?php echo json_encode($js_lang)?>;
</script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/fnReloadAjax.js" type="text/javascript"></script>


<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/JQV/form-validator/jquery.form-validator.min.js" type="text/javascript"></script>

<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.ui.timepicker-0.0.8.js" type="text/javascript"></script>


<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/js/uploader.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/ajaxupload/fileuploader.js" type="text/javascript"></script>


<!--START JQPLOT-->
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/jquery.jqplot.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/excanvas.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.barRenderer.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.categoryAxisRenderer.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.pointLabels.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.json2.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>

<!--END JQPLOT-->

<script src="//cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>

<!--BOOSTRAP-->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!--END BOOSTRAP-->

<?php if ( Yii::app()->controller->getAction()->getId()=="events" || Yii::app()->controller->getAction()->getId()=="reservation" || Yii::app()->controller->getAction()->getId()=="addpage" ):?>
<!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.css" />
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.min.css" />
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/marked-master/marked.min.js"></script>
<?php endif;?>

<!--UIKIT-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/uikit.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/notify.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/sticky.min.js"></script>
<?php if ( Yii::app()->controller->getAction()->getId()=="events" || Yii::app()->controller->getAction()->getId()=="reservation" || Yii::app()->controller->getAction()->getId()=="addpage" ):?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/vendor/uikit/js/addons/htmleditor.js"></script>
<?php endif;?>
<!--UIKIT-->

<!--COLOR PICK-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/colorpick/js/colpick.js"></script>
<!--COLOR PICK-->

<!--ICHECK-->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/iCheck/icheck.js"></script>
<!--ICHECK-->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jQuery.jPlayer.2.6.0/jquery.jplayer.min.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/jquery.printElement.min.js"></script>


<?php if (Yii::app()->controller->getAction()->getId()=="home" || Yii::app()->controller->getAction()->getId()=="RptSalesReport"):?>
<!--Google Maps-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<!--END Google Maps-->
<?php endif;?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin.js?ver=1" type="text/javascript"></script>  

</html>