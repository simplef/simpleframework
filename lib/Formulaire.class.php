<?php
if(!defined('_IN'))
	exit();
	
class FormButton extends HtmlElement
{
	var $type=''; //SUBMIT, RESET
	var $value='';
	var $name='';
	function __construct($name='submit',$value='Envoyer',$type='submit')
	{
		$this->type = $type=='submit' ? 'submit' : 'reset';
		$this->name = $name;
		$this->value = $value;
	}
	function html()
	{
		return Html::tag('input', '',array('type'=>$this->type,'name'=>$this->name,'value'=>$this->value));
	}
}

class Formulaire
{
	var $useToken = true;
	var $useCaptcha = false;
	var $formName = '';
	var $receivedValues = null;
	var $fields=null;
	var $method = 'POST';
	protected $html='';
	//Bouton submit
	var $submit=null;
	//Array : FieldName => FormulaireElement
	var $arrayFields=array();
	
	function __construct($name, $secToken=true, $secCaptcha=false, $type='POST')
	{
		$this->useToken = $secToken;
		$this->useCaptcha = $secCaptcha;
		$this->formName = $name;
		$this->submit = new FormButton;
		switch($type)
		{
			case 'POST': $this->method='POST';$this->receivedValues = $_POST; break;
			case 'GET': $this->method='GET';$this->receivedValues = $_GET; break;
			default: $this->method='POST';$this->receivedValues = $_POST; break;
		}
		if($this->sent())
		{ 	//Envoyé
			
		}
		else
		{	//Générer un nouveau formulaire
		
		}
	}
	/*
	bool sent();
	=> Formulaire envoyé ?
	*/
	function sent()
	{
		return isset($this->receivedValues[$this->submit->name]);
	}
	function fillReceived()
	{
		foreach($this->fields as $f)
		{
			if(is_subclass_of($f,'FormulaireElement') OR is_a($f,'FormulaireElement'))
				$f->useValues($this->receivedValues);
		}
	}
	/*
	Vérification
	*/
	function verify()
	{
		$noErr = 0;
		foreach($this->fields as $f)
		{
			if(!$f->verify())
			{
				$noErr++;
			}
		}
		return ($noErr==0);
	}
	function getParam($name)
	{
		return (isset($this->receivedValues[$name])) ? $this->receivedValues[$name] : null;
	
	}
	/*
	Ajouter des inputs ...
	*/
	function addElement($e)
	{
		$this->fields[$e->name] = $e;
	}
	function setSubmit($s)
	{
		$this->submit = $s;
	}
	function render($showErrors = false)
	{
		//Header
		$this->html = '<form action="" method="'.$this->method.'">';
		//Tous les champs
		foreach($this->fields as $name => $field)
		{
			$this->html .= $field->html($showErrors);
			$this->html .= Html::br();
		}

		//Bouton envoyer
		if($this->submit != null)
			$this->html .= $this->submit->html();
		
		//Fin de la form
		$this->html .= '</form>';
	}
	
	function html($showErrors = false)
	{
		if($this->html!='')
			return $this->html;
		$this->render($showErrors);
		
		return $this->html;
	}
	/*
	Fonctions magiques
	*/
	function __get($name)
	{
		if(in_array($name,array('useToken','useCaptcha','formName','method'))) //Non autorisé
		{
			return null;
		}
		return $this->getParam($name);
	}


}
?>