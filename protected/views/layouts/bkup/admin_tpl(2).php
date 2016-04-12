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

<div class="header">   
  <div class="left">
   <?php if ( $logo=yii::app()->functions->getOption('store_logo') ):?>
   <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$logo;?>?>" alt="" title=""> 
   <?php endif;?>
   <a class="site_title" target="_blank" href="<?php echo Yii::app()->request->baseUrl;?>/store">
   <?php $store_name=Yii::app()->functions->getOption("store_name");?>
   <?php if (!empty($store_name)):?>
   <?php echo $store_name?> <?php echo Yii::t('default',"Back Office")?>
   <?php else :?>
   Karenderia Back Office
   <?php endif;?>
   </a>  
   </div>
   <div class="right">
     <div class="logout_wrap">
     <?php if (Yii::app()->functions->isAdminLogin()):?> 
     <!--<i class="fa fa-user"></i>-->
     <i class="fa fa-sign-out"></i>
     <a href="<?php echo Yii::app()->request->baseUrl;?>/admin/?logout=true">Logout</a>
     <?php endif;?>
     </div>
   </div>
   <div class="clear"></div>
</div> <!--END header-->

<div class="body_wrap">
<div class="menu_left">
<?php
if (Yii::app()->functions->isAdminLogin()):
$this->widget('zii.widgets.CMenu', array(         
         'activeCssClass'=>'active',         
        'items'=>array(
            array('label'=>Yii::t("default","Home"), 'url'=>array('/admin/home'),'itemOptions'=>array('class'=>'glyphicon glyphicon-home') ),
            array('label'=>Yii::t("default",'Food Category'), 'url'=>array('admin/category'),
                 'visible'=>Yii::app()->functions->checkAcl(),
                 'itemOptions'=>array('class'=>'fa fa-list'),'items'=>array(                
            )),
            array('label'=>Yii::t("default",'Food Item'), 'url'=>array('admin/item'), 
             'itemOptions'=>array('class'=>'fa fa-list'),
             'items'=>array(                
            )),
            array('label'=>Yii::t("default",'AddOn Category'), 'url'=>array('admin/subcategory'),
             'itemOptions'=>array('class'=>'fa fa-list'),
             'items'=>array(                
            )),
            array('label'=>Yii::t("default",'AddOn Item'), 'url'=>array('admin/subcategoryitem'), 
            'itemOptions'=>array('class'=>'fa fa-list'),
            'items'=>array(            
            )),
            array('label'=>Yii::t("default",'Other Item'),
            '', 'itemOptions'=>array('class'=>'fa fa-list'), 'items'=>array(
                array('label'=>Yii::t("default",'Size'), 'url'=>array('admin/otheritemsize')), 
                array('label'=>Yii::t("default",'Cooking Reference'), 'url'=>array('admin/cookingref')), 
            )),
            array('label'=>Yii::t("default",'Store Settings'),'itemOptions'=>array('class'=>'fa fa-cutlery'), 'url'=>array('admin/settings')  ),

            array('label'=>Yii::t("default",'Receipt Settings'),
              'itemOptions'=>array('class'=>'fa fa-file-text-o'), 'url'=>array('admin/receipt-settings'),
            ),
            
            array('label'=>Yii::t("default","Mail & SMTP Settings"),
            'itemOptions'=>array('class'=>'fa fa-envelope-o'), 'url'=>array('admin/smstpsettings')  ),
            
            array('label'=>Yii::t("default",'Contact Settings'),
            'itemOptions'=>array('class'=>'fa fa-envelope-o'), 'url'=>array('admin/contact-settings')  ),
            
            array('label'=>Yii::t("default",'Payment Gateway'),
            'itemOptions'=>array('class'=>'fa fa-usd'), 'items'=>array(
                array('label'=>Yii::t("default","Paypal"), 'url'=>array('admin/paypal')),                
            )),
            array('label'=>Yii::t("default",'Social Settings'),'itemOptions'=>array('class'=>'fa fa-facebook-square'),
            'url'=>array('admin/social-settings')  ),
                                    
            array('label'=>Yii::t("default",'Manage Layout'),
            '', 'itemOptions'=>array('class'=>'fa fa-list'), 'items'=>array(                
                array('label'=>Yii::t("default",'Themes'), 'url'=>array('admin/layoutthemes')),
                array('label'=>Yii::t("default",'Menu layout'), 'url'=>array('admin/layoutmenu')), 
                array('label'=>Yii::t("default",'Add Text & Image'), 'url'=>array('admin/managelayout'))                
            )),
            
            array('label'=>Yii::t("default",'Manage Translation'),'itemOptions'=>array('class'=>'fa fa-flag'),
            'url'=>array('admin/translationsettings')  ),
            
            array('label'=>Yii::t("default",'Manage Currency'),'itemOptions'=>array('class'=>'fa fa-usd'),
            'url'=>array('admin/currency-settings')  ),
            
            array('label'=>Yii::t("default",'Manage Order Status'),'itemOptions'=>array('class'=>'fa fa-file-text'),
            'url'=>array('admin/orderstatssettings')  ),
                                    
            array('label'=>Yii::t("default",'Notification'),'itemOptions'=>array('class'=>'fa fa-bell-o'), 'items'=>array(
                array('label'=>Yii::t("default",'Alert Notification'),'url'=>array('admin/alertsettings')),
                array('label'=>Yii::t("default",'SMS Notification Settings'),'url'=>array('admin/smssettings')),
                array('label'=>Yii::t("default",'SMS Notification Logs'),'url'=>array('admin/smslogs')),  
            )),
            
            
            array('label'=>Yii::t("default",'Manage Events'),'itemOptions'=>array('class'=>'fa fa-file-text'), 'items'=>array(
                array('label'=>Yii::t("default",'Add Event'),'url'=>array('admin/events')),
                array('label'=>Yii::t("default",'Event List'),'url'=>array('admin/eventslist')),                
            )),
            
            array('label'=>Yii::t("default",'Manage Pages'),'itemOptions'=>array('class'=>'fa fa-file-text'), 'items'=>array(
                array('label'=>Yii::t("default",'Add Page'),'url'=>array('admin/addpage')),
                array('label'=>Yii::t("default",'Page List'),'url'=>array('admin/pagelist')), 
                array('label'=>Yii::t("default",'Page Menu'),'url'=>array('admin/pageMenu')),                
            )),
            
            array('label'=>Yii::t("default",'Reservation Settings'),'itemOptions'=>array('class'=>'fa fa-calendar'),
            'url'=>array('admin/reservation')),
            
            array('label'=>Yii::t("default",'SEO Tools'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'items'=>array(
                array('label'=>Yii::t("default",'Title & Metas'),'url'=>array('admin/seometas'))                
            )),
            
            array('label'=>Yii::t("default",'Manage Voucher'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'url'=>array('admin/voucher')  ),
            
            array('label'=>Yii::t("default",'Reports'),'itemOptions'=>array('class'=>'fa fa-files-o'), 'items'=>array(
                array('label'=>Yii::t("default",'Registered User'),'url'=>array('admin/rpt-reg-user')),                                
                array('label'=>Yii::t("default",'Sales Report'), 'url'=>array('admin/rpt-sales-report')),               
                array('label'=>Yii::t("default",'Sales Report By Item'), 'url'=>array('admin/rpt-sales')),                 
                array('label'=>Yii::t("default",'Sales Summary Report'), 'url'=>array('admin/rpt-sales-summary')),                 
            )),
            array('label'=>Yii::t("default",'User Management'),'itemOptions'=>array('class'=>'fa fa-user'),
            'url'=>array('admin/user-management')),
            array('label'=>Yii::t("default",'Logout'),'itemOptions'=>array('class'=>'fa fa-sign-out'),
             'url'=>array('admin/?logout=true'),'visible'=>Yii::app()->functions->isAdminLogin())
        ),
));
endif;
?>
</div>
<div class="main_content">
  <div class="main_conten_inner">  
    <div class="bread_crumbs">
    
    <?php    
    if (Yii::app()->functions->isAdminLogin()){
       $bread_crumbs=Yii::app()->functions->adminBreadCrumbs();
       $this->widget('zii.widgets.CBreadcrumbs',$bread_crumbs);       
    }
    ?>  
    
    </div>  <!--END bread_crumbs-->
   <?php echo $content;?>
        
  </div> <!--END main_conten_inner-->
</div> <!--END main_content-->
<div class="clear"></div>
</div> <!--END body_wrap-->


<!--*****************************************
NOTIFICATION PLAYER STARTS HERE
*****************************************-->
<input type="hidden" id="alert_notification" name="alert_notification" value="<?php echo Yii::app()->functions->getOption("alert_notification");?>">
<?php $alert_sounds=Yii::app()->functions->getOption("alert_sounds");?>
<input type="hidden" id="alert_sounds" name="alert_sounds" value="<?php echo $alert_sounds;?>">
<?php if ( $alert_sounds==1):?>
<div style="display:none;">
<div id="jquery_jplayer_1"></div>
<div id="jp_container_1">
<a href="#" class="jp-play">Play</a>
<a href="#" class="jp-pause">Pause</a>
</div>
</div>
<?php endif;?>
<!--*****************************************
NOTIFICATION PLAYER END HERE
*****************************************-->

<!--********************************************
   START PAGE FULL VIEW
********************************************-->
<div class="post_full_wrapper">
  <div class="full_nav_wrap">
     <div class="inner">
         <a href="javascript:;" class="back"><?php echo Yii::t("default","Back")?></a>         
         <a href="javascript:;" class="view_map" style="display:none;"><?php echo Yii::t("default","View Map")?></a>  
         <a href="javascript:;" class="export_to_excel" style="display:none;"><?php echo Yii::t("default","Expot to excel")?></a>  
         <i class="loader"></i>         
         <div class="right">						
			<h1 class="full_post_header" style="margin:0;"></h1>
         </div>
         <div class="clear"></div>
     </div>
  </div>
  <div class="post_full_content" >    
  </div>
</div>
<!--********************************************
   START PAGE FULL VIEW
********************************************-->


<!--********************************************
   CHANGE STATUS
********************************************-->
<div class="modal fade change_status_pop" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo Yii::t("default","Change Order Status")?></h4>
        </div>
        <div class="modal-body">
                
        <form method="POST" onsubmit="return false;" id="frm_order_status">       
        <input type="hidden" name="action" value="changeOrderStatus">
        <input type="hidden" name="order_id" id="order_id" >        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Status")?></span>
		<select class="form-control" name="order_status" id="order_status">
		<?php if ($order_stats=Yii::app()->functions->orderStatusList()):?>
		<?php foreach ($order_stats as $key => $val):?>
		<option value="<?php echo $key?>"><?php echo ucwords($val);?></option>
		<?php endforeach;?>
		<?php endif;?>
		</select>
        </div>
        
        <div class="input-group" style="margin-top:8px;">
        <input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="btn " >
        </div>
        </form>
        
        </div> <!--modal-body-->
    </div>
  </div>
</div>
<!--********************************************
   END CHANGE STATUS
********************************************-->


<!--********************************************
   SEND EMAIL TEST
********************************************-->
<div class="modal fade send_email_test_pop" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo Yii::t("default","Send Email Test")?></h4>
        </div>
        <div class="modal-body">
                
        <form method="POST" onsubmit="return false;" id="frm_email_test">       
        <input type="hidden" name="action" value="sendEmailTest">        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Email")?></span>
		<?php echo CHtml::textField('email_test','',array('placeholder'=>"Your email address",'data-validation'=>"required"))?>
        </div>
        
        <div class="input-group" style="margin-top:8px;">
        <input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="btn " >
        </div>
        </form>
        
        </div> <!--modal-body-->
    </div>
  </div>
</div>
<!--********************************************
   END SEND EMAIL TEST
********************************************-->


</body>

<script src="//code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>  

<script type="text/javascript">
var ajax_url='<?php echo Yii::app()->request->baseUrl;?>/admin/ajax';
var upload_url='<?php echo Yii::app()->request->baseUrl;?>/upload';
var admin_url='<?php echo Yii::app()->request->baseUrl;?>/admin';
var sites_url='<?php echo Yii::app()->request->baseUrl;?>';
</script>


<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/DataTables/fnReloadAjax.js" type="text/javascript"></script>


<script src="<?php echo Yii::app()->request->baseUrl;?>/assets/vendor/JQV/form-validator/jquery.form-validator.min.js" type="text/javascript"></script>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script>
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

<?php 
$js_lang=Yii::app()->functions->jsLanguageAdmin();
?>
<script type="text/javascript">
var js_lang=<?php echo json_encode($js_lang)?>;
</script>

<?php if (Yii::app()->controller->getAction()->getId()=="home" || Yii::app()->controller->getAction()->getId()=="RptSalesReport"):?>
<!--Google Maps-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<!--END Google Maps-->
<?php endif;?>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/assets/js/admin.js?ver=1" type="text/javascript"></script>  

</html>