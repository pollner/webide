<?php

class TemplateHelper {

	protected function js_file($f) {
	
		return '<script type="text/javascript" src="'.$f.'"></script>';
	}
	protected function css_file($f) {
	
		return '<link rel="stylesheet" type="text/css" href="'.$f.'">';
	}

}

?>