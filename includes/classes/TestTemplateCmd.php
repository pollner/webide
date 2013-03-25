<?php
/**
 * 
 * 
 * 
 */
class TestTemplateCmd implements Cmd_ICommand 
{ 
         public function process() 
         {
         	$html_iconset='<a href="javascript: explorer()">
         	                 <img title="Explorer" alt="Explorer" src="jqueryFileTree/images/explorer.png" style="">
         	               </a>';           	                         
    		$this->Template=Factory::get("includes::classes::TemplateFluid");
    		$this->Template->load("includes/templates/TestTemplate.html")
    			->replace('{ICONSET}',$html_iconset)
    	     		->replace('{CONTENT}',"ich bin der Content.");     	              
    		$this->Template->render();
         }
}
?>