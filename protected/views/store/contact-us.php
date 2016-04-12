<?php yii::app()->functions->sessionInit();?> 

<div id="contact_wrap" class="form" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">

<h2><?php echo Yii::t('default',"Contact Us")?></h2>

<p><?php echo yii::app()->functions->getOption('contact_content')?></p>

<?php if (yii::app()->functions->getOption('contact_map')):?>
<div class="google_map_wrap" id="google_map_wrap">
<?php 
$store_name=Yii::app()->functions->getOption("store_name");
$map_latitude=Yii::app()->functions->getOption("map_latitude");
$map_longitude=Yii::app()->functions->getOption("map_longitude");
?>
<script>                 
   var locations=[["<?php echo $store_name;?>",<?php echo $map_latitude;?>,<?php echo $map_longitude;?>,1]]; 
</script>
</div> <!--END google_map_wrap-->
<?php endif;?>

<h2><?php echo yii::app()->functions->getOption('store_name')?></h2>

<h4><?php echo Yii::t('default',"Address")?></h4>
<p><?php echo yii::app()->functions->getOption('address')?></p>

<h4><?php echo Yii::t('default',"Contact")?></h4>
<ul class="contact_contact">
<li><i class="fa fa-phone"></i> <?php echo yii::app()->functions->getOption('phone_number')?></li>
<li><i class="fa fa-envelope-o"></i> <?php echo yii::app()->functions->getOption('contact_email')?></li>
<div class="clear"></div>
</ul>

<div class="contact_field_wrap">

<?php
$custom_fields;
$fields=yii::app()->functions->getOption('contact_field');
if (!empty($fields)){
	$fields=json_decode($fields);
}
if (is_array($fields) && count($fields)>=1):
foreach ($fields as $val) {	
	switch ($val) {
		case "name":
			$icon="uk-icon-user";
			$placeholder=Yii::t("default","Your name");
			break;
		case "email":
			$icon="uk-icon-envelope";
			$placeholder=Yii::t("default","Your email");
			break;
		case "phone":
			$icon="uk-icon-phone";
			$placeholder=Yii::t("default","Your Phone");
			break;
		
		case "country":
			$icon="uk-icon-flag";
			$placeholder=Yii::t("default","Your Country");
			break;
		
		case "message":
			//$icon="uk-icon-comment";
			$icon='';
			$placeholder=Yii::t("default","Your Message");		
			break;
			
		default:
			break;
	}
	$custom_fields[]=array(
	  'name'=>$val,
	  'icon'=>$icon,
	  'value'=>$placeholder,
	);
}
endif;
?>

<form id="frm_contact" class="forms form" onsubmit="return false;">
<input type="hidden" name="action" value="contactForm">

<?php if (is_array($fields) && count($fields)>=1):?>
<?php foreach ($custom_fields as $val):?>
<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default",ucwords($val['name']));?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="<?php echo $val['icon'];?>"></i>
     <?php if ($val['name']=="message"):?>
     <textarea name="<?php echo $val['name'];?>" placeholder="<?php echo $val['value']?>" ></textarea>
     <?php else :?>
     <input name="<?php echo $val['name'];?>" type="text" placeholder="<?php echo $val['value']?>" class="uk-form-width-medium" value="">
     <?php endif;?>
     </div>
   </div>
</div>
<?php endforeach;?>

<div class="uk-form-row">
<button type="submit" class="btn_submit btn btn-success"> <?php echo Yii::t('default',"Submit")?> </button>
<i  class="process_indicator fa fa-spinner fa-spin" style="display:none;"></i>
</div>
<?php endif;?>

</div> <!--END contact_field_wrap-->

</form>

</div>
<?php
/*SEO*/
if ( $title=Yii::app()->functions->getOption('contact_seo_title')){	
	$this->setPageTitle(ucwords($title));
	Yii::app()->clientScript->registerMetaTag($title, 'title');
	Yii::app()->clientScript->registerMetaTag($title, 'og:title');
}
if ( $meta_description=Yii::app()->functions->getOption("contact_meta_description")){
	Yii::app()->clientScript->registerMetaTag($meta_description, 'description');
	Yii::app()->clientScript->registerMetaTag($meta_description, 'og:description');
}
if ( $meta_keywords=Yii::app()->functions->getOption("contact_meta_keywords")){
	Yii::app()->clientScript->registerMetaTag($meta_keywords, 'keywords');
}