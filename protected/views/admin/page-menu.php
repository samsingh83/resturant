<h2><?php echo Yii::t("default","Page Menu")?></h2>

<p class="uk-badge uk-badge-success" style="text-align:left;">
Assign Page to front page<br>
Check the page you want to appear on front page
</p>

<hr></hr>

<form id="frm_pages" method="POST" onsubmit="return false;">
<input type="hidden" name="action" value="savePagesMenu">

<?php 
$menu_page_id=Yii::app()->functions->getOption("menu_page_id");
if ( !empty($menu_page_id)){
	$menu_page_id=json_decode($menu_page_id);
}
?>

<div class="page_list">
 <ul class="sortable_pages" data-id="sort_category" data="pages" data-key="page_id" >
 <?php if ( $res=Yii::app()->functions->getPagesList(true,"sequence",'ASC')):?>
 <?php foreach ($res as $val):?>  
 <?php 
 $ischeck=in_array($val['page_id'],(array)$menu_page_id)?true:false;
 ?>
  <li class="<?php echo $val['page_id']?>">
  <?php echo CHtml::checkBox('add_page[]',$ischeck,array('value'=>$val['page_id'],'class'=>"icheck"))?>
  <?php echo $val['page_name']?>
    
  <span style="padding-left:30px;">Assign Menu to</span>
  <?php echo CHtml::radioButton('assign_menu['.$val['page_id'].']',
  $val['assign_menu']==1?true:false
  ,array('value'=>1,'class'=>"icheck"))?>
  Main
  <?php echo CHtml::radioButton('assign_menu['.$val['page_id'].']',
  $val['assign_menu']==2?true:false
  ,array('value'=>2,'class'=>"icheck"))?>
  Top
  <?php echo CHtml::radioButton('assign_menu['.$val['page_id'].']',
  $val['assign_menu']==3?true:false
  ,array('value'=>3,'class'=>"icheck"))?>
  Footer
  </li>
  <?php endforeach;?>
  <?php endif;?>
 </ul>
</div>

<div class="input_block">
<input type="submit" value="<?php echo Yii::t("default","Save")?>" class="uk-button uk-button-success">
</div>
</form>
