
<div class="pages_wrap form">
<?php if ( $res=Yii::app()->functions->getPagesBySlug() ):?>

<?php 
$data=$res[0];
if ( !empty($data['seo_title'])){
    $this->setPageTitle(ucwords($data['seo_title']));
    Yii::app()->clientScript->registerMetaTag($data['seo_title'], 'title');
    Yii::app()->clientScript->registerMetaTag($data['seo_title'], 'og:title');
}
if ( !empty($data['meta_keywords'])){
   Yii::app()->clientScript->registerMetaTag($data['meta_keywords'], 'keywords');
}
if ( !empty($data['meta_description'])){
   Yii::app()->clientScript->registerMetaTag($data['meta_description'], 'description');
   Yii::app()->clientScript->registerMetaTag($data['meta_description'], 'og:description');
}
?>
	<h2><?php echo $res[0]['page_name']?></h2>
	<?php echo $res[0]['description']?>
<?php else :?>	
	<div class="uk-alert">
	<?php echo Yii::t('default',"Sorry but we cannot find what you are looking for")?>.
	</div>
<?php endif;?>
</div>