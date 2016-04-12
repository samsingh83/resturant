<?php 
$list=yii::app()->functions->getEventListByID($_GET['id']);
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
    <p><?php echo $val['description']?></p>    
    
    <a href="<?php echo Yii::app()->request->baseUrl."/store/events"?>" class="read_more"><?php echo Yii::t("default","Back to events")?></a>
</article>
<?php endforeach;?>
<?php else :?>
<p><?php echo Yii::t("default","Sorry but we cannot find what you are looking for.")?></p>
<?php endif;?>

</div> <!--END event_list-->