<?php

interface formInterface {
	public function getForm();
}

class form implements formInterface {
	public function getForm() {
		$form="Vorname ". "<input type='text' name='vorname' />"."<br />".
		"Nachname "."<input type='text' name='nachname' />"."<br />";
		return $form;
	}
}

abstract class formDecorator implements formInterface {
	
	protected $_form;
	
	public function __construct(formInterface $form) {
		$this->_form=$form;
	}
	public function getForm() {
		return $this->_form->getForm();
	}
}

class emailForm extends formDecorator {
	
	public function getForm() {
		
		$data=$this->_form->getForm();
		return $data."<br />"."E-Mail : "."<input type='text' name='email' />";
	}
}

class icqForm extends formDecorator {
	
	public function getForm() {
		
		$data=$this->_form->getForm();
		return $data."<br />ICQ-Number : "."<input type='text' name='icq' /><br>";
	}
}

$basis=new form();
$email=new emailForm($basis);
$icq=new icqForm($email);
echo $icq->getForm();

?>