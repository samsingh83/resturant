<?php
/*******************************************
@author : bastikikang 
@author email: basti@codemywebapps.com
@author website : http://codemywebapps.com
*******************************************/

if (!isset($_SESSION)) { session_start(); }

if (!class_exists('AjaxAdmin'))
{
	class AjaxAdmin
	{
		public $data;
		public $code=2;
		public $msg;
		public $details;
		
		public function otableNodata()
		{
	        $feed_data['sEcho']=1;
	        $feed_data['iTotalRecords']=0;
	        $feed_data['iTotalDisplayRecords']=0;
	        $feed_data['aaData']=array();		
	        echo json_encode($feed_data);
	    	die();
		}
    
		public function otableOutput($feed_data='')
		{
    	  echo json_encode($feed_data);
    	  die();
        }
    
		public function output($debug=FALSE)
		{
    	    $resp=array('code'=>$this->code,'msg'=>$this->msg,'details'=>$this->details);
    	    if ($debug){
    		    dump($resp);
    	    }
    	    return json_encode($resp);    	    
		}
		
		public function addCategory()
		{
			/*if (!isset($this->data['photo'])){
			   $this->data['photo']='';
			   $this->msg="Featured image is required.";
			   return ;			   
			}*/
					
			$params=array(
			  'category_name'=>addslashes($this->data['category_name']),
			  'category_description'=>addslashes($this->data['category_description']),
			  'photo'=>addslashes($this->data['photo']),
			  'status'=>addslashes($this->data['status']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);									
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{category}}' , $params , 
				'cat_id=:cat_id' , array(':cat_id'=> addslashes($this->data['id']) ));
				if ($res){
					$this->code=1;
	                $this->msg=Yii::t("default",'Category updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{category}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Category added.');  
	                $this->details=Yii::app()->db->getLastInsertID();	                
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
		}
		
		public function categoryList()
		{
			$stmt="
			SELECT * FROM
			{{category}}
			ORDER BY cat_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	 
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[cat_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"category-new?id=$val[cat_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[cat_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));    	    		
    	    		if (!empty($val['photo'])){
    	    			$img=Yii::app()->request->baseUrl."/upload/$val[photo]";
    	    		    $photo="<img src=\"$img\" >";	
    	    		} else $photo='';
    	    		$feed_data['aaData'][]=array(
    	    		  $chk,$val['category_name'].$option,$val['category_description'],$photo,$date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();
		}
		
		public function rowDelete()
		{			 			
			 if (isset($this->data['tbl']))
			 {
			 	if ($this->data['tbl']=="order_status"){
			 		if ( Yii::app()->functions->orderStatusHasRef($this->data['row_id']) ){
			 			$this->msg="ERROR: Cannot delete this order status it has referrence to other tables.";
			 			return;
			 		}			 				 		
			 	}			 
			 				 	
			 }		
			 
			 $whereid=$this->data['whereid'];
			 $tbl=Yii::app()->db->tablePrefix.$this->data['tbl'];
			 $query = "DElETE FROM $tbl WHERE $whereid=". Yii::app()->db->quoteValue($this->data['row_id']) ." "; 
			 if (Yii::app()->db->createCommand($query)->query()){
			     $this->msg=Yii::t("default","Successfully deleted.");
                 $this->code=1;	
                 
                 if ($this->data['tbl']=="voucher"){
                 	$query2 = "DElETE FROM {{voucher_list}} WHERE voucher_id=". Yii::app()->db->quoteValue($this->data['row_id']) ." "; 
                 	Yii::app()->db->createCommand($query2)->query();
			 	}			 	
			 				 	
			 } else $this->msg=Yii::t("default","ERROR: cannot execute query.");
		}
		
		public function rowDeleteBulk()
		{			
			$ids='';
						
			$tbl=Yii::app()->db->tablePrefix.addslashes($this->data['tbl']);
			$whereid=addslashes($this->data['whereid']);
						
			if (is_array($this->data['row']) && count($this->data['row'])>=1){
				foreach ($this->data['row'] as $id) {
					$ids.="".Yii::app()->db->quoteValue($id).",";
				}
				$ids=substr($ids,0,-1);				
				$query = "DElETE FROM $tbl 
				         WHERE 
				         $whereid in ($ids)
				         "; 	
				if (Yii::app()->db->createCommand($query)->query()){
			        $this->msg=Yii::t("default","Successfully deleted.");
                    $this->code=1;	
			    } else $this->msg=Yii::t("default","ERROR: cannot execute query.");				
			} else $this->msg=Yii::t("default","No row to delete.");
		}
		
		public function addItem()
		{
			//dump($this->data);
			if (is_array($this->data['price']) && count($this->data['price'])>=1){
				$x=0;
				foreach ($this->data['price'] as $price) {
					if (is_numeric($price)){
						$price_size[]=array(
						  'price'=>$price,
						  'size'=>$this->data['size'][$x]==0?'':$this->data['size'][$x]
						);
						$x++;
					}					
				}							
			} /*END IF*/
			
			if (!isset($this->data['sub_item_id'])){
				$this->data['sub_item_id']='';
			}		
			if (!isset($this->data['cooking_ref'])){
				$this->data['cooking_ref']='';
			}
			if (!isset($this->data['sub_item_id'])){
				$this->data['sub_item_id']='';
			}		
			if (!isset($this->data['photo'])){
				$this->data['photo']='';
			}		
			
			$params=array(
			 'item_name'=>addslashes($this->data['item_name']),
			 'item_description'=>addslashes($this->data['item_description']),
			 'status'=>addslashes($this->data['status']),
			 'category'=>json_encode($this->data['category']),
			 'price'=>json_encode($price_size),
			 'subcat_item'=>json_encode($this->data['sub_item_id']),
			 'cooking_ref'=>json_encode($this->data['cooking_ref']),
			 'discount'=>addslashes($this->data['discount']),
			 'photo'=>addslashes($this->data['photo']),
			 'date_created'=>date('c'),
			 'ip_address'=>$_SERVER['REMOTE_ADDR'],
			 'multi_option_title'=>isset($this->data['multi_option_title'])?$this->data['multi_option_title']:"",
			 'multi_option_number'=>isset($this->data['multi_option_number'])?$this->data['multi_option_number']:0,
			 'multi_id'=>isset($this->data['multi_id'])?json_encode($this->data['multi_id']):"",
			);
			//dump($this->data);
			/*dump($params);										
			die();*/
			$command = Yii::app()->db->createCommand();
			
			if (is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');
				$res = $command->update('{{item}}' , $params , 
				'item_id=:item_id' , array(':item_id'=>addslashes($this->data['id'])) );
				if ($res){
					$this->code=1;
	                $this->msg=Yii::t("default",'Item updated.');
	                  
	                $item_id=$this->data['id'];
	                $tbl=Yii::app()->db->tablePrefix."item_option";	               
	                Yii::app()->db->createCommand("DELETE FROM $tbl WHERE item_id='".addslashes($item_id)."' ")->query();
	                if (is_array($price_size) && count($price_size)>=1){
		               	foreach ($price_size as $price_val) {
		               		$price_params=array(
		               		  'item_id'=>$item_id,
		               		  'option_name'=>'price',
		               		  'option_value'=>json_encode($price_val)
		               		);
		               		$command->insert('{{item_option}}',$price_params);
		               	}
		            }	 
		            $tbl=Yii::app()->db->tablePrefix."item_relationship";
		            Yii::app()->db->createCommand("DELETE FROM $tbl WHERE item_id='".addslashes($item_id)."' ")->query();
		            foreach ($this->data['category'] as $cat_id) {
		            	$p=array(
		            	  'item_id'=>$item_id,
		            	  'cat_id'=>$cat_id
		            	);
		            	$command->insert('{{item_relationship}}',$p);
	                }           
	                
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {
			 
				if ($res=$command->insert('{{item}}',$params)){
		            $this->code=1;
		            $this->msg='Item added.';  
		            $item_id=Yii::app()->db->getLastInsertID();
		            $this->details=$item_id;
		            
		            if (is_array($price_size) && count($price_size)>=1){
		               	foreach ($price_size as $price_val) {
		               		$price_params=array(
		               		  'item_id'=>$item_id,
		               		  'option_name'=>'price',
		               		  'option_value'=>json_encode($price_val)
		               		);
		               		$command->insert('{{item_option}}',$price_params);
		               	}
		            }	 		            
		            if (is_array($this->data['category']) && count($this->data['category'])>=1){
			            foreach ($this->data['category'] as $cat_id) {
			            	$p=array(
			            	  'item_id'=>$item_id,
			            	  'cat_id'=>$cat_id
			            	);
			            	$command->insert('{{item_relationship}}',$p);
		                }           
		            }
		       } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
		    }
		}
		
		public function itemList()
		{			
			yii::app()->functions->data='list';
			$cat_list=yii::app()->functions->getCategory();			
			
			$cat='';
			
			$stmt="
			SELECT a.* 
			FROM {{item}} a			
			ORDER BY item_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    //dump($rows);
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	 
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[item_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"item-new?id=$val[item_id]\" >Edit</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[item_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$date.="<div>$val[status]</div>";
    	    		
    	    		if (!empty($val['photo'])){
    	    			$img=Yii::app()->request->baseUrl."/upload/$val[photo]";
    	    		    $photo="<img src=\"$img\" >";	
    	    		} else $photo='';
    	    		
    	    		if (!empty($val['category'])){
    	    			$category=json_decode($val['category']);    	    			
    	    			if (is_array($category) && count($category)>=1){
	    	    			foreach ($category as $cat_id) { 
	    	    				if (array_key_exists($cat_id,$cat_list)){   	    				
	    	    				   $cat.=$cat_list[$cat_id].",";
	    	    				}
	                        }    	
	                        $cat=substr($cat,0,-1);
    	    			}
    	    		}    	    	
    	    		$price=yii::app()->functions->prettyPrice($val['price']);
    	    		$feed_data['aaData'][]=array(
    	    		  $chk,$val['item_name'].$option,
    	    		  Yii::app()->functions->limitText($val['item_description']),
    	    		  $cat,$price,$photo,$date
    	    		);
    	    		$cat='';
    	    	}    	    	
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();
		}
		
		public function addSubcategory()
		{
		    $params=array(
			  'subcategory_name'=>addslashes($this->data['subcategory_name']),
			  'subcategory_description'=>addslashes($this->data['subcategory_description']),
			  'discount'=>addslashes($this->data['discount']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);							
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{subcategory}}' , $params , 
				'subcat_id=:subcat_id' , array(':subcat_id'=>addslashes($this->data['id'])));
				if ($res){
					$this->code=1;
	                $this->msg=Yii::t("default",'SubCategory updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{subcategory}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'SubCategory added.');  
	                $this->details=Yii::app()->db->getLastInsertID();	
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
	    }
	     
	    public function subCategoryList()
	    {	    
	        $stmt="
			SELECT * FROM
			{{subcategory}}
			ORDER BY subcat_id  DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[subcat_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"sub-category-new?id=$val[subcat_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[subcat_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$feed_data['aaData'][]=array(
    	    		  $chk,$val['subcategory_name'].$option,$val['subcategory_description'],
    	    		  $val['discount']
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }	     
	    
	    public function subCategoryAdditem()
	    {
	    	if (!isset($this->data['photo'])){
	    		$this->data['photo']='';
	    	}
	    		   
	    	$params=array(
			  'sub_item_name'=>addslashes($this->data['sub_item_name']),
			  'item_description'=>addslashes($this->data['item_description']),
			  'category'=>json_encode($this->data['category']),
			  'price'=>trim($this->data['price']),
			  'photo'=>addslashes(trim($this->data['photo'])),
			  'status'=>addslashes($this->data['status']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{subcategory_item}}' , $params , 
				'sub_item_id=:sub_item_id' , array(':sub_item_id'=>addslashes($this->data['id'])));
				if ($res){
					$this->code=1;
	                $this->msg=Yii::t("default",'AddOn Item updated.');  
	                $item_id=$this->data['id'];
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{subcategory_item}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'AddOn Item added.');  
	                $item_id=Yii::app()->db->getLastInsertID();
	                $this->details=$item_id;
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
			
			if ($this->code==1){
				if (is_array($this->data['category']) && count($this->data['category'])>=1){
					$tbl=Yii::app()->db->tablePrefix."subcat_relationship";
					Yii::app()->db->createCommand("DELETE FROM $tbl WHERE sub_item_id='".addslashes($item_id)."' ")->query();
				    foreach ($this->data['category'] as $catid) {
				    	$i=array('subcat_id'=>$catid,'sub_item_id'=>$item_id);
				    	$command->insert('{{subcat_relationship}}',$i);
				    }	
				}			
			}
	    }
	    
	    public function subCategoryItemList()
	    {
	    	yii::app()->functions->data='list';
			$cat_list=yii::app()->functions->getSubcategory();			
			
			$cat='';
			
			$stmt="
			SELECT a.* 
			FROM {{subcategory_item}} a			
			ORDER BY sub_item_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	        	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	 
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[sub_item_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"sub-category-item-new?id=$val[sub_item_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[sub_item_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		if (!empty($val['category'])){
    	    			$category=json_decode($val['category']);
    	    			if (is_array($category) && count($category)>=1){
	    	    			foreach ($category as $cat_id) {    	    				
	    	    				$cat.=$cat_list[$cat_id].",";
	                        }    	
	                        $cat=substr($cat,0,-1);
    	    			}
    	    		}    	    	    	    
    	    		
    	    		if (!empty($val['photo'])){
    	    			$img=Yii::app()->request->baseUrl."/upload/$val[photo]";
    	    		    $photo="<img src=\"$img\" >";	
    	    		} else $photo='';
    	    				
    	    		$feed_data['aaData'][]=array(
    	    		  $chk,$val['sub_item_name'].$option,$val['item_description'],$cat,
    	    		  yii::app()->functions->getCurrencyCode().$val['price'],$photo,$date."<div>$val[status]</div>"
    	    		);
    	    		$cat='';
    	    	}    	    	    	    	
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();
	    }
	    
	    public function addSize()
	    {
	        $params=array(
			  'size_name'=>addslashes($this->data['size_name']),			  
			  'status'=>addslashes($this->data['status']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{size}}' , $params , 
				'size_id=:size_id' , array(':size_id'=>addslashes($this->data['id'])) );
				if ($res){					
					$this->code=1;
	                $this->msg=Yii::t("default",'Size updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{size}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Size added.');  
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
	    }
	    
	    public function sizeList()
	    {
	    	$stmt="
			SELECT * FROM
			{{size}}
			ORDER BY size_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[size_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"other-item-size?id=$val[size_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[size_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['size_name'].$option,$date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }
	    
	    public function cookingRefAdd()
	    {
	    	$params=array(
			  'cooking_name'=>addslashes($this->data['cooking_name']),			  
			  'status'=>addslashes($this->data['status']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{cooking_ref}}' , $params , 
				'cook_id=:cook_id' , array(':cook_id'=> addslashes($this->data['id']) ));
				if ($res){					
					$this->code=1;
	                $this->msg=Yii::t("default",'Cooking reference updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{cooking_ref}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Cooking reference added.');  
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
	    }
	    
	    public function cookingRefList()
	    {
	    	$stmt="
			SELECT * FROM
			{{cooking_ref}}
			ORDER BY cook_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[cook_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"cooking-ref?id=$val[cook_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[cook_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['cooking_name'].$option,$date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }	
	    
	    public function settings()
	    {	        
	        if (!isset($this->data['address'])){
	        	$this->data['address']='';
	        }	    
	        if (!isset($this->data['phone_number'])){
	        	$this->data['phone_number']='';
	        }
	        if (!isset($this->data['tax_amount'])){
	        	$this->data['tax_amount']='';
	        }
	        if (!isset($this->data['delivery_charges'])){
	        	$this->data['delivery_charges']='';
	        }
	        if (!isset($this->data['receipt_msg'])){
	        	$this->data['receipt_msg']='';
	        }
	        if (!isset($this->data['email_address_notify'])){
	        	$this->data['email_address_notify']='';
	        }
	        if (!isset($this->data['stores_open_start'])){
	        	$this->data['stores_open_start']='';
	        }
	        if (!isset($this->data['stores_open_end'])){
	        	$this->data['stores_open_end']='';
	        }
	        if (!isset($this->data['close_msg'])){
	        	$this->data['close_msg']='';
	        }
	        if (!isset($this->data['stores_open_day'])){
	        	$this->data['stores_open_day']='';
	        }
	        if (!isset($this->data['delivery_distance'])){
	        	$this->data['delivery_distance']='';
	        }
	        if (!isset($this->data['store_name'])){
	        	$this->data['store_name']='';
	        }
	        if (!isset($this->data['contact_email'])){
	        	$this->data['contact_email']='';
	        }
	        if (!isset($this->data['photo'])){
	        	$this->data['photo']='';
	        }	    
	        if (!isset($this->data['minimum_order'])){
	        	$this->data['minimum_order']='';
	        }	    	        
	        if (!isset($this->data['decimal_places'])){
	        	$this->data['decimal_places']='';
	        }	    
	        if (!isset($this->data['decimal_separators'])){
	        	$this->data['decimal_separators']=false;
	        }	    
	        if (!isset($this->data['country_code'])){
	        	$this->data['country_code']='';
	        }
	        	        
	        if (!isset($this->data['stores_open_am_start'])){
	        	$this->data['stores_open_am_start']='';
	        }
	        if (!isset($this->data['stores_open_am_end'])){
	        	$this->data['stores_open_am_end']='';
	        }
	        if (!isset($this->data['text_day'])){
	        	$this->data['text_day']='';
	        }
	        if (!isset($this->data['stores_open_pm_start'])){
	        	$this->data['stores_open_pm_start']='';
	        }
	        if (!isset($this->data['stores_open_pm_end'])){
	        	$this->data['stores_open_pm_end']='';
	        }	        
	        if (!isset($this->data['footer_store_name'])){
	        	$this->data['footer_store_name']='';
	        }
	        
	        if (!isset($this->data['checkout_type_1'])){
	        	$this->data['checkout_type_1']='';
	        }
	        if (!isset($this->data['checkout_type_2'])){
	        	$this->data['checkout_type_2']='';
	        }
	        
	        if ( $this->data['checkout_type_1'] =="" && $this->data['checkout_type_2']==""){
	        	$this->msg="CheckOut Type is required.";
	        	return ;
	        }	    
	        
	        if (!isset($this->data['allowed_ordering'])){
	        	$this->data['allowed_ordering']=1;
	        }
	        if (!isset($this->data['custom_opening_msg'])){
	        	$this->data['custom_opening_msg']='';
	        }	    
	        
	        if (!isset($this->data['voucher_enabled'])){
	        	$this->data['voucher_enabled']='';
	        }
	        	        
	        if (!empty($this->data['currency_code'])){
		        yii::app()->functions->updateOption('address',$this->data['address']);
		        yii::app()->functions->updateOption('phone_number',$this->data['phone_number']);
		        yii::app()->functions->updateOption('tax_amount',$this->data['tax_amount']);
		        yii::app()->functions->updateOption('delivery_charges',$this->data['delivery_charges']);
		        yii::app()->functions->updateOption('receipt_msg',$this->data['receipt_msg']);
		        yii::app()->functions->updateOption('email_address_notify',$this->data['email_address_notify']);
		        yii::app()->functions->updateOption('stores_open_start',$this->data['stores_open_start']);
		        yii::app()->functions->updateOption('stores_open_end',$this->data['stores_open_end']);
		        yii::app()->functions->updateOption('close_msg',$this->data['close_msg']);
		        yii::app()->functions->updateOption('stores_open_day',json_encode($this->data['stores_open_day']));
		        yii::app()->functions->updateOption('delivery_distance',$this->data['delivery_distance']);
		        yii::app()->functions->updateOption('store_name',$this->data['store_name']);
		        yii::app()->functions->updateOption('contact_email',$this->data['contact_email']);
		        yii::app()->functions->updateOption('currency_code',$this->data['currency_code']);
		        yii::app()->functions->updateOption('store_logo',$this->data['photo']);		        
		        yii::app()->functions->updateOption('minimum_order',$this->data['minimum_order']);
		        yii::app()->functions->updateOption('decimal_places',$this->data['decimal_places']);
		        yii::app()->functions->updateOption('decimal_separators',$this->data['decimal_separators']);
		        yii::app()->functions->updateOption('country_code',$this->data['country_code']);
		        
		        yii::app()->functions->updateOption('stores_open_am_start',json_encode($this->data['stores_open_am_start']));
		        yii::app()->functions->updateOption('stores_open_am_end',json_encode($this->data['stores_open_am_end']));
		        yii::app()->functions->updateOption('text_day',json_encode($this->data['text_day']));
		        yii::app()->functions->updateOption('stores_open_pm_start',json_encode($this->data['stores_open_pm_start']));
		        yii::app()->functions->updateOption('stores_open_pm_end',json_encode($this->data['stores_open_pm_end']));
		        yii::app()->functions->updateOption('footer_store_name',$this->data['footer_store_name']);
		        
		        yii::app()->functions->updateOption('checkout_type_1',$this->data['checkout_type_1']);
		        yii::app()->functions->updateOption('checkout_type_2',$this->data['checkout_type_2']);
		        yii::app()->functions->updateOption('allowed_ordering',$this->data['allowed_ordering']);
		        yii::app()->functions->updateOption('custom_opening_msg',$this->data['custom_opening_msg']);
		        yii::app()->functions->updateOption('voucher_enabled',$this->data['voucher_enabled']);
		        
		        yii::app()->functions->updateOption('disabled_wishlist',
		        !isset($this->data['disabled_wishlist'])?"":$this->data['disabled_wishlist']);
		        
		        yii::app()->functions->updateOption('disabled_notes',
		        !isset($this->data['disabled_notes'])?"":$this->data['disabled_notes']);
		        
		        yii::app()->functions->updateOption('disabled_events',
		        !isset($this->data['disabled_events'])?"":$this->data['disabled_events']);
		        
		        yii::app()->functions->updateOption('disabled_cashondelivery',
		        !isset($this->data['disabled_cashondelivery'])?"":$this->data['disabled_cashondelivery']);
		        
		        yii::app()->functions->updateOption('disabled_voucher',
		        !isset($this->data['disabled_voucher'])?"":$this->data['disabled_voucher']);		        
		        
		        yii::app()->functions->updateOption('disabled_offlinepayment',
		        !isset($this->data['disabled_offlinepayment'])?"":$this->data['disabled_offlinepayment']);		        
		        
		        yii::app()->functions->updateOption('disabled_reservation',
		        !isset($this->data['disabled_reservation'])?"":$this->data['disabled_reservation']);		        
		        
		        yii::app()->functions->updateOption('store_hours_format',
		        !isset($this->data['store_hours_format'])?"":$this->data['store_hours_format']);		        
		        
		        yii::app()->functions->updateOption('enabled_preorder',
		        !isset($this->data['enabled_preorder'])?"":$this->data['enabled_preorder']);		        
		        
		        yii::app()->functions->updateOption('disabled_checkout',
		        !isset($this->data['disabled_checkout'])?"":$this->data['disabled_checkout']);		        
		        		        
		        yii::app()->functions->updateOption('convenience_charge',
		        !isset($this->data['convenience_charge'])?"":$this->data['convenience_charge']);		        
		        		        
		        $this->code=1;
		        $this->msg=Yii::t("default","Settings saved.");
	        } else $this->msg=Yii::t("default","Currency Code is required");
	    }	
	    
	    public function paypalSettings()
	    {
	    	if (!isset($this->data['sanbox_paypa_user'])){
	    		$this->data['sanbox_paypa_user']='';
	    	}	    
	    	if (!isset($this->data['sanbox_paypa_pass'])){
	    		$this->data['sanbox_paypa_pass']='';
	    	}
	    	if (!isset($this->data['sanbox_paypa_signature'])){
	    		$this->data['sanbox_paypa_signature']='';
	    	}
	    	if (!isset($this->data['live_paypa_user'])){
	    		$this->data['live_paypa_user']='';
	    	}
	    	if (!isset($this->data['live_paypa_pass'])){
	    		$this->data['live_paypa_pass']='';
	    	}
	    	if (!isset($this->data['live_paypa_signature'])){
	    		$this->data['live_paypa_signature']='';
	    	}
	    	if (!isset($this->data['paypal_enabled'])){
	    		$this->data['paypal_enabled']='';
	    	}
	    	if (!isset($this->data['paypal_mode'])){
	    		$this->data['paypal_mode']='';
	    	}
	    	yii::app()->functions->updateOption('sanbox_paypa_user',$this->data['sanbox_paypa_user']);
	    	yii::app()->functions->updateOption('sanbox_paypa_pass',$this->data['sanbox_paypa_pass']);
	    	yii::app()->functions->updateOption('sanbox_paypa_signature',$this->data['sanbox_paypa_signature']);
	    	yii::app()->functions->updateOption('live_paypa_user',$this->data['live_paypa_user']);
	    	yii::app()->functions->updateOption('live_paypa_pass',$this->data['live_paypa_pass']);
	    	yii::app()->functions->updateOption('live_paypa_signature',$this->data['live_paypa_signature']);
	    	yii::app()->functions->updateOption('live_paypa_signature',$this->data['live_paypa_signature']);
	    	yii::app()->functions->updateOption('paypal_enabled',$this->data['paypal_enabled']);
	    	yii::app()->functions->updateOption('paypal_mode',$this->data['paypal_mode']);
	        $this->code=1;
	        $this->msg=Yii::t("default","Settings saved.");
	    }
	    
	    public function addUser()
	    {	    
	    	
	    	if ( !isset($this->data['user_access'])){
	    		$this->data['user_access']='';
	    	}
	    
	    	$DbExt=new DbExt;
	    	$params=array(
	    	  'full_name'=>addslashes($this->data['full_name']),
	    	  'username'=>addslashes($this->data['username']),
	    	  'password'=>md5($this->data['password']),
	    	  'status'=>$this->data['status'],
	    	  'date_created'=>date('c'),
	    	  'lang_id'=>$this->data['lang_id'],
	    	  'user_type'=>$this->data['user_type'],
	    	  'user_access'=>json_encode($this->data['user_access'])
	    	);
	    		    	
	    	if (empty($this->data['password'])){
	    	    unset($params['password']);
	    	}	    	    	
	    	$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				
				$stmt_check="
				SELECT * FROM
				{{user}}
				WHERE
				username='".$this->data['username']."'
				AND
				user_id NOT IN ('".$this->data['id']."')
				";		
				if (!$DbExt->rst($stmt_check)){
					$res = $command->update('{{user}}' , $params , 
					'user_id=:user_id' , array(':user_id'=> addslashes($this->data['id']) ));
					if ($res){					
						$this->code=1;
		                $this->msg=Yii::t("default",'User updated.');  
					} else $this->msg=Yii::t("default","ERROR: cannot updated.");
				} else $this->msg=Yii::t("default","Username already exist");
			} else {		
				$stmt_check="
				SELECT * FROM
				{{user}}
				WHERE
				username='".$this->data['username']."'
				";		
				if (!$DbExt->rst($stmt_check)){
					if ($res=$command->insert('{{user}}',$params)){
		                $this->code=1;
		                $this->msg=Yii::t("default",'User added.');  
		                $this->details=Yii::app()->db->getLastInsertID();
		            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
				} else $this->msg=Yii::t("default","Username already exist");
			}
	    }	
	    
	    public function userList()
	    {
	    	$stmt="
			SELECT a.*,
			(
			select concat(country_code,' ',language_code)
			from
			{{languages}}
			where
			lang_id=a.lang_id
			) as language
			 FROM
			{{user}} a
			ORDER BY user_id DESC
			";	    	
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[user_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"useradd?id=$val[user_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[user_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		if (!empty($val['last_login'])){
    	    		    $last_login=date('D m,Y G:i:s',strtotime($val['last_login']));
    	    		} else $last_login='';
    	    		$feed_data['aaData'][]=array(
    	    		  $val['full_name'].$option,$val['username'],
    	    		  empty($val['user_type'])?"admin":$val['user_type'],
    	    		  empty($val['language'])?"Default English":$val['language'],
    	    		  $date."<div>$val[status]</div>",$last_login
    	    		);
    	    	}    	    	
    	    	$this->otableOutput($feed_data);    	    	
    	    }     	    
    	    $this->otableNodata();	
	    }
	    
	    public function login()
	    {
	    	if (!isset($this->data['remember'])){
	    		$this->data['remember']='';
	    	}
	    		    
	    	$stmt="SELECT * FROM
			{{user}}
			WHERE
			username =".Yii::app()->db->quoteValue($this->data['username'])."
			AND
			password ='".md5($this->data['password'])."'
			AND
			status='active'
			LIMIT 0,1
		    ";    	    	 
	    	$connection=Yii::app()->db;
	    	$rows=$connection->createCommand($stmt)->queryAll();     		    	
	    	if (is_array($rows) && count($rows)>=1){    		    		
	    		if ($this->data['remember']==1){    		    
	    		    setcookie("rst_cookie_u", $this->data['username'], time()+365*24*60*60, '/');
		            setcookie("rst_cookie_p", $this->data['password'], time()+365*24*60*60, '/');
		            setcookie("rst_remember", $this->data['remember'], time()+365*24*60*60, '/');
	    		}    		
	    		Yii::app()->request->cookies['rst_user'] = new CHttpCookie('rst_user', json_encode($rows));    		
	    		$this->code=1;
	    		$this->msg=Yii::t("default","Login Successful");
	    		
	    		$command = Yii::app()->db->createCommand();
	    		$command->update('{{user}}' , array('last_login'=>date('c')) , 
				'user_id=:user_id' , array(':user_id'=> $rows[0]['user_id'] ));
	    		
	    	} else $this->msg=Yii::t("default",'Login Failed. Either username or password are invalid');
	    }
	    
	    public function uploadImage()
	    {
	    	$path_to_upload=Yii::getPathOfAlias('webroot')."/upload/";	    		    	
		    if(!file_exists($path_to_upload)) {	
               if (!@mkdir($path_to_upload,0777)){
               	    $this->msg=Yii::t("default","Cannot create upload folder. Please create the upload folder manually on your rood directory with 777 permission.");
               	    return ;
               }		    
		    }
		    if (isset($this->data['qqfile']) && !empty($this->data['qqfile'])){
		        $input = fopen("php://input", "r");
		        $temp = tmpfile();
		        $realSize = stream_copy_to_stream($input, $temp);
		
		        $pathinfo = pathinfo($this->data['qqfile']);	  		        
		        $file_name=$pathinfo['filename'].".".$pathinfo['extension'];	
		        $path=$path_to_upload.$file_name;
		        		
		        $target = fopen($path, "w");        
		        fseek($temp, 0, SEEK_SET);
	            stream_copy_to_stream($temp, $target);
				
	            $this->code=1;
		        $this->msg=Yii::t("default","Upload Completed");
		        $this->details=array(
		           'file'=>$file_name,
		           'id'=>time()//mktime()
		        );			    
	        } else $this->msg=Yii::t("default","File is empty");
	    }
	    
	    public function sortList()
	    {
	    	$db_ext=new DbExt;
	    	//yii::app()->functions->dump($this->data);
	    	if (isset($this->data['list_data']) && isset($this->data['list_data'])){
	    		$this->data['list_data']=substr($this->data['list_data'],0,-1);
	    		$list_data=!empty($this->data['list_data'])?explode(",",$this->data['list_data']):false;	    		
	    		if($list_data!=false){	    		
	    			$x=1;	
	    			foreach ($list_data as $cat_id) {	    				
	    				$up=array('sequence'=>$x);	    				
	    				$tbl=$this->data['data'];
	    				$db_ext->updateData("{{{$tbl}}}",$up,$this->data['data_key'],$cat_id);
	    				$x++;
	    			}
	    			$this->code=1;
	    			$this->msg=Yii::t("default","Successful");
	    		} else $this->msg=Yii::t("default","List Data is empty.");
	    	} else $this->msg=Yii::t("default","Error: missing parameters");	    
	    }	
	    
	    public function saveFeatured()
	    {
	       //yii::app()->functions->dump($this->data);
	       $db_ext=new DbExt;
	       if (isset($this->data['list_data']) && isset($this->data['list_data'])){
	       	   $this->data['list_data']=substr($this->data['list_data'],0,-1);
	    		$list_data=!empty($this->data['list_data'])?explode(",",$this->data['list_data']):false;	    		
	    		if($list_data!=false){	    		
	    			$x=1;	
	    			$sq="UPDATE {{item}}
	    			     SET is_featured='0'	    			     
	    			";
	    			$db_ext->qry($sq);
	    			foreach ($list_data as $item_id) {	    				
	    				$up=array('is_featured'=>1);	 
	    				/*yii::app()->functions->dump($up);
	    				yii::app()->functions->dump($item_id);*/
	    				$db_ext->updateData("{{item}}",$up,'item_id',$item_id);
	    				$x++;
	    			}
	    		    $this->code=1;
	    			$this->msg=Yii::t("default","Successful");
	    	   } else {
	    	   	   $this->code=1;
	    		   $this->msg=Yii::t("default","Successful");
	    		   $sq="UPDATE {{item}}
	    			     SET is_featured='0'	    			     
	    			";
	    		   $db_ext->qry($sq);
	    	   }
	       } else $this->msg=Yii::t("default","Error: missing parameters");	    
	    }
	    
	    public function featuredSettings()
	    {	    	
	    	if (!isset($this->data['is_featured'])){
	    		$this->data['is_featured']="";
	    	}	    
	    	yii::app()->functions->updateOption('featured_on',$this->data['is_featured']);
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Settings saved.");
	    }
	    
	    
	    public function rptUserList()
	    {
	    	$where='';
	    	if (isset($this->data['start_date']) && isset($this->data['end_date']))	{
	    		if (!empty($this->data['start_date']) && !empty($this->data['end_date'])){
	    		$where=" WHERE date_created BETWEEN  '".$this->data['start_date']."' AND 
	    		        '".$this->data['end_date']."'
	    		 ";
	    		}
	    	}
	    	$stmt="
			SELECT * FROM
			{{client}}
			$where
			ORDER BY client_id DESC
			LIMIT 0,2000
			";
	    	
	    	$_SESSION['export_stmt']=$stmt;
	    	
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	        	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[client_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"rpt-reg-user/?user_id=$val[client_id]\" >Edit</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[client_id]\" >Delete</a>
    	    		</div>";
    	    		$date=date('m-d-Y G:i:s',strtotime($val['date_created']));
    	    		if (!empty($val['last_login'])){
    	    		    $last_login=date('D m,Y G:i:s',strtotime($val['last_login']));
    	    		} else $last_login='';
    	    		$feed_data['aaData'][]=array(    	    		  
    	    		  $val['client_id'],
    	    		  $val['fullname'].$option,
    	    		  $val['phone'],
    	    		  $val['mobile'],
    	    		  $val['email'],
    	    		  $val['delivery_address'],
    	    		  $val['location_name'],
    	    		  $val['status'],
    	    		  $date
    	    		);    	    		
    	    	}    	    	
    	    	$this->otableOutput($feed_data); 
    	    	//Yii::app()->functions->dump($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }
	    
	    function dump($data='')
	    {
	    	Yii::app()->functions->dump($data);
	    }	
	    
	    public function updateClient()
	    {	    	
	    	$params=array(
	    	  'fullname'=>$this->data['fullname'],
	    	  'phone'=>$this->data['phone'],
	    	  'mobile'=>$this->data['mobile'],
	    	  'email'=>$this->data['email'],
	    	  'delivery_address'=>$this->data['delivery_address'],
	    	  'location_name'=>$this->data['location_name'],
	    	  'status'=>$this->data['status']
	    	);	    	
	    	
	    	if (isset($this->data['password']) && !empty($this->data['password'])){
	    		$params['password']=md5($this->data['password']);
	    	}	    
	    	
	    	$db_ext=new DbExt();
	    	$db_ext->updateData("{{client}}",$params,'client_id',$this->data['user_id']);
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Successful");
	    }	
	    
	    public function rptSales()
	    {
	    	$db_ext=new DbExt();	    
	    	$and='';
	    	if (isset($this->data['start_date']) && isset($this->data['end_date']))	{
	    		if (!empty($this->data['start_date']) && !empty($this->data['end_date'])){
	    		$and=" AND date_created BETWEEN  '".$this->data['start_date']." 00:00:00' AND 
	    		        '".$this->data['end_date']." 23:59:00'
	    		 ";
	    		}
	    	}
	    	
	    	$order_status_id='';
	    	$or='';
	    	if (isset($this->data['stats_id'])){
		    	if (is_array($this->data['stats_id']) && count($this->data['stats_id'])>=1){
		    		foreach ($this->data['stats_id'] as $stats_id) {		    			
		    			$order_status_id.="'$stats_id',";
		    		}
		    		if ( !empty($order_status_id)){
		    			$order_status_id=substr($order_status_id,0,-1);
		    		}		    	
		    	}	    
	    	}
	    	
	    	if ( !empty($order_status_id)){	    		
	    		$or.= " OR stats_id IN ($order_status_id)";
	    	}	    	    	
	    	 
	    	$stmt="SELECT a.*,	    	    
	    	       (
	    	       SELECT fullname
	    	       FROM
	    	       {{client}}
	    	       WHERE
	    	       client_id=a.client_id
	    	       ) as client_name,
	    	       	    	       
				   (
					select description
					from {{order_status}}
					where stats_id = a.stats_id
				   ) as status_desc
					   
	    	       FROM
	    	       {{order}} a
	    	       WHERE
	    	       status=''
	    	       $and	    	
	    	       $or       	    	       
	    	       ORDER BY order_id DESC
	    	       LIMIT 0,1000	    	       	    	      
	    	";	    	
	    	/*dump($this->data);	    	
	    	dump($stmt);	    	*/
	    	$_SESSION['export_stmt']=$stmt;
	    	
	    	yii::app()->functions->data="list";
	    	$item_list=Yii::app()->functions->getFoodItemList();	    	
	    	if ($res=$db_ext->rst($stmt)){	    		
	    		foreach ($res as $val) {	    			    			
	    			$item='';
	    			$json_order_details=!empty($val['json_order_details'])?json_decode($val['json_order_details']):false;
	    			if ($json_order_details!=false){	    				
	    				if (is_object($json_order_details)){	    				
	    				    foreach ($json_order_details->item as $val_item) {	    				    	
	    				    	$item.=$item_list[$val_item->item_id].", ";
	    				    }	
	    				    $item=substr($item,0,-2);
	    				}	    			
	    			}	    		
	    			
	    			$action="<a data-id=\"".$val['order_id']."\" href=\"javascript:;\" rel=\"".$val['stats_id']."\" class=\"edit_status_order\">".Yii::t("default","edit")."</a><br>";
    
    $action.="<a data-id=\"".$val['order_id']."\" href=\"javascript:;\" class=\"view_receipt\">".Yii::t('default',"View")."</a>";
	    			
	    			$date=date('m-d-Y G:i:s',strtotime($val['date_created']));    	    		
    	    		$feed_data['aaData'][]=array(    	    		  
    	    		  $val['order_id'],
    	    		  $val['client_name'],
    	    		  $item,
    	    		  $val['trans_type'],
    	    		  $val['payment_type'],
    	    		  $val['total'],
    	    		  $val['tax'],
    	    		  $val['total_w_tax'],
    	    		  //$val['status'],
    	    		  $val['status_desc'],
    	    		  $date,
    	    		  $action
    	    		  //"<a target=\"_blank\" href=\"".Yii::app()->request->baseUrl."/admin/view-order/order_id/".$val['order_id']."\" >View</a>",
    	    		);    	    		
	    		}
	    		$this->otableOutput($feed_data); 
	    	}
	    	$this->otableNodata();	
	    }	
	    
	    public function rptSalesByItem()
	    {
	    	$db_ext=new DbExt();	    
	    	$and='';
	    	if (isset($this->data['start_date']) && isset($this->data['end_date']))	{
	    		if (!empty($this->data['start_date']) && !empty($this->data['end_date'])){
	    		$and=" AND  date_created BETWEEN  '".$this->data['start_date']." 00:00:00' AND 
	    		        '".$this->data['end_date']." 23:59:00'
	    		 ";
	    		}
	    	}
	    	
	    	$order_status_id='';
	    	$or='';
	    	if (isset($this->data['stats_id'])){
		    	if (is_array($this->data['stats_id']) && count($this->data['stats_id'])>=1){
		    		foreach ($this->data['stats_id'] as $stats_id) {		    			
		    			$order_status_id.="'$stats_id',";
		    		}
		    		if ( !empty($order_status_id)){
		    			$order_status_id=substr($order_status_id,0,-1);
		    		}		    	
		    	}	    
	    	}
	    	
	    	if ( !empty($order_status_id)){	    		
	    		$or.= " OR stats_id IN ($order_status_id)";
	    	}	    	    	
	    	
	    	$stmt="SELECT a.*,b.date_created,b.stats_id,
	    	     (
	    	     SELECT size_name
	    	     FROM
	    	     {{size}} 	
	    	     WHERE
	    	     size_id=a.item_size
	    	     ) as size_name,
	    	     	    	     
                 (
    	         select description
    	         from {{order_status}}
    	         where stats_id = b.stats_id
    	         ) as status_desc
	    	           
	    	      FROM
	    	      {{order_details}} a,
	    	      {{order}} b
	    	      WHERE
	    	      a.order_id=b.order_id
	    	      AND
	    	      status=''
	    	      $and
	    	      $or
	    	      ORDER BY id DESC
	    	      LIMIT 0,1000
	    	";	    		    
	    	//$this->dump($stmt);    	
	    	$_SESSION['export_stmt']=$stmt;
	    	
	    	if ($res=$db_ext->rst($stmt)){	    			    	
	    		foreach ($res as $val) {	    			
	    			$total=$val['qty']*$val['item_price'];
	    			if (is_numeric($total)){
	    				$total=number_format($total,2);
	    			}	    		
	    			$date=date('D M d Y G:i:s',strtotime($val['date_created']));    	    		
    	    		$feed_data['aaData'][]=array(    	    		  
    	    		  $val['order_id'],
    	    		  $val['item_name'],
    	    		  $val['size_name'],
    	    		  number_format($val['item_price'],2),
    	    		  $val['qty'],
    	    		  $total,
    	    		  $val['status_desc'],
    	    		  $date
    	    		);    	    		
	    		}
	    		$this->otableOutput($feed_data); 
	    	}
	    	$this->otableNodata();	
	    }	
	    
	    public function rptSalesSummary()
	    {
	    	$db_ext=new DbExt();	 
	    	$and='';
	    	if (isset($this->data['start_date']) && isset($this->data['end_date']))	{
	    		if (!empty($this->data['start_date']) && !empty($this->data['end_date'])){
	    		$and=" AND  date_created BETWEEN  '".$this->data['start_date']." 00:00:00' AND 
	    		        '".$this->data['end_date']." 23:59:00'
	    		 ";
	    		}
	    	}   
	    	
	    	$order_status_id='';
	    	$or='';
	    	if (isset($this->data['stats_id'])){
		    	if (is_array($this->data['stats_id']) && count($this->data['stats_id'])>=1){
		    		foreach ($this->data['stats_id'] as $stats_id) {		    			
		    			$order_status_id.="'$stats_id',";
		    		}
		    		if ( !empty($order_status_id)){
		    			$order_status_id=substr($order_status_id,0,-1);
		    		}		    	
		    	}	    
	    	}
	    	
	    	if ( !empty($order_status_id)){	    		
	    		$or.= " OR stats_id IN ($order_status_id)";
	    	}	    	    	
	    	
	    	$stmt="SELECT SUM(a.qty) as total_qty,
	    	a.item_id, a.item_name,a.item_price,a.item_size,
	    	b.date_created,
	    	(
	    	SELECT size_name
	    	FROM
	    	{{size}}
	    	WHERE
	    	size_id=a.item_size
	    	) as size_name
	    	
	    	FROM
	    	{{order_details}} a,
	    	{{order}} b
	    	WHERE
	    	a.order_id=b.order_id
	    	AND
	    	status=''
	    	$and
	    	$or
	    	GROUP BY item_id,item_size
	    	LIMIT 0,2000
	    	";
	    	//$this->dump($stmt);    	    	
	    	$_SESSION['export_stmt']=$stmt;
	    		
	    	if ($res=$db_ext->rst($stmt)){	    		
	    		foreach ($res as $val) {	
	    			$total_amt='';
	    			if (is_numeric($val['item_price']) && is_numeric($val['total_qty'])){
	    				$total_amt=number_format($val['item_price']*$val['total_qty'],2);
	    			}	    			    			
		    		$feed_data['aaData'][]=array(
		    		  $val['item_name'],
		    		  $val['item_id'],
		    		  $val['size_name'],
		    		  number_format($val['item_price'],2),
		    		  $val['total_qty'],
		    		  $total_amt
		    		);
	    		}
	    		$this->otableOutput($feed_data); 
	    	}
	    	$this->otableNodata();	
	    }
	    
	    public function socialSettings()
	    {	    	
	    	if (empty($this->data['fb_app_id'])){
	    		$this->data['fb_app_id']='';
	    	}	    
	    	if (empty($this->data['fb_app_secret'])){
	    		$this->data['fb_app_secret']='';
	    	}	    
	    	if (empty($this->data['fb_page'])){
	    		$this->data['fb_page']='';
	    	}	    
	    	if (empty($this->data['twitter_page'])){
	    		$this->data['twitter_page']='';
	    	}	    
	    	if (empty($this->data['google_page'])){
	    		$this->data['google_page']='';
	    	}	    
	    	if (empty($this->data['social_flag'])){
	    		$this->data['social_flag']='';
	    	}	    
	    	if (empty($this->data['fb_flag'])){
	    		$this->data['fb_flag']='';
	    	}	    	    	
	    	yii::app()->functions->updateOption('fb_app_id',$this->data['fb_app_id']);
	    	yii::app()->functions->updateOption('fb_app_secret',$this->data['fb_app_secret']);
	    	yii::app()->functions->updateOption('fb_page',$this->data['fb_page']);
	    	yii::app()->functions->updateOption('twitter_page',$this->data['twitter_page']);
	    	yii::app()->functions->updateOption('google_page',$this->data['google_page']);
	    	yii::app()->functions->updateOption('social_flag',$this->data['social_flag']);
	    	yii::app()->functions->updateOption('fb_flag',$this->data['fb_flag']);
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Successful");
	    }	
	    
	    public function contactSettings()
	    {	    	
	    	if (!isset($this->data['contact_content'])){
	        	$this->data['contact_content']='';
	        }
	        if (!isset($this->data['contact_map'])){
	        	$this->data['contact_map']='';
	        }
	        if (!isset($this->data['map_latitude'])){
	        	$this->data['map_latitude']='';
	        }
	        if (!isset($this->data['map_longitude'])){
	        	$this->data['map_longitude']='';
	        }
	        if (!isset($this->data['contact_email_receiver'])){
	        	$this->data['contact_email_receiver']='';
	        }
	        if (!isset($this->data['contact_field'])){
	        	$this->data['contact_field']='';
	        }
	    
	        if (is_array($this->data['contact_field']) && count($this->data['contact_field'])>=1){
	        yii::app()->functions->updateOption('contact_content',$this->data['contact_content']);
	        yii::app()->functions->updateOption('contact_map',$this->data['contact_map']);
	        yii::app()->functions->updateOption('map_latitude',$this->data['map_latitude']);
	        yii::app()->functions->updateOption('map_longitude',$this->data['map_longitude']);
	        yii::app()->functions->updateOption('contact_email_receiver',$this->data['contact_email_receiver']);
	        yii::app()->functions->updateOption('contact_field',json_encode($this->data['contact_field']));
	        $this->code=1;
	    	$this->msg=Yii::t("default","Settings saved.");
	        } else $this->msg=Yii::t("default","Contact field must have 1 or more fields");
	    }	
	    
	    public function receiptSettings()
	    {	    
	    	$validator=new Validator;
	    	$req=array(
	    	  'receipt_from_email'=>Yii::t("default","Sender email is required"),
	    	  'receipt_subject'=>Yii::t("default","Subject is required"),
	    	  'receipt_content'=>Yii::t("default","Content is required"),
	    	);
	    	$validator->required($req,$this->data);
	    	if ($validator->validate()){
	    		yii::app()->functions->updateOption('receipt_from_email',$this->data['receipt_from_email']);
	    		yii::app()->functions->updateOption('receipt_subject',$this->data['receipt_subject']);
	    		yii::app()->functions->updateOption('receipt_content',$this->data['receipt_content']);
	    		$this->code=1;
	    	    $this->msg=Yii::t("default","Settings saved.");
	    	} else $this->msg=$validator->getErrorAsHTML();
	    }
	    
	    public function export()
	    {	    		    	
	    	$db_ext=new DbExt();	
	    	if (!empty($_SESSION['export_stmt'])){
	    		$stmt= $_SESSION['export_stmt'];
	    		$pos=strpos($stmt,"LIMIT");
	    		$stmt=substr($stmt,0,$pos);	    		
		    	switch ($this->data['rpt']) {
		    		case "sales-report":
		    			yii::app()->functions->data="list";
				    	$item_list=Yii::app()->functions->getFoodItemList();	    	
				    	if ($res=$db_ext->rst($stmt)){	
				    		$csvdata=array();
    	    	            $datas=array();    		
				    		foreach ($res as $val) {	    			    			
				    			$item='';
				    			$json_order_details=!empty($val['json_order_details'])?json_decode($val['json_order_details']):false;
				    			if ($json_order_details!=false){	    				
				    				if (is_object($json_order_details)){	    				
				    				    foreach ($json_order_details->item as $val_item) {	    				    	
				    				    	$item.=$item_list[$val_item->item_id].", ";
				    				    }	
				    				    $item=substr($item,0,-2);
				    				}	    			
				    			}	    		
				    			$date=date('m-d-Y G:i:s',strtotime($val['date_created']));    	    		
			    	    		$latestdata[]=array(    	    		  
			    	    		  $val['order_id'],
			    	    		  $val['client_name'],
			    	    		  $item,
			    	    		  $val['trans_type'],
			    	    		  $val['payment_type'],
			    	    		  $val['total'],
			    	    		  $val['tax'],
			    	    		  $val['total_w_tax'],
			    	    		  $val['status_desc'],
			    	    		  $date
			    	    		);    	    		
				    		}				    		 	
				    		unset($data);
    	                    $data=$latestdata;    	                    
    	                    
				    	}				    	
				    	if (is_array($data) && count($data)>=1){
			    	    	$csvdata=array();
			    	    	$datas=array();
			    	        foreach ($data as $val) {    	        	
			    	            foreach ($val as $key => $vals) {
			    	            	$datas[]=$vals;
			    	            }
			    	            $csvdata[]=$datas;
			    	            unset($datas);
			    	        }	
			    	    }    	    
			    	    $header=array(
			    	    Yii::t("default","Refference #"),
			    	    Yii::t("default","Client Name"),
			    	    Yii::t("default","Item"),
			    	    Yii::t("default","Trans Type"),
			    	    Yii::t("default","Payment Type"),
			    	    Yii::t("default","Total"),
			    	    Yii::t("default","Tax"),
			    	    Yii::t("default","Total W/Tax"),
			    	    Yii::t("default","Status"),
			    	    Yii::t("default","Date"));
			    	    $filename = $this->data['rpt'].'-'. date('c') .'.csv';    	    
				    	$excel  = new ExcelFormat($filename);
				    	$excel->addHeaders($header);
                        $excel->setData($csvdata);	  
                        $excel->prepareExcel();	 
                        exit;
		    			break;
		    	
		    		case "sales-report-by-item":				    		    
		    		    if ($res=$db_ext->rst($stmt)){	    			    	
				    		foreach ($res as $val) {	    			
				    			$total=$val['qty']*$val['item_price'];
				    			if (is_numeric($total)){
				    				$total=number_format($total,2);
				    			}	    		
				    			$date=date('m-d-Y G:i:s',strtotime($val['date_created']));    	    		
			    	    		$latestdata[]=array(    	    		  
			    	    		  $val['order_id'],
			    	    		  $val['item_name'],
			    	    		  $val['size_name'],
			    	    		  number_format($val['item_price'],2),
			    	    		  $val['qty'],
			    	    		  $total,
			    	    		  $val['status_desc'],
			    	    		  $date
			    	    		);    	    		
				    		}	
				    		unset($data);
    	                    $data=$latestdata;			    
				    	}				    	
				    	$header=array(
				    	Yii::t("default","Refference #"),
				    	Yii::t("default","Item"),
				    	Yii::t("default","Size"),
				    	Yii::t("default","Price"),
				    	Yii::t("default","Qty"),
				    	Yii::t("default","Total"),
				    	Yii::t("default","Status"),
				    	Yii::t("default","Date")
				    	);			    	  
			    	    $filename = $this->data['rpt'].'-'. date('c') .'.csv';    	    
				    	$excel  = new ExcelFormat($filename);
				    	$excel->addHeaders($header);
                        $excel->setData($data);	  
                        $excel->prepareExcel();	
                        exit; 
		    		    break;
		    		    
		    		case "sales-summary":    				    		    
		    		    if ($res=$db_ext->rst($stmt)){	    		
			    		foreach ($res as $val) {	
			    			$total_amt='';
			    			if (is_numeric($val['item_price']) && is_numeric($val['total_qty'])){
			    				$total_amt=number_format($val['item_price']*$val['total_qty'],2);
				    			}	    			    			
					    		$data[]=array(
					    		  $val['item_name'],
					    		  $val['item_id'],
					    		  $val['size_name'],
					    		  number_format($val['item_price'],2),
					    		  $val['total_qty'],
					    		  $total_amt
					    		);
				    		}			    		
			    	    }			    	    			    	   
			    	    $header=array(
			    	    Yii::t("default","Item"),
			    	    Yii::t("default","Item ID"),
			    	    Yii::t("default","Size"),
			    	    Yii::t("default","Item Price"),
			    	    Yii::t("default","Total Qty"),
			    	    Yii::t("default","Total Amount")
			    	    );			    	  
			    	    $filename = $this->data['rpt'].'-'. date('c') .'.csv';    	    
				    	$excel  = new ExcelFormat($filename);
				    	$excel->addHeaders($header);
                        $excel->setData($data);	  
                        $excel->prepareExcel();	
                        exit; 
		    		    break;
		    		    
		    		case "reg-user":    
		    		    if ($res=$db_ext->rst($stmt)){	    		
				    		foreach ($res as $val) {						        
				    			$date=date('m-d-Y G:i:s',strtotime($val['date_created']));
			    	    		if (!empty($val['last_login'])){
			    	    		    $last_login=date('D m,Y G:i:s',strtotime($val['last_login']));
			    	    		} else $last_login='';
			    	    		$data[]=array(    	    		  
			    	    		  $val['fullname'],
			    	    		  $val['phone'],
			    	    		  $val['mobile'],
			    	    		  $val['email'],
			    	    		  $val['delivery_address'],
			    	    		  $val['location_name'],
			    	    		  $val['status'],
			    	    		  $date
			    	    		);    	    				    	    				
				    	    }			 
		    		    }			    	    
			    	    $header=array(
			    	    Yii::t("default","Full Name"),
			    	    Yii::t("default","Phone"),
			    	    Yii::t("default","Mobile"),
			    	    Yii::t("default","Email"),
			    	    Yii::t("default","Delivery address"),
			    	    Yii::t("default","Location name"),
			    	    Yii::t("default","Status"),
			    	    Yii::t("default","Date"));
			    	    $filename = $this->data['rpt'].'-'. date('c') .'.csv';    	    
				    	$excel  = new ExcelFormat($filename);
				    	$excel->addHeaders($header);
                        $excel->setData($data);	  
                        $excel->prepareExcel();	
                        exit; 		    		    
		    		    break;
		    		    
		    		case "voucher_details":
		    			if ($res=$db_ext->rst($stmt)){	    		
				    		foreach ($res as $val) {						        				    			
				    			$date=!empty($val['date_used'])?date('m-d-Y G:i:s',strtotime($val['date_used'])):"";
			    	    		$data[]=array(    	    		  
			    	    		  $val['voucher_code'],
			    	    		  $val['status'],
			    	    		  $date,
			    	    		  $val['fullname']
			    	    		);    	    				    	    				
				    	    }						    	    	
		    		    }		
		    		    $header=array(
			    	    Yii::t("default","Voucher Code"),
			    	    Yii::t("default","Status"),
			    	    Yii::t("default","Date Used"),
			    	    Yii::t("default","Use By")
			    	    );
			    	    $filename = $this->data['rpt'].'-'. date('c') .'.csv';    	    
				    	$excel  = new ExcelFormat($filename);
				    	$excel->addHeaders($header);
                        $excel->setData($data);	  
                        $excel->prepareExcel();	
                        exit; 		    		    	    	    
		    			break;
		    		default:
		    			break;
		    	}
	    	} else echo Yii::t("default","Error: Something went wrong. please try again.");
	    }	
	    
	    public function chartByItem()
	    {	    		    
	    	$data='';
	    	$db_ext=new DbExt();		    	
	    	$date_now=date('Y-m-d 23:00:59');
	    	$start_date=date('Y-m-d 00:00:00',strtotime($date_now . "-30 days"));
	    	$stmt="SELECT a.item_name,a.item_price,	    	       
	    	       SUM(qty) as total,
	    	       b.date_created
	    	       FROM
	    	       {{order_details}} a
	    	       left join {{order}} b
	    	       ON
	    	       a.order_id=b.order_id
	    	       WHERE
	    	       b.date_created BETWEEN '$start_date' AND '$date_now'
	    	       GROUP BY item_id
	    	       ORDER BY item_name ASC
	    	";	    	
	    	if ($res=$db_ext->rst($stmt)){	    		
	    		foreach ($res as $val) {	    			
	    			$data[$val['item_name']]=$val['item_price']*$val['total'];
	    		}
	    	}	    	    	
	    	echo Yii::app()->functions->formatAsChart($data);
	    	die();
	    }
	    
	    public function chartTotalSales()
	    {
	    	$data='';
	    	$db_ext=new DbExt();    	
	    	$date_now=date('Y-m-d 23:00:59');
	    	$start_date=date('Y-m-d 00:00:00',strtotime($date_now . "-30 days"));
	    	$stmt="SELECT DATE_FORMAT(date_created, '%M-%D') as date_created_format,SUM(total) as total
	    	FROM
	    	{{order}}
	    	WHERE
	    	date_created BETWEEN '$start_date' AND '$date_now'
	    	GROUP BY DATE_FORMAT(date_created, '%M-%D')
	    	ORDER BY date_created ASC
	    	";
	    	if ($res=$db_ext->rst($stmt)){
	    		foreach ($res as $val) {
	    			$data[$val['date_created_format']]=$val['total'];
	    		}
	    	}	    
	    	echo Yii::app()->functions->formatAsChart($data);
	    	die();
	    }		   
	    
	    public function languageTranslateList()
	    {	    	
	    	$update_msg=Yii::t("default","Update Translation");
	    	$stmt="
			SELECT * FROM
			{{languages}}
			ORDER BY country_code ASC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	 
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[lang_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"translation-add?id=$val[lang_id]&msg=$update_msg\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[lang_id]\" >Delete</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));    	    		    	    		
    	    		$feed_data['aaData'][]=array(
    	    		  $chk,
    	    		  Yii::app()->functions->getFlagByCode($val['country_code']).$val['country_code'].$option,
    	    		  $val['language_code'],$val['status'],$date
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();
	    }	
	    
	    public function addTranslation()
	    {	       
	       $validator=new Validator;
	       $req=array(
	         'country_code'=>Yii::t("default","Country is required"),
	         'language_code'=>Yii::t("default","Language code is required"),
	         'status'=>Yii::t("default","Status code is required")
	       );
	       $validator->required($req,$this->data);
	       if ($validator->validate()){
	       	   $params=array(
	       	     'country_code'=>$this->data['country_code'],
	       	     'language_code'=>$this->data['language_code'],
	       	     'date_created'=>date('c'),
	       	     'ip_address'=>$_SERVER['REMOTE_ADDR'],
	       	     'status'=>$this->data['status']
	       	   );	       	   
	       	   $db_ext=new DbExt(); 
	       	   if ($db_ext->insertData("{{languages}}",$params)){
	       	   	   $this->code=1;
	       	   	   $this->msg=Yii::t("defaul","You can now start translating");	       	   	   	       	   	   	              
	               $item_id=Yii::app()->db->getLastInsertID();
	               $this->details=$item_id;	       	   	  
	       	   } else $this->msg=Yii::t("default","Error: cannot insert records");    
	       } else $this->msg=$validator->getErrorAsHTML();	    
	    }
	    
	    public function saveTranslation()
	    {	    		    	
	    	$db_ext=new DbExt(); 
	    	if (isset($this->data['id'])){
	    		$params['source_text']=json_encode($this->data['source_text']);	
	    		$params['last_updated']=date('c');
	    		//dump($params);
	    		if ($db_ext->updateData("{{languages}}",$params,'lang_id',$this->data['id'])){
	    			$this->code=1;
	    			$this->msg=Yii::t("default","Translation updated.");
	    		} else $this->msg=Yii::t("default","ERROR: cannot update.");
	    	} else $this->msg=Yii::t("default","ID not found.");
	    }
	    
	    public function assignLanguage()
	    {
	    	$db_ext=new DbExt(); 	    	
	    	$lang_ids='';
	    	$stmt="UPDATE {{languages}}
	    	       SET is_assign='2'
	    	       ";	
	    	$db_ext->qry($stmt);
	    	if (is_array($this->data['lang_id']) && count($this->data['lang_id'])>=1){	    		
	    		foreach ($this->data['lang_id'] as $lang_id) {	    			
	    			$lang_ids.="'$lang_id',";
	    		}
	    		$lang_ids=substr($lang_ids,0,-1);
	    		$stmt="UPDATE {{languages}}
	    		SET is_assign='1'
	    		WHERE
	    		lang_id IN ($lang_ids)
	    		";	    		
	    		$db_ext->qry($stmt);
	    	} 
	    	
	    	if (!isset($this->data['lang_default'])){
	    		$this->data['lang_default']='';
	    	}	    	    	
	    	if (!isset($this->data['show_language_siderbar'])){
	    		$this->data['show_language_siderbar']='';
	    	}	    
	    	Yii::app()->functions->updateOption("lang_default",$this->data['lang_default']);
	    	Yii::app()->functions->updateOption("show_language_siderbar",$this->data['show_language_siderbar']);
	    	
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Settings saved.");
	    }	
	    
	    public function currencyList()
	    {
	    	$stmt="
			SELECT * FROM
			{{currency}}
			ORDER BY currency_code ASC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[currency_code]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"currency-settings?id=$val[currency_code]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[currency_code]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['currency_code'].$option,
    	    		  $val['currency_symbol'],
    	    		  $date
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }
	    
	    public function addCurrency()
	    {
	    	$params=array(
			  'currency_code'=>strtoupper(addslashes($this->data['currency_code'])),			  
			  'currency_symbol'=>addslashes($this->data['currency_symbol']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);				
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && !empty($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');								
				$res = $command->update('{{currency}}' , $params , 
				'currency_code=:currency_code' , array(':currency_code'=>addslashes($this->data['id'])) );
				if ($res){					
					$this->code=1;
	                $this->msg=Yii::t("default",'Currency updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{currency}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Currency added.');  
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
	    }
	    
	    public function changeOrderStatus()
	    {	    	
	    	$db_ext=new DbExt;
	    	$params=array(
	    	  'stats_id'=>$this->data['order_status'],
	    	  'date_modified'=>date('c'),
	    	  'viewed'=>1
	    	);	    	
	    	
	    	if (isset($this->data['pre_approved'])){
	    		$params['pre_approved']=$this->data['pre_approved'];
	    	}
	    	if (isset($this->data['pre_approved_time'])){
	    		$params['pre_approved_time']=$this->data['pre_approved_time'];
	    	}
	    	
	    	if ($db_ext->updateData("{{order}}",$params,'order_id',$this->data['order_id'])){
	    		$this->code=1;
	    		$this->msg="Successful";	    			    			           	    		
	    	} else $this->msg="ERROR: cannot change status.";
	    }
	    
	    public function recentOrder()
	    {
	    	if ($res=Yii::app()->functions->newOrderList("pending")){	    		
	    		foreach ($res as $val) {
	    			
	    			$action="<a data-id=\"".$val['order_id']."\" href=\"javascript:;\" rel=\"".$val['stats_id']."\" class=\"edit_status_order\"><i class=\"fa fa-pencil-square-o\"></i>".Yii::t("default","Edit")."</a>";
    
    $action.="<a data-id=\"".$val['order_id']."\" href=\"javascript:;\" class=\"view_receipt\"><i class=\"fa fa-file-text-o\"></i> ".Yii::t('default',"View")."</a>";
            
                   if ( $val['viewed']==0 || $val['viewed']==""){
                   	   $view=$val['order_id']."<span class=\"newtag\"><i class=\"fa fa-bell-o\"></i> ".Yii::t("default","new")."</span>";
                   } else $view=$val['order_id'];
                   
	    			$feed_data['aaData'][]=array(
	    			   $view,
	    			   $val['client_name'],
	    			   //$val['trans_type'],
	    			   Yii::t("default",ucwords($val['trans_type'])),
	    			   Yii::t("default",$val['payment_type']),
	    			   $val['total'],
	    			   $val['tax'],
	    			   $val['total_w_tax'],
	    			   date('F d G:i:s',strtotime($val['date_created'])),
	    			   //$val['stats_id'],
	    			   $val['status_desc'],
	    			   $action
	    			);	    			
	    		}
	    		$this->otableOutput($feed_data);
	    	}	    
	    	$this->otableNodata();	
	    }	
	    
	    public function orderStatusList()
	    {
	    	$stmt="
			SELECT * FROM
			{{order_status}}
			ORDER BY stats_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[stats_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"order-stats-settings?id=$val[stats_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[stats_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";    	    		
    	    		$feed_data['aaData'][]=array(
    	    		  $val['stats_id'].$option,$val['description']
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
	    }
	    
	    public function orderStatusAdd()
	    {	    	
	        $params=array(			   
			  'description'=>addslashes($this->data['status'])			  
			);						
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['stats_id']) && is_numeric($this->data['stats_id'])){
				$res = $command->update('{{order_status}}' , $params , 
				'stats_id=:stats_id' , array(':stats_id'=>addslashes($this->data['stats_id'])) );
				if ($res){					
					$this->code=1;
	                $this->msg=Yii::t("default",'Status updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{order_status}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Status added.');  
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}
	    }	     
	    
	    public function setDefaultOrderStatus()
	    {	    	
	    	if ( is_numeric($this->data['stats_id'])){
		    	Yii::app()->functions->updateOption("stats_id",$this->data['stats_id']);
		    	$this->code=1;
		    	$this->msg=Yii::t("default","Settings saved.");
	    	} else $this->msg="Status is required.";
	    }	
	    
	    public function getNewOrder()
	    {
	    	$list='';
	    	if ($res=Yii::app()->functions->newOrderList(1)){	    		
	    		/*foreach ($res as $val) {	    			
	    			$list[]=array(
	    			  'order_id'=>$val['order_id'],
	    			  'client_name'=>$val['client_name'],
	    			  'trans_type'=>$val['trans_type'],
	    			  'payment_type'=>$val['payment_type']
	    			);
	    		}*/
	    		$this->code=1;
	    		$this->msg=count($res);
	    		$this->details=$list;
	    	} else $this->msg="No results.";	    
	    }	
	    
	    public function getSmsForms()
	    {	    	
	    	$sms_gateway_id='';$sender_id='';$api_username='';$api_password='';
			if ( $sms=Yii::app()->functions->getOption("sms_gateway")){	
				$sms=json_decode($sms);	
				$sms_gateway_id=$sms->sms_gateway_id;
				$sender_id=$sms->sender_id;
				$api_username=$sms->api_username;
				$api_password=$sms->api_password;
											
				if ( $sms_gateway_id != $this->data['gateway_id']){
					$sms_gateway_id='';$sender_id='';$api_username='';$api_password='';
				}			
			}		
	    	ob_start();
	    	if ( $this->data['gateway_id']=="twilio"){
	    		?>
				<div class="input_block">
				<label>Sender ID</label>
				<?php echo CHtml::textField('sender_id',$sender_id)?>
				</div>
				
				<div class="input_block">
				<label>Account SID</label>
				<?php echo CHtml::textField('api_username',$api_username)?>
				</div>
				
				<div class="input_block">
				<label>AUTH Token</label>
				<?php echo CHtml::textField('api_password',$api_password)?>
				</div>
	    		<?php
	    	} else {	    		
	    		?>
				<div class="input_block">
				<label>Sender ID</label>
				<?php echo CHtml::textField('sender_id',$sender_id)?>
				</div>
				
				<div class="input_block">
				<label>API Username</label>
				<?php echo CHtml::textField('api_username',$api_username)?>
				</div>
				
				<div class="input_block">
				<label>API Password</label>
				<?php echo CHtml::textField('api_password',$api_password)?>
				</div>
	    		<?php
	    	}	    
	    	$form = ob_get_contents();
            ob_end_clean();            
            $this->code=1;
            $this->msg=$form;
	    }	
	    
	    public function smsSettings()
	    {	    	
	        $validator=new Validator;
	        if ($this->data['sms_gateway_id']=="twilio"){
		        $req=array(
		          'sms_gateway_id'=>"SMS Gateway is required",
		          'sender_id'=>"Sender is required",
		          'api_username'=>"Account SID required",	          
		          'api_password'=>"AUTH Token is required"
		        );
	        } else {
	        	$req=array(
		          'sms_gateway_id'=>"SMS Gateway is required",
		          'sender_id'=>"Sender is required",
		          'api_username'=>"API username required",	          
		          'api_password'=>"API password is required"
		        );
	        }	    
	        $validator->required($req,$this->data);
	        if ($validator->validate()){
	        	$params=array(
	        	  'sms_gateway_id'=>$this->data['sms_gateway_id'],
	        	  'sender_id'=>$this->data['sender_id'],
	        	  'api_username'=>$this->data['api_username'],
	        	  'api_password'=>$this->data['api_password']
	        	);	        
	       	    $sms_details=json_encode($params);
	       	    Yii::app()->functions->updateOption("sms_gateway",$sms_details);
	       	    $this->code=1;
	       	    $this->msg=Yii::t("default","Settings saved.");
	       	    
	       	    
	       	    if (!isset($this->data['notify_mobile'])){
	       	    	$this->data['notify_mobile']="";
	       	    }	        
	       	    if (!isset($this->data['sms_notification_msg'])){
	       	    	$this->data['sms_notification_msg']="";
	       	    }	        
	       	    
	       	    Yii::app()->functions->updateOption("notify_mobile",$this->data['notify_mobile']);
	       	    Yii::app()->functions->updateOption("sms_notification_msg",$this->data['sms_notification_msg']);
	       	    
	        } else $this->msg=$validator->getErrorAsHTML();
	    }	
	    
	     public function smsLogs()
		{
			$stmt="
			SELECT * FROM
			{{sms_logs}}
			ORDER BY id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {       	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">    	    		
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[id]\" >Delete</a>
    	    		</div>";
    	    		$date=date('D M d,Y G:i:s',strtotime($val['date_created']));    	    		    	    		
    	    		$feed_data['aaData'][]=array(
    	    		  $val['id'],
    	    		  $val['provider'].$option,$val['sms_message'],
    	    		  $val['mobile'],
    	    		  $val['response'],
    	    		  $date
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();
		}
		
		public function smtpSaveSettings()
		{			
			$validator=new Validator;
			$req=array(
			  'email_engine'=>Yii::t("default","Email Type is required")			  
			);
			
			if (isset($this->data['email_engine'])){
				if ($this->data['email_engine']==2){
					$req=array(
					  'smtp_host'=>"SMSTP HOST is required",
					  'sme_smtp_port'=>"SMTP PORT is required",
					  'sme_smtp_encryption'=>"SMTP Encryption is required",
					  'sme_smtp_authentication'=>"SMTP Authentication is required"					  
					);
				}			
			}		
			
			$validator->required($req,$this->data);
			
			if ($validator->validate()){
				if (!isset($this->data['smtp_host'])){
					$this->data['smtp_host']='';
				}
				if (!isset($this->data['sme_smtp_port'])){
					$this->data['sme_smtp_port']='';
				}
				if (!isset($this->data['sme_smtp_encryption'])){
					$this->data['sme_smtp_encryption']='';
				}
				if (!isset($this->data['sme_smtp_authentication'])){
					$this->data['sme_smtp_authentication']='';
				}
				if (!isset($this->data['sme_smtp_authentication'])){
					$this->data['sme_smtp_authentication']='';
				}
				if (!isset($this->data['sme_smtp_password'])){
					$this->data['sme_smtp_password']='';
				}
				
				Yii::app()->functions->updateOption("email_engine",$this->data['email_engine']);
				Yii::app()->functions->updateOption("smtp_host",$this->data['smtp_host']);
				Yii::app()->functions->updateOption("sme_smtp_port",$this->data['sme_smtp_port']);
				Yii::app()->functions->updateOption("sme_smtp_encryption",$this->data['sme_smtp_encryption']);
				Yii::app()->functions->updateOption("sme_smtp_authentication",$this->data['sme_smtp_authentication']);
				Yii::app()->functions->updateOption("sme_smtp_username",$this->data['sme_smtp_username']);
				Yii::app()->functions->updateOption("sme_smtp_password",$this->data['sme_smtp_password']);				
				
				$this->code=1;
				$this->msg=Yii::t("default","Settings saved.");
			} else $this->msg=$validator->getErrorAsHTML();
		}	
		
		public function sendEmailTest()
		{			
			if (isset($this->data['email_test'])){
				$email=$this->data['email_test'];
				$subject="Test Email";
				$content="This is the body of test email.";				
				$email_engine=yii::app()->functions->getOption('email_engine');
				$from=yii::app()->functions->getOption('receipt_from_email');				
				if (empty($from)){
			        $from='no-reply@'.$_SERVER['HTTP_HOST'];
		        }				
				if ( $email_engine == 2){				
					if (Yii::app()->functions->sendEmailSMTP($email,$from,$subject,$content) ){				
						$this->code=1;
						$this->msg="Whoaa sending of email is working. using SMTP";
				    } else $this->msg="Failed Sending email. using SMTP";
				} else {				
				   if (Yii::app()->functions->sendEmail($email,$from,$subject,$content) ){		
				   	  $this->code=1;
				   	  $this->msg="Whoaa sending of email is working. PHP MAIL FUNCTIONS";
				   } else  $this->msg="Failed Sending email. using PHP MAIL FUNCTIONS";
				}
			} else $this->msg="Email address is required";
		}
		
		public function saveAdsTextImage()
		{			
			if (!isset($this->data['add_text'])){
				$this->data['add_text']='';
			} 			
			if (!isset($this->data['promo_text_postion'])){
				$this->data['promo_text_postion']=2;
			} 
			Yii::app()->functions->updateOption("add_text",json_encode($this->data['add_text']));
			Yii::app()->functions->updateOption("promo_text_postion",$this->data['promo_text_postion']);
			$this->code=1;
			$this->msg="Settings saved.";
		}	
		
		public function layoutMenu()
		{			
			if (!isset($this->data['layout_menu'])){
				$this->data['layout_menu']='';
			}
			if ( !isset($this->data['pre_collapse'])){
				$this->data['pre_collapse']='';
			}
		
			Yii::app()->functions->updateOption("layout_menu",$this->data['layout_menu']);
			Yii::app()->functions->updateOption("pre_collapse",$this->data['pre_collapse']);
			$this->code=1;
			$this->msg="Settings saved.";
		}	
		
		public function manageTheme()
		{
			if (!isset($this->data['layout_themes'])){
				$this->data['layout_themes']='';
			}
			if (!isset($this->data['custom_colors'])){
				$this->data['custom_colors']='';
			}		
			if (!isset($this->data['full_layout'])){
				$this->data['full_layout']='2';
			}		
			Yii::app()->functions->updateOption("layout_themes",$this->data['layout_themes']);
			Yii::app()->functions->updateOption("custom_colors",$this->data['custom_colors']);
			Yii::app()->functions->updateOption("full_layout",$this->data['full_layout']);
			$this->code=1;
			$this->msg="Settings saved.";
		}	
		
		public function alertSettings()
		{			
			if (!isset($this->data['alert_sounds'])){
				$this->data['alert_sounds']='2';
			}		
			if (!isset($this->data['alert_notification'])){
				$this->data['alert_notification']='2';
			}					
			Yii::app()->functions->updateOption("alert_notification",$this->data['alert_notification']);
			Yii::app()->functions->updateOption("alert_sounds",$this->data['alert_sounds']);
			$this->code=1;
			$this->msg="Settings saved.";
		}	

		public function addEvent()
		{			
			if (!isset($this->data['event_description'])){
				$this->data['event_description']='';
			}
			if (!isset($this->data['photo'])){
				$this->data['photo']='';
			}		
			if (!empty($this->data['event_description'])){
				$params=array(
				  'title'=>$this->data['event_name'],
				  'description'=>$this->data['event_description'],
				  'photo'=>$this->data['photo'],
				  'date_created'=>date('c'),
				  'ip_address'=>$_SERVER['REMOTE_ADDR'],
				  'status'=>$this->data['status']
				);
				$db_ext=new DbExt;
				if (isset($this->data['id']) && is_numeric($this->data['id'])){	
					unset($params['date_created']);
					$params['date_modified']=date('c');
					if ( $db_ext->updateData("{{events}}",$params,'event_id',$this->data['id'])){
						$this->msg="Event updated.";
						$this->code=1;
					} else $this->msg=Yii::t("default","ERROR: cannot updated.");
				} else {				
					if ( $db_ext->insertData("{{events}}",$params)){
						$this->msg="Event added.";
						$this->code=1;
						$this->details=Yii::app()->db->getLastInsertID();
					} else $this->msg="ERROR: cannot insert records";
				}
			} else $this->msg="Description is required";
		}	
		
		public function eventList()
		{
			
			$stmt="
			SELECT * FROM
			{{events}}
			ORDER BY event_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[event_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"events?id=$val[event_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[event_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['event_id'],
    	    		  $val['title'].$option,
    	    		  Yii::app()->functions->limitText(strip_tags($val['description']),200),
    	    		  $date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
    	    
		}	
		
		public function sendSMSTest()
		{	
			if ( !isset($this->data['mobile_number_test'])){
				$this->msg="Mobile number is required";
				return ;
			} else $to=$this->data['mobile_number_test'];
		
			$Twilio=new Twilio;
	    	if ( $sms_provider_info=yii::app()->functions->getSMSProvider()){    		
	    		$sms_notification_msg="Test SMS";    			    		
		    	if ( $to ){    		
		    		$to=explode(",",$to); 		    		
		    		if (is_array($to) && count($to)>=1) {
		    			foreach ($to as $mobile_number) {			    				
		    				if ( $sms_provider_info->sms_gateway_id =="twilio"){	    					
		    					if (Yii::app()->functions->senSMSTwilio($mobile_number,$sms_notification_msg,$sms_provider_info)){
		    						$this->code=1;
		    						$this->msg=Yii::app()->functions->sms_msg;
		    					} else $this->msg=Yii::app()->functions->sms_msg;
		    				} else {	    					
		    					if (Yii::app()->functions->sendSmsGlobal($mobile_number,$sms_notification_msg,$sms_provider_info)){
		    						$this->code=1;
		    						$this->msg=Yii::app()->functions->sms_msg;
		    					} else $this->msg=Yii::app()->functions->sms_msg;
		    				}
		    			}
		    		}
		    	}
	    	}
		}	
		
		public function ReservationSettings()
		{			
			if ( !isset($this->data['reservation_to_email'])){
				$this->data['reservation_to_email']='';
			}		
			if ( !isset($this->data['reservation_subject'])){
				$this->data['reservation_subject']='';
			}		
			if ( !isset($this->data['reservation_description'])){
				$this->data['reservation_description']='';
			}	
			
			Yii::app()->functions->updateOption("reservation_to_email",$this->data['reservation_to_email']);
			Yii::app()->functions->updateOption("reservation_subject",$this->data['reservation_subject']);
			Yii::app()->functions->updateOption("reservation_description",$this->data['reservation_description']);
							
            $this->code=1;
            $this->msg="Settings saved.";
		}
		
		public function addPage()
		{
		
			$validator=new Validator;
	    	$req=array(
	    	  'pages_name'=>Yii::t("default","Page name is required"),
	    	  'event_description'=>Yii::t("default","Page Content/HTML is required")	    	  
	    	);
	    	$validator->required($req,$this->data);
	    	if ($validator->validate()){
	    		
	    		if ( !isset($this->data['page_icon'])){
	    			$this->data['page_icon']='';
	    		}
	    		if ( !isset($this->data['seo_title'])){
	    			$this->data['seo_title']='';
	    		}
	    		if ( !isset($this->data['meta_description'])){
	    			$this->data['meta_description']='';
	    		}
	    		if ( !isset($this->data['meta_keywords'])){
	    			$this->data['meta_keywords']='';
	    		}
	    	
	    		$params=array(
				  'page_name'=>$this->data['pages_name'],
				  'page_icon'=>$this->data['page_icon'],
				  'description'=>$this->data['event_description'],
				  'seo_title'=>$this->data['seo_title'],
				  'meta_description'=>$this->data['meta_description'],
				  'meta_keywords'=>$this->data['meta_keywords'],
				  'date_created'=>date('c'),
				  'ip_address'=>$_SERVER['REMOTE_ADDR'],
				  'status'=>$this->data['status'],
				  'friendly_url'=>Yii::app()->functions->createUniqueFriendlyUrl($this->data['pages_name'],"{{pages}}")
				);
				
	    		$db_ext=new DbExt;
				if (isset($this->data['id']) && is_numeric($this->data['id'])){	
					unset($params['date_created']);
					unset($params['friendly_url']);
					$params['date_modified']=date('c');
					if ( $db_ext->updateData("{{pages}}",$params,'page_id',$this->data['id'])){
						$this->msg="Page updated.";
						$this->code=1;
					} else $this->msg=Yii::t("default","ERROR: cannot updated.");
				} else {				
					if ( $db_ext->insertData("{{pages}}",$params)){
						$this->msg="Page added.";
						$this->code=1;
						$this->details=Yii::app()->db->getLastInsertID();
					} else $this->msg="ERROR: cannot insert records";
				}
	    	} else $this->msg=$validator->getErrorAsHTML();
		}	
		
        public function pageList()
		{
			
			$stmt="
			SELECT * FROM
			{{pages}}
			ORDER BY page_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[page_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"addpage?id=$val[page_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[page_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['page_id'],
    	    		  $val['page_name'].$option,
    	    		  $val['seo_title'],
    	    		  Yii::app()->functions->limitText(strip_tags($val['meta_description']),200),
    	    		  $date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
    	    
		}				
		
		public function savePagesMenu()
		{			
			$db_ext=new DbExt;
			if ( !isset($this->data['add_page']) ){
				$this->data['add_page']='';
			}
			$menu_page_id='';							
			if (is_array($this->data['assign_menu']) && count($this->data['assign_menu'])>=1){
				foreach ($this->data['assign_menu'] as $key=>$val_id) {					
					$params=array('assign_menu'=>$val_id);
					$db_ext->updateData("{{pages}}",$params,'page_id',$key);
				}
			}		
			Yii::app()->functions->updateOption("menu_page_id",json_encode($this->data['add_page']));
            $this->code=1;
            $this->msg="Settings saved.";
		}	
		
		public function seoMetas()
		{			
			if ( !isset($this->data['home_seo_title'])){
				$this->data['home_seo_title']='';
			}		
			if ( !isset($this->data['home_meta_description'])){
				$this->data['home_meta_description']='';
			}		
			if ( !isset($this->data['home_meta_keywords'])){
				$this->data['home_meta_keywords']='';
			}		
			
			if ( !isset($this->data['contact_seo_title'])){
				$this->data['contact_seo_title']='';
			}		
			if ( !isset($this->data['contact_meta_description'])){
				$this->data['contact_meta_description']='';
			}		
			if ( !isset($this->data['contact_meta_keywords'])){
				$this->data['contact_meta_keywords']='';
			}
			
			if ( !isset($this->data['events_seo_title'])){
				$this->data['events_seo_title']='';
			}		
			if ( !isset($this->data['events_meta_description'])){
				$this->data['events_meta_description']='';
			}		
			if ( !isset($this->data['events_meta_keywords'])){
				$this->data['events_meta_keywords']='';
			}
			
			if ( !isset($this->data['reservation_seo_title'])){
				$this->data['reservation_seo_title']='';
			}		
			if ( !isset($this->data['reservation_meta_description'])){
				$this->data['reservation_meta_description']='';
			}		
			if ( !isset($this->data['reservation_meta_keywords'])){
				$this->data['reservation_meta_keywords']='';
			}
			
			Yii::app()->functions->updateOption("home_seo_title",$this->data['home_seo_title']);
			Yii::app()->functions->updateOption("home_meta_description",$this->data['home_meta_description']);
			Yii::app()->functions->updateOption("home_meta_keywords",$this->data['home_meta_keywords']);
			
			Yii::app()->functions->updateOption("contact_seo_title",$this->data['contact_seo_title']);
			Yii::app()->functions->updateOption("contact_meta_description",$this->data['contact_meta_description']);
			Yii::app()->functions->updateOption("contact_meta_keywords",$this->data['contact_meta_keywords']);
			
			Yii::app()->functions->updateOption("events_seo_title",$this->data['events_seo_title']);
			Yii::app()->functions->updateOption("events_meta_description",$this->data['events_meta_description']);
			Yii::app()->functions->updateOption("events_meta_keywords",$this->data['events_meta_keywords']);
			
			Yii::app()->functions->updateOption("reservation_seo_title",$this->data['reservation_seo_title']);
			Yii::app()->functions->updateOption("reservation_meta_description",$this->data['reservation_meta_description']);
			Yii::app()->functions->updateOption("reservation_meta_keywords",$this->data['reservation_meta_keywords']);
			
            $this->code=1;
            $this->msg="Settings saved.";			
		}
		
		public function seoXmlSiteMap()
		{			
			if ( !isset($this->data['page'])){
				$this->data['page']='';
			}		
			if ( !isset($this->data['page'])){
				$this->data['custom_page']='';
			}		
			
			//dump($this->data);
			
			$url=Yii::app()->getBaseUrl(true);
			$url=$url."/store";
			
			$page[]=array(
			  'url'=>$url."/events",
			  'lastmod'=>date("Y-m-d"),
			  'changefreq'=>"monthly",
			  'priority'=>"0.5"
			);
			
			$page[]=array(
			  'url'=>$url."/contact-us",
			  'lastmod'=>date("Y-m-d"),
			  'changefreq'=>"monthly",
			  'priority'=>"0.5"
			);
			
			$page[]=array(
			  'url'=>$url."/reservation",
			  'lastmod'=>date("Y-m-d"),
			  'changefreq'=>"monthly",
			  'priority'=>"0.5"
			);
										
			if ( $custom_page=Yii::app()->functions->getPagesList(true)){
				foreach ($custom_page as $val) {	
					if (!in_array($val['page_id'],(array)$this->data['custom_page'])){									
						$page[]=array(
						  'url'=>$url."/page/id/".$val['page_id'],
						  'lastmod'=>date("Y-m-d",strtotime($val['date_created'])),
						  'changefreq'=>"monthly",
						  'priority'=>"0.5"
						);
					}
				}
			}		
			
			if ( $items=Yii::app()->functions->getFoodItemListActive()){
				foreach ($items as $val) {
					//dump($val);
					$page[]=array(
						'url'=>$url."/page/id/".$val['page_id'],
						'lastmod'=>date("Y-m-d",strtotime($val['date_created'])),
						'changefreq'=>"monthly",
						'priority'=>"0.5"
				     );
				}
			}		
			//dump($page);
			
			Yii::app()->functions->updateOption("seo_exclude_page",json_encode($this->data['page']));
			Yii::app()->functions->updateOption("seo_exclude_custom_page",json_encode($this->data['custom_page']));
			$this->code=1;
            $this->msg="Settings saved.";
		}
		
		public function addVoucher()
		{
			$db_ext=new DbExt;
			$voucher_code='';
						
			$validator=new Validator;
	    	$req=array(
	    	  'voucher_name'=>Yii::t("default","Voucher name is required"),
	    	  'amount'=>Yii::t("default","Amount is required"),
	    	  'number_of_voucher'=>Yii::t("default","Number of voucher is required"),
	    	  'status'=>Yii::t("default","Status is required")
	    	);
	    	if ( !empty($this->data['id'])){
	    		unset($req['number_of_voucher']);
	    	}	    
	    	$validator->required($req,$this->data);
	    	if ($validator->validate()){
	    		$params=array(
	    		  'voucher_name'=>$this->data['voucher_name'],
	    		  'number_of_voucher'=>$this->data['number_of_voucher'],
	    		  'amount'=>$this->data['amount'],
	    		  'status'=>$this->data['status'],
	    		  'date_created'=>date('c'),
	    		  'ip_address'=>$_SERVER['REMOTE_ADDR'],
	    		  'voucher_type'=>$this->data['voucher_type']
	    		);
	    		
	    		if ( !empty($this->data['id'])){
	    			unset($params['number_of_voucher']);
	    			unset($params['date_created']);
	    			$params['date_modified']=date('c');	    				    		
	    			$res =$db_ext->updateData("{{voucher}}",$params,'voucher_id',$this->data['id']);
					if ($res){
						$this->code=1;
		                $this->msg=Yii::t("default",'Voucher updated.');  
					} else $this->msg=Yii::t("default","ERROR: cannot updated.");
	    			
	    		} else {	    			    		
		    		$db_ext->insertData("{{voucher}}",$params);
		    		$voucher_id=Yii::app()->db->getLastInsertID();		    
		    		for ($i = 1; $i <= $this->data['number_of_voucher']; $i++) {                     
	                     //$voucher_code=$i.date('YmdGis');
	                     //$voucher_code=generateCouponCode(3).date("YmdHis");                 
	                     $voucher_code=generateCouponCode(3).date("Ymd").$voucher_id.$i;
	                     $params_voucher=array(
	                       'voucher_id'=>$voucher_id,
	                       'voucher_code'=>$voucher_code                       
	                     );
	                     $db_ext->insertData("{{voucher_list}}",$params_voucher);
	                }
	                $this->code=1;
	                $this->msg=Yii::t("default","Voucher successfully generated");
	    		}
	    	} else $this->msg=$validator->getErrorAsHTML();
		}	
		
	    public function voucherList()
	    {
	    	$stmt="
			SELECT a.*,
			 (
			 select count(*) as total
			 from
			 {{voucher_list}}
			 where
			 voucher_id=a.voucher_id
			 and
			 client_id>=1
			 ) as total_used
			 FROM
			{{voucher}} a
			ORDER BY voucher_id DESC
			";	   		    		    	
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	        	        	        	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	    	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[voucher_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"voucher?id=$val[voucher_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[voucher_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		
    	    		if ($val['voucher_type']=="percentage"){
    	    			$amt=$val['amount']. " %";
    	    		} else $amt=$val['amount'];    		
    	    		
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['voucher_id'],
    	    		  $val['voucher_name'].$option,
    	    		  "<a class=\"view_vouchers\" data-id=\"".$val['voucher_id']."\" href=\"javascript:;\">".$val['number_of_voucher']."</a>",
    	    		  $val['voucher_type'],
    	    		  $amt,    	    		  
    	    		  $val['number_of_voucher']." / ".$val['total_used'],
    	    		  $date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }		
	    
	    public function multiOptionAdd()
	    {
	        $params=array(
			  'multi_name'=>addslashes($this->data['multi_name']),			  
			  'status'=>addslashes($this->data['status']),
			  'date_created'=>date('c'),
			  'ip_address'=>$_SERVER['REMOTE_ADDR']
			);			
			$command = Yii::app()->db->createCommand();
			if (isset($this->data['id']) && is_numeric($this->data['id'])){				
				unset($params['date_created']);
				$params['date_modified']=date('c');				
				$res = $command->update('{{multi_options}}' , $params , 
				'multi_id=:multi_id' , array(':multi_id'=> addslashes($this->data['id']) ));
				if ($res){					
					$this->code=1;
	                $this->msg=Yii::t("default",'Multi Option updated.');  
				} else $this->msg=Yii::t("default","ERROR: cannot updated.");
			} else {				
				if ($res=$command->insert('{{multi_options}}',$params)){
	                $this->code=1;
	                $this->msg=Yii::t("default",'Multi Option added.');  
	            } else $this->msg=Yii::t("default",'ERROR. cannot insert data.');
			}	
	    }	
	    
	    public function multiOptionList()
	    {
	    	$stmt="
			SELECT * FROM
			{{multi_options}}
			ORDER BY multi_id DESC
			";
			$connection=Yii::app()->db;
    	    $rows=$connection->createCommand($stmt)->queryAll();     	    
    	    if (is_array($rows) && count($rows)>=1){
    	    	foreach ($rows as $val) {    	     	    		
    	    		$chk="<input type=\"checkbox\" name=\"row[]\" value=\"$val[multi_id]\" class=\"chk_child\" >";   		
    	    		$option="<div class=\"options\">
    	    		<a href=\"multioptions?id=$val[multi_id]\" >".Yii::t("default","Edit")."</a>
    	    		<a href=\"javascript:;\" class=\"row_del\" rev=\"$val[multi_id]\" >".Yii::t("default","Delete")."</a>
    	    		</div>";
    	    		$date=date('D m,Y G:i:s',strtotime($val['date_created']));
    	    		$feed_data['aaData'][]=array(
    	    		  $val['multi_name'].$option,$date."<div>$val[status]</div>"
    	    		);
    	    	}
    	    	$this->otableOutput($feed_data);
    	    }     	    
    	    $this->otableNodata();	
	    }		
	    
	    public function braintreeSettings()    
	    {
	    	yii::app()->functions->updateOption('braintree_enabled',
	    	isset($this->data['braintree_enabled'])?$this->data['braintree_enabled']:'');	    	
	    	
	    	yii::app()->functions->updateOption('braintree_mode',
	    	isset($this->data['braintree_mode'])?$this->data['braintree_mode']:'');
	    	
	    	yii::app()->functions->updateOption('braintree_mtid',
	    	isset($this->data['braintree_mtid'])?$this->data['braintree_mtid']:'');
	    	
	    	yii::app()->functions->updateOption('braintree_key',
	    	isset($this->data['braintree_key'])?$this->data['braintree_key']:'');
	    	
	    	yii::app()->functions->updateOption('braintree_privatekey',
	    	isset($this->data['braintree_privatekey'])?$this->data['braintree_privatekey']:'');
	    	
	    	yii::app()->functions->updateOption('live_braintree_mtid',
	    	isset($this->data['live_braintree_mtid'])?$this->data['live_braintree_mtid']:'');
	    	
	    	yii::app()->functions->updateOption('live_braintree_key',	    	
	    	isset($this->data['live_braintree_key'])?$this->data['live_braintree_key']:'');
	    	
	    	yii::app()->functions->updateOption('live_braintree_privatekey',	    	
	    	isset($this->data['live_braintree_privatekey'])?$this->data['live_braintree_privatekey']:'');
	    		    	
	    	$this->code=1;
	        $this->msg=Yii::t("default","Settings saved.");
	    }	
	    
	    public function adminStripeSettings()
	    {
		   Yii::app()->functions->updateOption("admin_stripe_enabled",
	    	isset($this->data['admin_stripe_enabled'])?$this->data['admin_stripe_enabled']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_stripe_mode",
	    	isset($this->data['admin_stripe_mode'])?$this->data['admin_stripe_mode']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_stripe_enabled",
	    	isset($this->data['admin_stripe_enabled'])?$this->data['admin_stripe_enabled']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_sanbox_stripe_secret_key",
	    	isset($this->data['admin_sanbox_stripe_secret_key'])?$this->data['admin_sanbox_stripe_secret_key']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_sandbox_stripe_pub_key",
	    	isset($this->data['admin_sandbox_stripe_pub_key'])?$this->data['admin_sandbox_stripe_pub_key']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_live_stripe_secret_key",
	    	isset($this->data['admin_live_stripe_secret_key'])?$this->data['admin_live_stripe_secret_key']:'');
	    	
	    	Yii::app()->functions->updateOption("admin_live_stripe_pub_key",
	    	isset($this->data['admin_live_stripe_pub_key'])?$this->data['admin_live_stripe_pub_key']:'');
	    	
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Settings saved.");
	    }
		    
	    public function forgotPassTPL()
	    {	    	
	    	Yii::app()->functions->updateOption("forgot_sender",
	    	isset($this->data['forgot_sender'])?$this->data['forgot_sender']:'');
	    	
	    	Yii::app()->functions->updateOption("forgot_subject",
	    	isset($this->data['forgot_subject'])?$this->data['forgot_subject']:'');
	    	
	    	Yii::app()->functions->updateOption("forgot_tpl",
	    	isset($this->data['forgot_tpl'])?$this->data['forgot_tpl']:'');
	    	
	    	$this->code=1;
	    	$this->msg=Yii::t("default","Settings saved.");
	    }		    	   
	    		
	} /*END AjaxAdmin*/			
}