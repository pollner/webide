<?php

 class ServerObserver implements Observer 
 {
 	public function update(Observeable $Subject) {
		
		$func_array=array('system','proc_open');
		foreach($func_array as $val) {
			if (function_exists($val)) {
				Registry::set($val,'on');
			}	
 		}
 	}
 }

?>