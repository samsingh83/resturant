<?php if (!isset($_SESSION)) { session_start(); }?>
<?php 
$voucher_id=isset($_GET['id'])?$_GET['id']:'';
?>
<div id="postContent">
<div class="receipt_main_wrapper">

<?php if (isset($_GET) && count($_GET)>=1):?>
	<?php if ( $res=Yii::app()->functions->voucherDetailsByIdWithClient($voucher_id) ):?>
	
<?php 
$stmt="SELECT a.*,
(
select fullname
from
{{client}}
where
client_id=a.client_id
) as fullname
 FROM
{{voucher_list}} a
WHERE
voucher_id='".$voucher_id."'
ORDER BY voucher_code ASC LIMIT 0,2000";

$_SESSION['export_stmt']=$stmt;
	?>
	
	<input type="hidden" value="1" id="voucher_export_text">
	
<table class="table">
<thead>
<tr>
<th><?php echo Yii::t('default',"Voucher Code")?></th> 
<th><?php echo Yii::t('default',"Status")?></th>
<th><?php echo Yii::t('default',"Date Used")?></th>
<th><?php echo Yii::t('default',"Use By")?></th>
</tr>
</thead>

<tbody>
<?php foreach ($res as $val) :?>
<tr>
<td width="5%"><?php echo $val['voucher_code']?></td>
<td width="5%"><?php echo $val['status']?></td>
<td width="5%"><?php echo !empty($val['date_used'])?date("M-d-Y",strtotime($val['date_used'])):"";?></td>
<td width="5%"><?php echo $val['fullname']?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>


	<?php else :?>
	<div class="alert alert-danger"><?php echo Yii::t('default',"Voucher ID does not exist")?>.</div>
	<?php endif;?>
<?php else :?>
<div class="alert alert-danger"><?php echo Yii::t('default',"Sorry but we cannot find what you are looking for")?>.</div>
<?php endif;?>

</div>
</div>