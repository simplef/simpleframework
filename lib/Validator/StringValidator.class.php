<?php
if(!defined('_IN'))
	exit();

/*
Liste blanche : strspn
Liste noire : strcspn

// LARGE VERSION
$forbidden="\"\\?*:/@|<>";
if (strlen($filename) != strcspn($filename,$forbidden)) 
{
    echo "you cant create a file with that name!";
}

// SHORT VERSION
if (strlen($filename) - strcspn($filename,"\"\\?*:/@|<>")) 
{
    echo "i told you, you cant create that file";
}

*/
class StringValidator implements Validator
{
	var $error='';
	var $max_length=0;
	var $min_length=0;
	var $caracters = '';
	var $allow = true;
	
	function __construct($minL=0,$maxL=0,$caractersTo="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890\0",$allow=true)
	{
		$this->min_length = $minL;
		$this->max_length = $maxL;
		$this->caracters = $caractersTo;
		$this->allow = $allow;
	}
	function check($what)
	{
		//OK
		if($this->allow && (strlen($what) - strspn($what,$this->caracters)))
		{
			$this->error='Ce champs contient des caracteres interdits.';
			return false;
		}
		if(strlen($what) < $this->min_length)
		{
			$this->error='Nombre de lettre minimum : '.$this->min_length;
			return false;
		}
		if($this->max_length>0 AND strlen($what) > $this->max_length)
		{
			$this->error='Nombre de lettres maximum : '.$this->max_length;
			return false;
		}
		if($what=='' AND $this->min_length >0)
		{
			$this->error='Ce champs est requis';
			return false;
		}
		return true;
	}
	function errorText()
	{
		return $this->error;
	}
}


?>
