
<div id="reservation_wrap" class="form" data-uk-scrollspy="{cls:'uk-animation-scale-up', repeat: true}">

<div class="food_order left">

<?php if ( $description=yii::app()->functions->getOption('reservation_description') ):?>
<?php echo $description;?>
<?php else :?>
<h2>Reservation</h2>
<?php endif;?>

<form id="frm_contact" class="uk-form forms" onsubmit="return false;">
<input type="hidden" name="action" value="reservationSaved">

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Name");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-user"></i>     
     <input name="client_name" type="text" placeholder="" class="uk-form-width-medium" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Phone number");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-mobile"></i>     
     <input name="phone_number" type="text" placeholder="" class="uk-form-width-medium" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Email Address");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-envelope-o"></i>     
     <input name="email_address" type="text" placeholder="" class="uk-form-width-medium" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Number of person");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-user"></i>     
     <input name="number_of_person" type="text" placeholder="" class="uk-form-width-medium" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Date");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-calendar-o"></i>     
     <input name="reservation_date" type="text" placeholder="" class="uk-form-width-medium j_date2" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Time");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-clock-o"></i>     
     <input name="reservation_time" type="text" placeholder="" class="uk-form-width-medium timepick" value="">     
     </div>
   </div>
</div>

<div class="uk-form-row">
   <label class="uk-form-label"><?php echo Yii::t("default","Message / Special Request");?>:</label>
   <div class="uk-form-controls">           
     <div class="uk-form-icon">
     <i class="uk-icon-comments-o"></i>     
     <textarea name="message" placeholder="" ></textarea>
     </div>
   </div>
</div>

<div class="uk-form-row">
<button type="submit" class="btn_submit btn btn-success"> <?php echo Yii::t('default',"Submit")?> </button>
<i  class="process_indicator fa fa-spinner fa-spin" style="display:none;"></i>
</div>

</form>

</div>

<div class="siderbar_wrap right">
 <div class="recent_order_inner">
 <?php Yii::app()->functions->recentOrderWidget()?>
 </div>
 <?php Yii::app()->functions->categoryMenu()?>
</div> <!--END siderbar_wrap-->
<div class="clear"></div>

</div> <!--END reservation_wrap-->
<?php
/*SEO*/
if ( $title=Yii::app()->functions->getOption('reservation_seo_title')){	
	$this->setPageTitle(ucwords($title));
	Yii::app()->clientScript->registerMetaTag($title, 'title');
	Yii::app()->clientScript->registerMetaTag($title, 'og:title');
}
if ( $meta_description=Yii::app()->functions->getOption("reservation_meta_description")){
	Yii::app()->clientScript->registerMetaTag($meta_description, 'description');
	Yii::app()->clientScript->registerMetaTag($meta_description, 'og:description');
}
if ( $meta_keywords=Yii::app()->functions->getOption("reservation_meta_keywords")){
	Yii::app()->clientScript->registerMetaTag($meta_keywords, 'keywords');
}