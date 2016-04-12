
<h2><?php echo Yii::t("defaut","Page List")?></h2>
<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal" >

<input type="hidden" name="action" id="action" value="pageList">
<input type="hidden" name="tbl" id="tbl" value="pages">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="page_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <th width="3%"><?php echo Yii::t('default',"ID")?></th> 
 <th width="5%"><?php echo Yii::t('default',"page name")?></th> 
 <th width="5%"><?php echo Yii::t('default',"SEO Title")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Meta Description")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>
</form>