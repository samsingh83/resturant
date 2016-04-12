<h2><?php echo Yii::t("default","Title & Metas")?></h2>

<form id="forms" onsubmit="return false;" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="seoMetas">

<h3><?php echo Yii::t("default","Home Page")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"SEO Title")?></label>
<?php echo CHtml::textField('home_seo_title',Yii::app()->functions->getOption("home_seo_title"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Description")?></label>
<?php echo CHtml::textArea('home_meta_description',Yii::app()->functions->getOption("home_meta_description"))?>
<span><?php echo Yii::t("default","The meta description will be limited to 156 chars.")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Keywords")?></label>
<?php echo CHtml::textArea('home_meta_keywords',Yii::app()->functions->getOption("home_meta_keywords"))?>
</div>

<hr></hr>

<h3><?php echo Yii::t("default","Contact Page")?></h3>

<div class="input_block">
<label><?php echo Yii::t('default',"SEO Title")?></label>
<?php echo CHtml::textField('contact_seo_title',Yii::app()->functions->getOption("contact_seo_title"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Description")?></label>
<?php echo CHtml::textArea('contact_meta_description',Yii::app()->functions->getOption("contact_meta_description"))?>
<span><?php echo Yii::t("default","The meta description will be limited to 156 chars.")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Keywords")?></label>
<?php echo CHtml::textArea('contact_meta_keywords',Yii::app()->functions->getOption("contact_meta_keywords"))?>
</div>

<hr></hr>

<h3><?php echo Yii::t("default","Events Page")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"SEO Title")?></label>
<?php echo CHtml::textField('events_seo_title',Yii::app()->functions->getOption("events_seo_title"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Description")?></label>
<?php echo CHtml::textArea('events_meta_description',Yii::app()->functions->getOption("events_meta_description"))?>
<span><?php echo Yii::t("default","The meta description will be limited to 156 chars.")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Keywords")?></label>
<?php echo CHtml::textArea('events_meta_keywords',Yii::app()->functions->getOption("events_meta_keywords"))?>
</div>

<hr></hr>

<h3><?php echo Yii::t("default","Reservation Page")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"SEO Title")?></label>
<?php echo CHtml::textField('reservation_seo_title',Yii::app()->functions->getOption("reservation_seo_title"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Description")?></label>
<?php echo CHtml::textArea('reservation_meta_description',Yii::app()->functions->getOption("reservation_meta_description"))?>
<span><?php echo Yii::t("default","The meta description will be limited to 156 chars.")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Keywords")?></label>
<?php echo CHtml::textArea('reservation_meta_keywords',Yii::app()->functions->getOption("reservation_meta_keywords"))?>
</div>

<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >

</form>