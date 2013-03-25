<?php
/**
 * Templater is a simple
 * template-engine.
 * 
 */
 
Factory::inc('includes::classes::TemplateHelper');

class TemplateFluid extends TemplateHelper {

	public $template;
	
	public function load($template_filepath) {
		$file=$template_filepath;
		if(file_exists($file)){
			$handle=fopen("$file","r");
			$contents = fread($handle, filesize($file));
			fclose($handle);
			$this->template.=$contents;			
	        }
	        return $this;
	}
	       
	public function append($content) {
		$this->template.=$content;
		return $this;
	} 

	public function replace($placeholder,$content) {
		$this->template=str_replace("$placeholder",$content,$this->template);
		return $this;
	}

	public function render() {
		echo $this->template;
	}


}

/*
$template=new TemplateFluid();
$template->append("<html><head></head>")
	 ->append("<body><h1>Hallo</h1>")
	 ->append("</body></html>")
	 ->render();
*/

?>