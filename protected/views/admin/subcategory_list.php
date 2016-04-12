<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal" >

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategorynew" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t("default","Delete")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortsubcategory" class="uk-button">
<i class="fa fa-sort-alpha-asc"></i>
<?php echo Yii::t('default',"Sort Item")?>
</a>

<input type="hidden" name="action" id="action" value="subCategoryList">
<input type="hidden" name="tbl" id="tbl" value="subcategory">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="subcat_id">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <th><input type="checkbox" id="chk_all" class="chk_all"></th>
 <th><?php echo Yii::t('default',"AddOn Name")?></th>
 <th><?php echo Yii::t('default',"Description")?></th>
 <th><?php echo Yii::t('default',"Discount")?></th>
</tr>
</thead>
</table>
<div class="clear"></div>


<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategorynew" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New")?>
</a>

<a href="javascript:;" class="btn_delete_table uk-button">
<i class="fa fa-times"></i>
<?php echo Yii::t("default","Delete")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/subcategory" class="uk-button">
<i class="fa fa-list"></i>
<?php echo Yii::t('default',"List")?>
</a>

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/sortsubcategory" class="uk-button">
<i class="fa fa-sort-alpha-asc"></i>
<?php echo Yii::t('default',"Sort Item")?>
</a>

</form>