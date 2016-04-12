
<h2><?php echo Yii::t("default","Manage Themes")?></h2>

<?php
$layout_themes=Yii::app()->functions->getOption("layout_themes");
$full_layout=Yii::app()->functions->getOption("full_layout");
?>

<form id="frm_managemenu" class="uk-form uk-form-horizontal">
<input type="hidden" name="action" value="manageTheme">
<ul>
  <li>
  <span><?php echo Yii::t("default","Red (Default)")?></span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==1?true:false,array(
  'class'=>"icheck",
  'value'=>1
  ))?>
  </li>
    
  
  <li>
  <span><?php echo Yii::t("default","brown")?>  </span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==2?true:false,array(
  'class'=>"icheck",
  'value'=>2
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","Blue")?> </span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==3?true:false,array(
  'class'=>"icheck",
  'value'=>3
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","burgundy")?> </span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==4?true:false,array(
  'class'=>"icheck",
  'value'=>4
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","light sea green")?></span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==5?true:false,array(
  'class'=>"icheck",
  'value'=>5
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","black")?> </span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==6?true:false,array(
  'class'=>"icheck",
  'value'=>6
  ))?>
  </li>
  
  <li>
  <span><?php echo Yii::t("default","custom")?> </span>
  <?php echo CHtml::radioButton('layout_themes',$layout_themes==7?true:false,array(
  'class'=>"icheck",
  'value'=>7
  ))?>
  <?php echo CHtml::textField('custom_colors',Yii::app()->functions->getOption("custom_colors"),array(
  'class'=>"color_picker",
  'style'=>"width:100px;"
  ))?>
  </li>

  <li>
  <span><?php echo Yii::t("default","Full Layout")?> </span>
  <?php echo Yii::t("default","Yes")?> <?php echo CHtml::radioButton('full_layout',$full_layout==1?true:false,array(
  'class'=>"icheck",
  'value'=>1
  ))?>
    
  <?php echo Yii::t("default","No")?> <?php echo CHtml::radioButton('full_layout',$full_layout==2?true:false,array(
  'class'=>"icheck",
  'value'=>2
  ))?>
  </li>
  
</ul>


<div class="input-group" style="margin-top:8px;">
<input type="submit" id="submit" value="<?php echo Yii::t('default',"Submit")?>" class="uk-button uk-button-success" >
</div>

</form>