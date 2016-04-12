<?php

class InstallController extends CController
{
	public $layout='install_tpl';
	public $code=2;
	public $msg='';
	public $data;
	
	public function actionIndex()
	{
		$this->render('install');
	}
	
	public function actionAjax()
	{				
		$this->data=$_POST;
	    $validator=new Validator;
    	$req=array(
    	  'store_name'=>Yii::t("default","Store name is required"),
    	  'currency_code'=>Yii::t("default","Currency Code is required"),
    	  'address'=>Yii::t("default","Address is required"),
    	  'phone_number'=>Yii::t("default","Phone number is required"),
    	  'contact_email'=>Yii::t("default","Contact Email is required"),
    	  'username'=>Yii::t("default","Username is required"),
    	  'password'=>Yii::t("default","Password is required")
    	);
    	$validator->required($req,$this->data);
    	if ($validator->validate()){	
    		$this->createTable();      	
    		yii::app()->functions->updateOption('store_name',$this->data['store_name']);
    		yii::app()->functions->updateOption('currency_code',$this->data['currency_code']);
    		yii::app()->functions->updateOption('address',$this->data['address']);
    		yii::app()->functions->updateOption('phone_number',$this->data['phone_number']);
    		yii::app()->functions->updateOption('contact_email',$this->data['contact_email']);

    		$params=array(
    		  'full_name'=>"Admin",
    		  'username'=>$this->data['username'],
    		  'password'=>md5($this->data['password']),
    		  'date_created'=>date('c')
    		);    		
    		$db_ext=new DbExt;
    		if ($db_ext->insertData("{{user}}",$params)){
    		    $this->code=1;
    		    $this->msg="Application ".$this->data['store_name'].Yii::t("default"," Successfully Installed.");
    	    } else $this->msg=Yii::t("default","ERROR: cannot insert user.");
    	} else $this->msg=$validator->getErrorAsHTML();	  
    	
    	$resp=array('code'=>$this->code,'msg'=>$this->msg); 
    	echo json_encode($resp);
	}
	
	private function createTable()
	{	
		$db_ext=new DbExt;
		require Yii::getPathOfAlias('webroot')."/protected/config/".'table_structure.php';		
		if (is_array($tbl) && count($tbl)>=1){
			foreach ($tbl as $sql) {												
				$db_ext->qry($sql);
			}
		}
		$insert_data=new InsertData;
		$insert_data->up();
	}
	
} /*END CLASS*/


class InsertData extends DbExt  
{
	
	public function up()
	{
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"USD",
		  "currency_symbol"=>"&#36;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"EUR",
		  "currency_symbol"=>"&euro;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"JPY",
		  "currency_symbol"=>"&yen;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"AUD",
		  "currency_symbol"=>"&#36;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"MXN",
		  "currency_symbol"=>"&#36;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"NZD",
		  "currency_symbol"=>"&#36;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"HKD",
		  "currency_symbol"=>"&#36;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"CNY",
		  "currency_symbol"=>"&yen;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"MYR",
		  "currency_symbol"=>"&#82;&#77;"
		));
		$this->insertData("{{currency}}",array(
		  "currency_code"=>"CAD",
		  "currency_symbol"=>"&#36;"
		));		
		$this->insertData("{{size}}",array(
		  'size_name'=>"small",
		  'sequence'=>"1",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{size}}",array(
		  'size_name'=>"medium",
		  'sequence'=>"2",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{size}}",array(
		  'size_name'=>"large",
		  'sequence'=>"3",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{cooking_ref}}",array(
		  'cooking_name'=>"rare",
		  'sequence'=>"1",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{cooking_ref}}",array(
		  'cooking_name'=>"medium rare",
		  'sequence'=>"2",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{cooking_ref}}",array(
		  'cooking_name'=>"medium well",
		  'sequence'=>"3",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
		$this->insertData("{{cooking_ref}}",array(
		  'cooking_name'=>"well done",
		  'sequence'=>"4",
		  'status'=>"published",
		  'date_created'=>date('c')
		));
				
		/*insert order status*/
		$this->insertData("{{order_status}}",array(
		  'stats_id'=>1,
		  'description'=>"pending"
		));
		$this->insertData("{{order_status}}",array(
		  'stats_id'=>2,
		  'description'=>"cancelled"
		));
		$this->insertData("{{order_status}}",array(
		  'stats_id'=>3,
		  'description'=>"delivered"
		));
		$this->insertData("{{order_status}}",array(
		  'stats_id'=>4,
		  'description'=>"paid"
		));		
	}
	
	public function down()
	{
       echo Yii::t("default","Currency Table does not support migration down").".\n";
       return false;
    }
}

function dump($data='')
{
	echo '<pre>';print_r($data);echo '</pre>';
}