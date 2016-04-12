<?php
if ( Yii::app()->functions->isTableExist("languages") ){			
	$lang_id='';
	if ( Yii::app()->controller->id =="admin"){
		$lang_id=Yii::app()->functions->getAdminLanguage();	
	} elseif (Yii::app()->controller->id=="store") {
		if (isset($_COOKIE['rst_lang_id'])){
			$lang_id=empty($_COOKIE['rst_lang_id'])?"":$_COOKIE['rst_lang_id'];
		} else {
			$lang_id=Yii::app()->functions->getOption("lang_default");
		}
	}
	return Yii::app()->functions->getSourceTranslation($lang_id);
}