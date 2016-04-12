<?php
$add_text=Yii::app()->functions->getOption("add_text");
if ( !empty($add_text)){
	$add_text=json_decode($add_text);
}
?>

<h2><?php echo Yii::t("default","Add text & Image on Home page")?></h2>
<p class="uk-badge uk-badge-success"><?php echo Yii::t("default","note: click on the handle to edit. drag to sort order")?>.</p>
<hr></hr>
<form id="frm_add_ads" method="POST" onsubmit="return false;" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="saveAdsTextImage">

<div class="ads_list">
<ul class="sortable_ads" >
<?php $x=1;?>
<?php if (is_array($add_text) && count($add_text)>=1):?>
<?php foreach ($add_text as $val):?>
<?php 
$text='';
if ( substr($val,-4,1)=="."){
	$text=$val;
} else {
	$ad_text=explode(",",$val);	
	if (is_array($ad_text) && count($ad_text)>=1){
	    $text=$ad_text[0];
	}
}
?>
<?php if ( !empty($text)) :?>
<li id="promo_<?php echo $x++?>">
<input name="add_text[]" type="hidden" value="<?php echo $val; ?>" >
<i class="fa fa-th-list"></i>  <?php echo $text;?> <a href="javascript:;" class="rm_text"><i class="fa fa-times-circle"></i></a></li>
<?php endif;?>

<?php endforeach;?>
<?php endif;?>
</ul>
</div>

<div class="input_block">
 <a href="javascript:;" id="add_text"  class="uk-button"><?php echo Yii::t("default","Add Text")?></a>
 <!--<a href="javascript:;" id="add_image"  class="uk-button">Add Image</a>-->
 
 
  <div class="uk-button" id="add_image"><?php echo Yii::t('default',"Browse")?></div>	  
  <DIV  style="display:none;" class="photo_chart_status" >
	<div id="percent_bar" class="photo_percent_bar"></div>
	<div id="progress_bar" class="photo_progress_bar">
	  <div id="status_bar" class="photo_status_bar"></div>
	</div>
  </DIV>		  

 
</div>


<?php $promo_text_postion=Yii::app()->functions->getOption("promo_text_postion");?>
<?php 
if ( $promo_text_postion==""){
	$promo_text_postion=2;
}
?>
<p><?php echo Yii::t("default","Position")?></p>
<div class="input_block">
<ul>
<li style="margin-bottom:10px;"><input class="icheck" <?php echo $promo_text_postion==1?"checked":"";?> name="promo_text_postion" type="radio" value="1"> <?php echo Yii::t("default","Before  menu")?></li>
<li><input class="icheck" <?php echo $promo_text_postion==2?"checked":"";?> name="promo_text_postion" type="radio" value="2"> <?php echo Yii::t("default","After menu (default)")?></li>
</ul>
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-button-success">
</div>

</form>


<!--********************************************
   ADD TEXT
********************************************-->
<div class="modal fade add_text_pop" >
  <div class="modal-dialog">
    <div class="modal-content" >
         <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times"></i></button>
          <h4 id="mySmallModalLabel" class="modal-title"> <?php echo Yii::t("default","Add Text")?></h4>
        </div>
        <div class="modal-body">
                
        <form method="POST" onsubmit="return false;" id="frm_add_text">          
        <input type="hidden" name="promo_id" id="promo_id">
        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Text")?></span>
		<?php echo CHtml::textField('text_value','',array('class'=>"form-control",
		'data-validation'=>"required"));?>
        </div>
                
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Font Family")?></span>
		<select name="font_family" id="text_font" class="form-control">
		<option value="Arial" style="font-family : Arial">Arial</option>
		<option value="Courier" style="font-family : Courier">Courier</option>
		<option value="Tahoma" style="font-family : Tahoma">Tahoma</option>
		<option value="Times New Roman" style="font-family : 'Times New Roman'">Times New Roman</option>
		<option value="Courier New" style="font-family : Courier New">Courier New</option>
		<option value="Georgia" style="font-family : Georgia">Georgia</option>
		<option value="Impact"style="font-family : Impact">Impact</option>
		<option  value="Lucida Console" style="font-family : Lucida Console">Lucida Console</option>
		<option value="Lucida Sans Unicode" style="font-family : Lucida Sans Unicode">Lucida Sans Unicode</option>
		<option value="Trebuchet MS" style="font-family : Trebuchet MS">Trebuchet MS</option>
		<option value="Verdana" style="font-family : Verdana">Verdana</option>
		<option value="sans-serif" style="font-family : sans-serif">sans-serif</option>
		<option value="Comic Sans MS" style="font-family : Comic Sans MS">Comic Sans MS</option>
		</select>
        </div>
        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Font Size")?></span>
		<?php echo CHtml::textField('font_size','',array('class'=>'numeric_only form-control','data-validation'=>"required"));?>
        </div>
        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Font Padding")?></span>
		<?php echo CHtml::textField('font_padding','',array('class'=>"numeric_only form-control"));?>
        </div>
        
        <div class="input-group">
		<span class="input-group-addon"><?php echo Yii::t('default',"Font Color")?></span>
		<?php echo CHtml::textField('font_color','',array('class'=>"color_picker form-control"));?>
        </div>
        
        
        <div class="input-group" style="margin-top:8px;">
        <input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
        </div>
        </form>
        
        </div> <!--modal-body-->
    </div>
  </div>
</div>
<!--********************************************
   END ADD TEXT
********************************************-->