<?php

/**
 * 
 */
class DataCheck {
	

	function requestcleaner() {
		
		$_POST=$this->array_map('trim',$_POST);
		$_GET=$this->array_map('trim', $_GET);
		if (get_magic_quotes_gpc()) {
			$_POST=$this->array_map('stripslashes', $_POST);
			$_GET=$this->array_map('stripslashes', $_GET);
		}
		//$_POST=$this->array_map('mysql_real_escape_string', $_POST);
		//$_GET=$this->array_map('mysql_real_escape_string', $_GET);
		
	}

	function array_map($func, $arr) {
		$newArr = array();
		foreach($arr as $key=>$value ) {
			$newArr[$key]=(is_array($value)?$this->array_map($func, $value):$func($value));
		}
		return $newArr;
	}



}



?>