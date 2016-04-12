<?php
class LoginForm extends CFormModel
{
    public $username;
    public $password;  
    public $remember;       
 
    public function rules()
    {
        return array(
            array('username, password', 'required'),   
            array('remember', 'boolean'),                     
        );
    } 
        
    public function login()
    {         	
    	$stmt="SELECT * FROM
			{{user}}
			WHERE
			username ='".addslashes($this->username)."'		
			AND
			password ='".md5(addslashes($this->password))."'
			AND
			status='active'
			LIMIT 0,1
	    ";        	    	
    	$connection=Yii::app()->db;
    	$rows=$connection->createCommand($stmt)->queryAll();     	
    	if (is_array($rows) && count($rows)>=1){    		    		
    		if ($this->remember){    		    
    		    setcookie("rst_cookie_u", $this->username, time()+365*24*60*60, '/');
	            setcookie("rst_cookie_p", $this->password, time()+365*24*60*60, '/');
	            setcookie("rst_remember", $this->remember, time()+365*24*60*60, '/');
    		}    		
    		Yii::app()->request->cookies['rst_user'] = new CHttpCookie('rst_user', json_encode($rows));    		
    		return true;
    	} else $this->addError("password",'Login Failed. Either username or password are invalid');
    	return false;
    }
          
}
/*END LoginForm*/