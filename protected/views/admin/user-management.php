<div class="rightx">

<a href="<?php echo Yii::app()->request->baseUrl;?>/admin/useradd" class="uk-button">
<i class="fa fa-plus"></i>
<?php echo Yii::t('default',"Add New User")?>
</a>


<form id="frm_table_list" method="POST" class="uk-form uk-form-horizontal" >

<input type="hidden" name="action" id="action" value="userList">
<input type="hidden" name="tbl" id="tbl" value="user">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="user_id">

<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
<thead>
<tr>
 <!--<th><input type="checkbox" id="chk_all" class="chk_all"></th>-->
 <th><?php echo Yii::t('default',"Name")?></th> 
 <th><?php echo Yii::t('default',"Username")?></th> 
 <th><?php echo Yii::t('default',"User Type")?></th> 
 <th><?php echo Yii::t('default',"User Language")?></th>
 <th><?php echo Yii::t('default',"Date")?></th>
 <th><?php echo Yii::t('default',"LastLogin")?></th>
</tr>
</thead>
</table>


</form>
</div> <!--END right-->
<div class="clear"></div>