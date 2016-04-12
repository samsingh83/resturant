
<h2><?php echo Yii::t("default","Event List")?></h2>
<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal">

<input type="hidden" name="action" id="action" value="eventList">
<input type="hidden" name="tbl" id="tbl" value="events">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="event_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th width="3%"><?php echo Yii::t('default',"Event ID")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Event name")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Description")?></th> 
 <th width="5%"><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>
</form>