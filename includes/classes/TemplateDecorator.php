<?php

interface templateInterface {
	public function getTemplate();
}

class template implements templateInterface {
	public function getTemplate() {
		$template="Vorname ". "<input type='text' name='vorname' />"."<br />".
		"Nachname "."<input type='text' name='nachname' />"."<br />";
		return $template;
	}
}

abstract class templateDecorator implements templateInterface {
	
	protected $_template;
	
	public function __construct(templateInterface $template) {
		$this->_template=$template;
	}
	public function getTemplate() {
		return $this->_template->getTemplate();
	}
}

class emailTemplate extends templateDecorator {
	
	public function getTemplate() {
		
		$data=$this->_template->getTemplate();
		return $data."<br />"."E-Mail : "."<input type='text' name='email' />";
	}
}

class icqTemplate extends templateDecorator {
	
	public function getTemplate() {
		
		$data=$this->_template->getTemplate();
		return $data."<br />ICQ-Number : "."<input type='text' name='icq' /><br>";
	}
}

$basis=new template();
$email=new emailTemplate($basis);
$icq=new icqTemplate($email);
echo $icq->getTemplate();

?>