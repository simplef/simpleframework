<?php
if(!defined('_IN'))
	exit();
define('NOT_DEFINED_VALUE',345872837);

class NumberValidator implements Validator
{
	protected $useMin=false;
	protected $useMax=false;
	protected $min=0;
	protected $max=0;
	
	var $error='';
	function __construct($min=NOT_DEFINED_VALUE,$max=NOT_DEFINED_VALUE)
	{
		if($min != NOT_DEFINED_VALUE)
		{
			$this->useMin = true;
			$this->min  = $min;
		}
		if($max != NOT_DEFINED_VALUE)
		{
			$this->useMax = true;
			$this->max  = $max;
		}
	}
	function check($what)
	{
		
		if(!is_numeric ($what))
		{
			$this->error='Doit etre un nombre';
			return false;
		}
		if($this->useMax && $what > $this->max)
			return false;
		if($this->useMin && $what < $this->min)
			return false;
		return true;
	}
	function errorText()
	{
		return $this->error;
	}
}


?>