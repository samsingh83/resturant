<?php 
$list=yii::app()->functions->getEventList(true);
?>
<div class="event_list">

<?php if ( is_array($list) && count($list)>=1):?>
<?php foreach ($list as $val):?>
<article class="uk-article">
    <h1 class="uk-article-title"><?php echo ucwords($val['title'])?></h1>
    <p class="uk-article-meta">Posted on <?php echo date("D. F d, Y",strtotime($val['date_created']))?></p>
    <p class="uk-article-lead">&nbsp;</p>
    <?php if (!empty($val['photo'])):?>
    <img src="<?php echo Yii::app()->request->baseUrl."/upload/".$val['photo'] ?>" alt="" title="">	    
    <?php endif;?>
    <p><?php echo Yii::app()->functions->limitText(strip_tags($val['description']),300)?></p>
    <a href="<?php echo Yii::app()->request->baseUrl."/store/view-events/id/".$val['event_id']?>" class="read_more"><?php echo Yii::t("default","Read more")?></a>    
</article>
<?php endforeach;?>
<?php else :?>
<p><?php echo Yii::t("default","No events has been published.")?></p>
<?php endif;?>

</div> <!--END event_list-->
<?php
/*SEO*/
if ( $title=Yii::app()->functions->getOption('events_seo_title')){	
	$this->setPageTitle(ucwords($title));
	Yii::app()->clientScript->registerMetaTag($title, 'title');
	Yii::app()->clientScript->registerMetaTag($title, 'og:title');
}
if ( $meta_description=Yii::app()->functions->getOption("events_meta_description")){
	Yii::app()->clientScript->registerMetaTag($meta_description, 'description');
	Yii::app()->clientScript->registerMetaTag($meta_description, 'og:description');
}
if ( $meta_keywords=Yii::app()->functions->getOption("events_meta_keywords")){
	Yii::app()->clientScript->registerMetaTag($meta_keywords, 'keywords');
}