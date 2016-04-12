<?php
/**
 * Update Controller
 *
 */
class UpdateController extends CController
{
	public function actionIndex()
	{
		$prefix=Yii::app()->db->tablePrefix;
		$DbExt=new DbExt;
		
		/******************************************
		        VERSION 1.0.1 UPDATE
		******************************************/
		/*UPDATE TABLE USER*/
		$field_found=false;
		if ( $res = Yii::app()->functions->checkTableStructure("user")){
			foreach ($res as $val) {								
				if ($val['Field']=="lang_id"){
					$field_found=true;
				}
			}
			echo "Updating Table user...<br/>";
			if ($field_found==FALSE){				
				$stmt_alter="ALTER TABLE `".$prefix."user` ADD `lang_id` INT( 14 ) NOT NULL";
				if ($DbExt->qry($stmt_alter)){
					echo "(Done)<br/>";
				} else echo "(Failed)<br/>";
			} else echo "Table user is already Updated.<br/>";
		}
		
		echo "Creating Table Language..<br/>";
		
		$stmt_language_table="
CREATE TABLE IF NOT EXISTS `".$prefix."languages` (
  `lang_id` int(14) NOT NULL AUTO_INCREMENT,
  `country_code` varchar(14) CHARACTER SET utf8 NOT NULL,
  `language_code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `source_text` text CHARACTER SET utf8 NOT NULL,
  `is_assign` int(1) NOT NULL DEFAULT '2',
  `date_created` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `status` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";
		if ( !Yii::app()->functions->isTableExist("languages") ){			
			if ($DbExt->qry($stmt_language_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table Languages already exist.<br/>"; 
		
		
		/******************************************
		        VERSION 1.0.2 UPDATE
		******************************************/
        echo "<br/>Updating Table Currency..<br/>";	        
        $new_field=array(
          'date_created'=>"datetime NOT NULL",
          'date_modified'=>"datetime NOT NULL",
          'ip_address'=>"varchar(50) NOT NULL"
        );	        
        $this->alterTable('currency',$new_field);
        echo "<br/>";
        
        
        echo "<br/>Updating Table Order..<br/>";	        
        $new_field=array(
          'set_tax'=>"float NOT NULL",
          'delivery_charge'=>"float NOT NULL",
          'pre_approved_time'=>"varchar(255) NOT NULL",
          'delivery_asap'=>"int(2) NOT NULL DEFAULT '1'",
          'convenience_charge'=>"float(14,5) NOT NULL",
          'date_modified'=>"datetime NOT NULL"
        );	        
        $this->alterTable('order',$new_field);
        echo "<br/>";
        
        
        /******************************************
		        VERSION 1.0.3 UPDATE
		******************************************/
        echo "Creating Table SMS LOGS..<br/>";		
		$stmt_table="
CREATE TABLE IF NOT EXISTS ".$prefix."sms_logs (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `provider` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sms_message` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL,
  `response` varchar(255) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
		if ( !Yii::app()->functions->isTableExist("sms_logs") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table SMS LOGS already exist.<br/>"; 
		
		
        echo "Creating Table Order Status..<br/>";		
		$stmt_table="
CREATE TABLE IF NOT EXISTS ".$prefix."order_status (
  `stats_id` int(14) NOT NULL AUTO_INCREMENT,
  `description` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`stats_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
		if ( !Yii::app()->functions->isTableExist("order_status") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table Order Status already exist.<br/>"; 		
		
        echo "Creating Table Events..<br/>";		
		$stmt_table="
CREATE TABLE IF NOT EXISTS ".$prefix."events (
  `event_id` int(14) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";
		if ( !Yii::app()->functions->isTableExist("events") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table Events already exist.<br/>"; 				
		
		
		echo "<br/>Updating Table Order..<br/>";	        
        $new_field=array(
          'stats_id'=>"int(14) NOT NULL DEFAULT '4'",
          'delivery_date'=>"datetime NOT NULL",
          "delivery_time"=>"varchar(20) NOT NULL"
        );	        
        $this->alterTable('order',$new_field);
        echo "<br/>";
        
        
        echo "<br/>Updating Table Client..<br/>";	        
        $new_field=array(         
          'delivery_date'=>"datetime NOT NULL",
          "delivery_time"=>"varchar(20) NOT NULL"
        );	        
        $this->alterTable('client',$new_field);
        echo "<br/>";
		        	         	
        
        echo "Insert DATA on order status table<br/>";
        if ( !$this->checkStatusData()){
			$DbExt->insertData("{{order_status}}",array(
			'stats_id'=>1,
			'description'=>"pending"
			));
			$DbExt->insertData("{{order_status}}",array(
			'stats_id'=>2,
			'description'=>"cancelled"
			));
			$DbExt->insertData("{{order_status}}",array(
			'stats_id'=>3,
			'description'=>"delivered"
			));
			$DbExt->insertData("{{order_status}}",array(
			'stats_id'=>4,
			'description'=>"paid"
			));		
			echo "Insert data for order status done<br/>";
        } else echo "Already has data<br/>"; 
        
        
		echo "Creating Table Pages..<br/>";		
	    $stmt_table="
		CREATE TABLE IF NOT EXISTS ".$prefix."pages (
		`page_id` int(14) NOT NULL AUTO_INCREMENT,
		`page_name` varchar(255) CHARACTER SET utf8 NOT NULL,
		`page_icon` varchar(255) CHARACTER SET utf8 NOT NULL,
		`seo_title` varchar(255) CHARACTER SET utf8 NOT NULL,
		`meta_description` varchar(156) CHARACTER SET utf8 NOT NULL,
		`meta_keywords` varchar(255) CHARACTER SET utf8 NOT NULL,
		`description` text CHARACTER SET utf8 NOT NULL,
		`status` varchar(100) CHARACTER SET utf8 NOT NULL,
		`sequence` int(14) NOT NULL,
		`assign_menu` int(14) NOT NULL,
		`friendly_url` varchar(255) NOT NULL,
		`date_created` datetime NOT NULL,
		`date_modified` datetime NOT NULL,
		`ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
		PRIMARY KEY (`page_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		";
		if ( !Yii::app()->functions->isTableExist("pages") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table Pages already exist.<br/>"; 		        
        
		
		/*UPDATE 1.0.5*/
		echo "<br/>Updating Table ITEM..<br/>";	        
        $new_field=array(         
          'multi_option_title'=>"varchar(255) NOT NULL",
          "multi_option_number"=>"int(14) NOT NULL",
          "multi_id"=>"text NOT NULL"
        );	        
        $this->alterTable('item',$new_field);
        echo "<br/>";
        
        echo "<br/>Updating Table ORDER..<br/>";	        
        $new_field=array(         
          'voucher_code'=>"varchar(50) NOT NULL",
          "voucher_amount"=>"varchar(14) NOT NULL",
          "voucher_type"=>"varchar(14) NOT NULL"
        );	        
        $this->alterTable('order',$new_field);
        echo "<br/>";
        
        
        echo "<br/>Updating Table order_details.<br/>";	        
        $new_field=array(         
          'multi_id'=>"text NOT NULL"     
        );	        
        $this->alterTable('order_details',$new_field);
        echo "<br/>";
        
        echo "<br/>Updating Table user.<br/>";	        
        $new_field=array(         
          'user_type'=>"varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'admin'" ,
          "user_access"=>"text CHARACTER SET utf8 NOT NULL"
        );	        
        $this->alterTable('user',$new_field);
        echo "<br/>";
        
        
        echo "Creating Table voucher..<br/>";		
	    $stmt_table="
	    CREATE TABLE IF NOT EXISTS ".$prefix."voucher (
		  `voucher_id` int(14) NOT NULL AUTO_INCREMENT,
		  `voucher_name` varchar(255) CHARACTER SET utf8 NOT NULL,
		  `number_of_voucher` int(14) NOT NULL,
		  `amount` float NOT NULL,
		  `voucher_type` varchar(100) NOT NULL DEFAULT 'fixed amount',
		  `status` varchar(100) CHARACTER SET utf8 NOT NULL,
		  `date_created` varchar(50) CHARACTER SET utf8 NOT NULL,
		  `date_modified` datetime NOT NULL,
		  `ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
		  PRIMARY KEY (`voucher_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		";
		if ( !Yii::app()->functions->isTableExist("voucher") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table voucher already exist.<br/>"; 		        
		
		echo "<br/>";
		
		echo "Creating Table voucher_list<br/>";		
	    $stmt_table="
	    CREATE TABLE IF NOT EXISTS ".$prefix."voucher_list (
		  `voucher_id` int(14) NOT NULL,
		  `voucher_code` varchar(50) CHARACTER SET utf8 NOT NULL,
		  `status` varchar(50) NOT NULL DEFAULT 'unused',
		  `client_id` int(14) NOT NULL,
		  `date_used` varchar(50) CHARACTER SET utf8 NOT NULL,
		  `order_id` int(14) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		";
		if ( !Yii::app()->functions->isTableExist("voucher_list") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table voucher_list already exist.<br/>"; 		        
		
		echo "<br/>";
		
		echo "Creating Table multi_options<br/>";		
	    $stmt_table="
	    CREATE TABLE IF NOT EXISTS ".$prefix."multi_options (
		  `multi_id` int(14) NOT NULL AUTO_INCREMENT,
		  `multi_name` varchar(255) NOT NULL,
		  `sequence` int(14) NOT NULL,
		  `status` varchar(50) NOT NULL DEFAULT 'published',
		  `date_created` datetime NOT NULL,
		  `date_modified` datetime NOT NULL,
		  `ip_address` varchar(50) NOT NULL,
		  PRIMARY KEY (`multi_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
		";
		if ( !Yii::app()->functions->isTableExist("multi_options") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table multi_options already exist.<br/>"; 		        
		
		echo "<br/>";
		
		echo "<br/>Updating Table Order.<br/>";	        
        $new_field=array(         
          'cc_id'=>"int(14) NOT NULL" ,          
        );	        
        $this->alterTable('order',$new_field);
        echo "<br/>";
		
        echo "Creating Table client_cc<br/>";		
        
		$stmt_table="CREATE TABLE IF NOT EXISTS ".$prefix."client_cc (
		`cc_id` int(14) NOT NULL AUTO_INCREMENT,
		`client_id` int(14) NOT NULL,
		`card_name` varchar(255) NOT NULL,
		`credit_card_number` varchar(20) CHARACTER SET utf8 NOT NULL,
		`expiration_month` varchar(5) CHARACTER SET utf8 NOT NULL,
		`expiration_yr` varchar(5) CHARACTER SET utf8 NOT NULL,
		`cvv` varchar(20) CHARACTER SET utf8 NOT NULL,
		`billing_address` varchar(255) CHARACTER SET utf8 NOT NULL,
		`date_created` datetime NOT NULL,
		`ip_address` varchar(50) CHARACTER SET utf8 NOT NULL,
		PRIMARY KEY (`cc_id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		
		if ( !Yii::app()->functions->isTableExist("client_cc") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table client_cc already exist.<br/>"; 	

		
$stmt_table="
CREATE TABLE IF NOT EXISTS ".$prefix."braintree_trans (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(100) NOT NULL DEFAULT 'creditcard',
  `order_id` int(14) NOT NULL,
  `transaction_id` varchar(14) NOT NULL,
  `json_data` text NOT NULL,
  `date_created` datetime NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";		 
        if ( !Yii::app()->functions->isTableExist("braintree_trans") ){			
			if ($DbExt->qry($stmt_table)){
		        echo "(Done)<br/>";
            } else echo "(Failed)<br/>";	
		} else echo "Table braintree_trans already exist.<br/>"; 	
        
		echo "<br/>Updating Table Braintree.<br/>";	        
        $new_field=array(         
          'payment_method'=>"varchar(100) NOT NULL DEFAULT 'creditcard'" ,
          'date_created'=>"datetime NOT NULL",
          'ip_address'=>"varchar(100) NOT NULL"
        );	        
        $this->alterTable('braintree_trans',$new_field);
        echo "<br/>";
		
		echo "FINISH UPDATE(s)";
	}	
	
	public function alterTable($table='',$new_field='')
	{
		$DbExt=new DbExt;
		$prefix=Yii::app()->db->tablePrefix;		
		$existing_field='';
		if ( $res = Yii::app()->functions->checkTableStructure($table)){
			foreach ($res as $val) {								
				$existing_field[$val['Field']]=$val['Field'];
			}			
			foreach ($new_field as $key_new=>$val_new) {				
				if (!in_array($key_new,$existing_field)){
					echo "Creating field $key_new <br/>";
					$stmt_alter="ALTER TABLE ".$prefix."$table ADD $key_new ".$new_field[$key_new];
					dump($stmt_alter);
				    if ($DbExt->qry($stmt_alter)){
					   echo "(Done)<br/>";
				   } else echo "(Failed)<br/>";
				} else echo "Field $key_new already exist<br/>";
			}
		}
	}
	
	public function checkStatusData()
	{
		$DbExt=new DbExt;
		$stmt="SELECT * FROM  
		{{order_status}}
		";
		if ( $res=$DbExt->rst($stmt)){
			return true;
		}
		return false;
	}
	
} /*END CLASS*/