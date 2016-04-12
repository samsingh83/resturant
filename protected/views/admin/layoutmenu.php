
<h2><?php echo Yii::t("default","Manage Menu")?></h2>

<?php
$layout_menu=Yii::app()->functions->getOption("layout_menu");
$pre_collapse=Yii::app()->functions->getOption("pre_collapse");
?>

<form id="frm_managemenu" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="layoutMenu">
<ul>
  <li>
  <span><?php echo Yii::t("default","Tile (Default)")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==1?true:false,array(
  'class'=>"icheck",
  'value'=>1
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Thumb-view Menu")?> </span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==2?true:false,array(
  'class'=>"icheck",
  'value'=>2
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Collapsable Menu")?> </span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==3?true:false,array(
  'class'=>"icheck",
  'value'=>3
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Menu with featured items")?> </span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==4?true:false,array(
  'class'=>"icheck",
  'value'=>4
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Collapsable with featured items")?> </span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==5?true:false,array(
  'class'=>"icheck",
  'value'=>5
  ))?>
  </li>

  <li>
  <span><?php echo Yii::t("default","Horizontal Tab Menu")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==6?true:false,array(
  'class'=>"icheck",
  'value'=>6
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Collapsable Category/Thumbnail View")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==7?true:false,array(
  'class'=>"icheck",
  'value'=>7
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Collapsable Category")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==8?true:false,array(
  'class'=>"icheck",
  'value'=>8
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Tile + Collapsable Category")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==9?true:false,array(
  'class'=>"icheck",
  'value'=>9
  ))?>
  </li>
  
<li>
  <span><?php echo Yii::t("default","List Menu")?></span>
  <?php echo CHtml::radioButton('layout_menu',$layout_menu==10?true:false,array(
  'class'=>"icheck",
  'value'=>10
  ))?>
  </li>  
  
  <li class="collapse_wrap" style="display:none;">
  <span><?php echo Yii::t("default","Pre-Collapsed Menu")?></span>
   <input <?php echo $pre_collapse==1?"checked":""?> type="checkbox" name="pre_collapse" id="pre_collapse" class="icheck" value="1"> 
  </li>
  
  
</ul>


<div class="input-group" style="margin-top:8px;">
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
</div>

</form>