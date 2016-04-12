<div class="dashboard_wrap">

<div class="leftx">
<div id="total_sales_chart" class="chart"></div>
</div>
<div class="leftx">
<div id="total_sales_chart_by_item" class="chart"></div>
</div>
<div class="clear"></div>

 <div class="new_order_wrap">

 <div class="panel panel-default">  
  <div class="panel-heading"><?php echo Yii::t('default',"New Order List For Today")?> <?php echo date('F d, Y')?></div>
  <!--<div class="panel-body">
  </div>-->
  <!-- Table -->
  <form id="frm_table_list" method="POST" >
  <input type="hidden" name="action" id="action" value="categoryList">
  <input type="hidden" name="tbl" id="tbl" value="category">
  <input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
  <input type="hidden" name="whereid"  id="whereid" value="cat_id">
  <table class="table">
    <thead>
    <tr>
    <th width="3%"><?php echo Yii::t('default',"REFID")?></th>
    <th><?php echo Yii::t('default',"CLient Name")?></th>
    <th><?php echo Yii::t('default',"Trans Type")?></th>
    <th><?php echo Yii::t('default',"Payment Type")?></th>
    <th><?php echo Yii::t('default',"Total")?> </th>
    <th><?php echo Yii::t('default',"Tax")?> </th>
    <th><?php echo Yii::t('default',"Total W/Tax")?></th>    
    <th><?php echo Yii::t('default',"Date")?> </th>
    <th><?php echo Yii::t('default',"Status")?></th>
    <th><?php echo Yii::t('default',"Action")?></th>    
    </tr>
    </thead>
    <tbody>
    <?php if ($res=Yii::app()->functions->newOrderList("pending")):?>
    <?php foreach ($res as $val):?>
    <tr>
    <td><?php echo $val['order_id']?></td>
    <td><?php echo $val['client_name']?></td>
    <td><?php echo $val['trans_type']?></td>
    <td><?php echo $val['payment_type']?></td>
    <td><?php echo $val['total']?></td>
    <td><?php echo $val['tax']?></td>
    <td><?php echo $val['total_w_tax']?></td>
    <td><?php echo date('F d G:i:s',strtotime($val['date_created']))?></td>
    <td><?php echo $val['stats_id']?></td>
    <td>
    <a data-id="<?php echo $val['order_id'];?>" href="javascript:;" rel="<?php echo $val['stats_id']?>" class="edit_status_order"><i class="fa fa-pencil-square-o"></i> <?php echo Yii::t('default',"Edit")?></a>
    
    <a data-id="<?php echo $val['order_id'];?>" href="javascript:;" class="view_receipt"><i class="fa fa-file-text-o"></i> <?php echo Yii::t('default',"View")?></a>
        
    </td>    
    <?php endforeach;?>
    <?php endif;?>    
    </tr>
    </tbody>
  </table>
  </form>
 </div>
 
 </div> <!--END new_order_wrap-->

</div> <!--END dashboard_wrap-->