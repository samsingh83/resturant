<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{user}}
	WHERE
	user_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}

if (!isset($data['full_name'])){
	$data['full_name']='';
}
if (!isset($data['username'])){
	$data['username']='';
}
if (!isset($data['status'])){
	$data['status']='';
}
if (!isset($data['lang_id'])){
	$data['lang_id']='';
}
if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';

$user_access=isset($data['user_access'])?json_decode($data['user_access']):false;
?>

<div class="leftx" id="user_settings_wrap">
<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >

<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
<input type="hidden" name="action" value="addUser">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="useradd">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Name")?></label>
<?php echo CHtml::textField('full_name',$data['full_name'],array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Username")?></label>
<?php echo CHtml::textField('username',$data['username'],array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Password")?></label>
<?php if (isset($_GET['id'])):?>
<?php echo CHtml::passwordField('password')?>
<?php else:?>
<?php echo CHtml::passwordField('password','',array('data-validation'=>'required'))?>
<?php endif;?>
</div>

<?php Yii::app()->functions->availableLanguage();?>
<div class="input_block">
<label><?php echo Yii::t('default',"User Language")?></label>
<?php 
echo CHtml::dropDownList('lang_id',$data['lang_id'],(array)Yii::app()->functions->availableLanguage() )
?>
</div>

<div class="input_block">
<label>User Type</label>
<?php 
echo CHtml::dropDownList('user_type',isset($data['user_type'])?$data['user_type']:"",
Yii::app()->functions->userRole(),array(
'data-validation'=>"required"
));
?>
<span><?php echo Yii::t("default","If user type is admin user will have all access to menu and disregard the user access")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::dropDownList('status',$data['status'],yii::app()->functions->userStatus()
,array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","User Access")?></label>

<ul class="user_access_ul">
<a href="javascript:;" class="select_all"><?php echo Yii::t("default","Select All")?></a>
<?php  $menu=Yii::app()->functions->adminMenu(); ?>
<?php foreach ($menu['items'] as $val):?>
<li>
  <?php if ($val['tag']<>"logout"):?>
  <?php echo CHtml::checkBox('user_access[]',in_array($val['tag'],(array)$user_access)?true:false ,
  array(
    'value'=>$val['tag'],
    'class'=>"user_access icheck"
  )); echo "<em>".$val['label']."</em>";
  ?>
  <?php if (is_array($val['items']) && count($val['items'])>=1):?>
  <ul>
    <?php foreach ($val['items'] as $val_sub):?>
      <li>
      <?php echo CHtml::checkBox('user_access[]', in_array($val_sub['tag'],(array)$user_access)?true:false  ,
      array(
        'value'=>$val_sub['tag'],
        'class'=>"user_access icheck"
      ))?>
      <?php echo "<em>".$val_sub['label']."</em>";?>
      </li>
    <?php endforeach;?>
  </ul>
  <?php endif;?>
</li>
 <?php endif;?>
<?php endforeach;?>
</ul>
</div>

<?php if ($action!="add"):?>
<input type="submit" value= "<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/user-management" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/user-management" class="uk-button"><?php echo Yii::t('default',"Back")?></a>
</form>
</div> <!--END LEFT-->
