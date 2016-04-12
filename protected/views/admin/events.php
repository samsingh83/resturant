<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{events}}
	WHERE
	event_id='".addslashes($_GET['id'])."'
	LIMIT 0,1
	";
	$connection=Yii::app()->db;
    $rows=$connection->createCommand($stmt)->queryAll(); 
    if (is_array($rows) && count($rows)>=1){    	    	
    	$data=$rows[0];        	
    } else $data=array();
}

if (!isset($data['status'])){
	$data['status']='';
}
if (!isset($_GET['id'])){
	$_GET['id']='';
	$action='add';
} else $action='update';
?>

<div class="leftx">

<?php if (isset($_GET['msg'])):?>
<div class="success"><?php echo $_GET['msg']?></div>
<?php endif;?>

<h2><?php echo Yii::t("default","Manage Events")?></h2>

<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>">
<input type="hidden" name="action" value="addEvent">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="events">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"Event name")?></label>
<?php echo CHtml::textField('event_name',isset($data['title'])?$data['title']:'',array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t("default","Description")?></label>
</div>
<textarea style="height:200px;" name="event_description" id="event_description" data-uk-htmleditor="{mode:'split', maxsplitsize:600}"  ><?php echo isset($data['description'])?$data['description']:'';?></textarea>
<div style="height:20px;"></div>

<div class="input_block">
 <label><?php echo Yii::t('default',"Feature Image")?></label>	 	 
  <div  class="uk-button" id="storelogo"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="storelogo_chart_status" >
	<div id="percent_bar" class="storelogo_percent_bar"></div>
	<div id="progress_bar" class="storelogo_progress_bar">
	  <div id="status_bar" class="storelogo_status_bar"></div>
	</div>
  </DIV>		  
</div>

<?php 
$logo=isset($data['photo'])?$data['photo']:'';
?>
<?php if (!empty($logo)):?>
<div class="input_block">
<?php else :?>
<div class="input_block preview">
<?php endif;?>
<label><?php echo Yii::t('default',"Preview")?></label>
<div class="image_preview">
 <?php if (!empty($logo)):?>
 <input type="hidden" name="photo" value="<?php echo $logo;?>">
 <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$logo;?>?>" alt="" title=""> 
 <p><a href="javascript:rm_preview();"><?php echo Yii::t("default","remove Logo")?></a></p>
 <?php endif;?>
</div>
</div>


<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::dropDownList('status',$data['status'],status_list(),array('data-validation'=>'required'))?>
</div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/events" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	

</form>
</div> <!--END LEFT-->

<div class="rightx">

</div> <!--END right-->

<div class="clear"></div>