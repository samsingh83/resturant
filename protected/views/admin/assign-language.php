<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/translation-settings" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>

<div style="height:10px;"></div>

<?php
$language=Yii::app()->functions->availableLanguage(false);
if ($assign_lang=Yii::app()->functions->getAssignLanguage()){
	$assign_lang=array_flip($assign_lang);	
} else $assign_lang='';

$default_lang=Yii::app()->functions->getOption("lang_default");
?>

<form id="frm_table_list" method="POST" >
<input type="hidden" name="action" value="assignLanguage">

<div class="input_block">
<label><h3><?php echo Yii::t("default","Show Language Siderbar on front end")?></h3></label>
<li>
<?php echo CHtml::checkBox('show_language_siderbar',
Yii::app()->functions->getOption("show_language_siderbar"),array(
'class'=>"icheck"
))?> Yes
</li>
</div>

<div class="input_block">
<label><h3><?php echo Yii::t("default","Set Language")?></h3></label>
<?php if (is_array($language) && count($language)>=1):?>
<?php foreach ($language as $id => $lang):?>
<li>
<?php echo CHtml::checkBox('lang_id[]',
in_array($id,(array)$assign_lang)?true:false ,
array(
'value'=>$id,
'class'=>"icheck"
))?>
 <?php echo $lang;?>
</li>
<?php endforeach;?>
<?php else :?>
<?php echo Yii::t("default","No language options");?>
<?php endif;?>
</div>

<?php $language=Yii::app()->functions->availableLanguage(true)?>
<div class="input_block">
<label><h3>Default Language on front end</h3></label>
<?php if (is_array($language) && count($language)>=1):?>
<?php foreach ($language as $id => $lang):?>
<li>
<?php echo CHtml::radioButton('lang_default',
$id==$default_lang?true:false,
array(
'value'=>$id,
'class'=>"icheck"
))?> <?php echo $lang;?>
</li>
<?php endforeach;?>
<?php else :?>
<?php echo Yii::t("default","No language options");?>
<?php endif;?>
</div>

<div class="input_block">
<input class="uk-button uk-button-success" type="submit" value="<?php echo Yii::t("default","Submit")?>" >
</div>

</form>