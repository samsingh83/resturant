<form id="frm_settings" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="action" value="socialSettings">

<div class="input_block">
<label><?php echo Yii::t('default',"Display Social Icons on frontpage?")?></label>
<?php echo CHtml::checkBox('social_flag',yii::app()->functions->getOption('social_flag'),
array('value'=>1,'class'=>"icheck"))?>
</div>

<h3><?php echo Yii::t('default',"Facebook")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Enabled Facebook Login?")?></label>
<?php echo CHtml::checkBox('fb_flag',yii::app()->functions->getOption('fb_flag'),
array('value'=>1,'class'=>"icheck"))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"App ID")?></label>
<?php echo CHtml::textField('fb_app_id',yii::app()->functions->getOption('fb_app_id') )?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"App Secret")?></label>
<?php echo CHtml::textField('fb_app_secret',yii::app()->functions->getOption('fb_app_secret') )?>
</div>


<div class="input_block">
<label><?php echo Yii::t('default',"Facebook Page")?></label>
<?php echo CHtml::textField('fb_page',yii::app()->functions->getOption('fb_page') )?>
</div>

<h3><?php echo Yii::t('default',"Twitter")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Twitter Page")?></label>
<?php echo CHtml::textField('twitter_page',yii::app()->functions->getOption('twitter_page') )?>
</div>

<h3><?php echo Yii::t('default',"Google")?></h3>
<div class="input_block">
<label><?php echo Yii::t('default',"Google Page")?></label>
<?php echo CHtml::textField('google_page',yii::app()->functions->getOption('google_page') )?>
</div>

<div class="action_wrap">
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success">
</div>
</form>