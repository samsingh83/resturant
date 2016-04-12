<?php
$data=array();
if (isset($_GET['id'])){
	$stmt="
	SELECT * FROM
	{{pages}}
	WHERE
	page_id='".addslashes($_GET['id'])."'
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

<h2><?php echo Yii::t("default","Manage Pages")?></h2>

<form id="frm_item" method="POST" class="uk-form uk-form-horizontal" >
<input type="hidden" name="id" value="<?php echo isset($_GET['id'])?$_GET['id']:''?>">
<input type="hidden" name="action" value="addPage">
<?php if ($action=="add"):?>
<input type="hidden" name="clear" id="clear" value="true">
<input type="hidden" name="page_name" id="page_name" value="addpage">
<?php endif;?>

<div class="input_block">
<label><?php echo Yii::t('default',"page name")?></label>
<?php echo CHtml::textField('pages_name',isset($data['page_name'])?$data['page_name']:'',array('data-validation'=>'required'))?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"page icon")?></label>
<?php echo CHtml::textField('page_icon',isset($data['page_icon'])?$data['page_icon']:'',array(
'placeholder'=>"eg. fa fa-file-text-o"
))?>
<span>for icons refer to font <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">awesome icons</a></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"SEO Title")?></label>
<?php echo CHtml::textField('seo_title',isset($data['seo_title'])?$data['seo_title']:'')?>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Description")?></label>
<?php echo CHtml::textArea('meta_description',isset($data['meta_description'])?$data['meta_description']:'')?>
<span><?php echo Yii::t("default","The meta description will be limited to 156 chars.")?></span>
</div>

<div class="input_block">
<label><?php echo Yii::t('default',"Meta Keywords")?></label>
<?php echo CHtml::textArea('meta_keywords',isset($data['meta_keywords'])?$data['meta_keywords']:'')?>
</div>


<div class="input_block">
<label><?php echo Yii::t("default","Page Content/HTML")?></label>
</div>
<textarea style="height:200px;" name="event_description" id="event_description" data-uk-htmleditor="{mode:'split', maxsplitsize:600}"  ><?php echo isset($data['description'])?$data['description']:'';?></textarea>
<div style="height:20px;"></div>


<div class="input_block">
<label><?php echo Yii::t('default',"Status")?></label>
<?php echo CHtml::dropDownList('status',$data['status'],status_list(),array('data-validation'=>'required'))?>
</div>

<?php if ($action!="add"):?>
<input type="submit" value="<?php echo Yii::t('default',"Update")?>" class="uk-button uk-button-success" >
<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/pagelist" class="uk-button"><?php echo Yii::t('default',"Cancel")?></a>
<?php else:?>
<input type="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
<?php endif;?>	

</form>
</div> <!--END LEFT-->

<div class="rightx">

</div> <!--END right-->

<div class="clear"></div>