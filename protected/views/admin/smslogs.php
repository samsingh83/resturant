
<h2>SMS Notification Logs</h2>

<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal" >

<input type="hidden" name="action" id="action" value="smsLogs">
<input type="hidden" name="tbl" id="tbl" value="sms_logs">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="id">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <th>ID</th>
 <th><?php echo Yii::t('default',"Provider")?></th>
 <th><?php echo Yii::t('default',"Message")?></th>
 <th><?php echo Yii::t('default',"Mobile")?></th>
 <th><?php echo Yii::t('default',"Status")?></th>
 <th><?php echo Yii::t('default',"Date")?></th>
</tr>
</thead>
</table>

</form>