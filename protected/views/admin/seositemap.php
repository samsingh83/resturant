<h2>XML Sitemap</h2>


<form id="forms" onsubmit="return false;">
<input type="hidden" name="action" value="seoXmlSiteMap">

<p><?php echo Yii::t("default","Exclude the following page")?></p>

<?php 
if ($seo_exclude_page=Yii::app()->functions->getOption("seo_exclude_page")){
	$seo_exclude_page=!empty($seo_exclude_page)?json_decode($seo_exclude_page):array();
}

if ($seo_exclude_custom_page=Yii::app()->functions->getOption("seo_exclude_custom_page")){
	$seo_exclude_custom_page=!empty($seo_exclude_custom_page)?json_decode($seo_exclude_custom_page):array();
}
?>

<div class="input_block">
<ul>
<li>
<?php 
echo CHtml::checkBox('page[]',
in_array('events',(array)$seo_exclude_page)?true:false
,array('class'=>"icheck",'value'=>"events"))." ";
echo Yii::t("default","Events");
?>
</li>
<li>
<?php 
echo CHtml::checkBox('page[]',
in_array('contact',(array)$seo_exclude_page)?true:false
,array('class'=>"icheck",'value'=>"contact"))." ";
echo Yii::t("default","Contacts");
?>
</li>
<li>
<?php 
echo CHtml::checkBox('page[]',
in_array('reservation',(array)$seo_exclude_page)?true:false
,array('class'=>"icheck",'value'=>"reservation"))." ";
echo Yii::t("default","Reservation");
?>
</li>
</ul>
</div>


<?php if ( $page=Yii::app()->functions->getPagesList(true)):?>
<p><?php echo Yii::t("default","Exclude Custom page")?></p>


<div class="input_block">
<ul>
<?php foreach ($page as $val):?>
<li>
<?php 
echo CHtml::checkBox('custom_page[]',
in_array($val['page_id'],(array)$seo_exclude_custom_page)?true:false
,array('class'=>"icheck",'value'=>$val['page_id']))." ";
echo $val['page_name']
?>
</li>
<?php endforeach;?>
</ul>
</div>
<?php endif;?>

<input style="margin-left:0px;" type="submit" value="<?php echo Yii::t("default","Create XML Sitemap")?>" class="btn">

</form>
