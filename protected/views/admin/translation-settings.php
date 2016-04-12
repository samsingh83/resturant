
<form id="frm_table_list" method="POST" >

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/translation-add" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t('default',"Delete")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/assign-language" class="uk-button">
<i class="fa fa-cog"></i>
<?php echo Yii::t('default',"Settings")?>
</a>


<input type="hidden" name="action" id="action" value="languageTranslateList">
<input type="hidden" name="tbl" id="tbl" value="languages">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="lang_id">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <th><input type="checkbox" id="chk_all" class="chk_all"></th>
 <th><?php echo Yii::t('default',"Name")?></th>
 <th><?php echo Yii::t('default',"Code")?></th> 
 <th><?php echo Yii::t('default',"Status")?></th> 
 <th><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>
<div class="clear"></div>


<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/translation-add" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t('default',"Delete")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/assign-language" class="uk-button">
<i class="fa fa-cog"></i>
<?php echo Yii::t('default',"Settings")?>
</a>

</form>