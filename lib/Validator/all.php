<?php
if(!defined('_IN'))
	exit();
$validators = array('NumberValidator','NotNullValidator','StringValidator');

if(!$this->addLibFile('Validator/Validator',false))
		throw new Exception('Impossible d\'inclure l\'interface de Validation des formulaires : Validator/Validator.class.php');
foreach($validators as $v)
	if(!$this->addLibFile('Validator/'.$v,false))
		throw new Exception('Impossible d\'inclure le validateur : '.htmlentities($v).' dans Validator/');

?>