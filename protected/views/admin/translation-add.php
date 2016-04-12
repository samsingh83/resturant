<?php
$country_code=require_once 'CountryCode.php';
?>
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/translation-settings" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>
<div style="height:30px;"></div>

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>

<form id="frm_language" method="POST" class="form-horizontal" >

<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:"";?>">
<input type="hidden" name="action" value="saveTranslation">

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Save")?>" style="margin-left:0px;" >
</div>

<?php
$new_raw_msg='';
$raw_msg = require_once Yii::getPathOfAlias('webroot')."/protected/messages/default/raw_msg.php";
if (is_array($raw_msg) && count($raw_msg)>=1){
	foreach ($raw_msg as $val_raw_msg) {
		$new_raw_msg[$val_raw_msg]=$val_raw_msg;
	}
}
$lang_info=Yii::app()->functions->languageInfo($_GET['id']);
$translated_text=!empty($lang_info[0]['source_text'])?(array)json_decode($lang_info[0]['source_text']):array();
//dump($translated_text);
?>

<div class="panel panel-default">
<div class="panel-heading">
<?php if (is_array($lang_info) && count($lang_info)>=1):?>
<?php if (array_key_exists($lang_info[0]['country_code'],$country_code)):?>
<?php echo $country_code[$lang_info[0]['country_code']] .' '.$lang_info[0]['language_code']?>
<?php endif;?>
<?php endif;?>
</div>
<table class="table" id="tbl_translation">
<thead>
<tr>
 <th width="50%">Souce text</th>
 <th>Translation</th>
</tr>
</thead>
<tbody>
<?php foreach ($new_raw_msg as $val):?>
<tr>
 <td><?php echo $val;?></td>
 <td>
  <?php echo CHtml::textArea("source_text[$val]",
  Yii::app()->functions->inArray($val,$translated_text),
  array(
    'class'=>'source_text'
  ))?>
 </td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>

<div class="input_block">
<input type="submit" value="Save" style="margin-left:0px;" >

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/translation-settings" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
</div>

</form>


<?php else :?>

<form id="frm_category" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:"";?>">
<input type="hidden" name="action" value="addTranslation">
<?php if (!isset($_GET['id'])):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="translation-add">
<?php endif;?>

<div class="input_block">
 <label><?php echo Yii::t('default',"Select Country")?> :</label>
 <?php echo CHtml::dropDownList('country_code','',$country_code,array(
  'id'=>'country_code'
 ))?> 
</div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Enter language Name")?> :</label>
 <?php echo CHtml::textField('language_code','',array(
 'id'=>'language_code'
 ))?>
</div>

<div class="input_block">
   <label><?php echo Yii::t('default',"Status")?></label>
   <?php echo CHtml::dropDownList('status',$data['status'],status_list())?>
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Start Translating")?>" class="uk-button uk-button-success" >
</div>

</form>

<?php endif;?>