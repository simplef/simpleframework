<?php
if(!defined('_IN'))
	exit();
	
class FormulaireElement extends HtmlElement
{
	//INPUT ou autre
	var $name='';
	var $value='';
	var $params=array();
	var $validators = array();
	var $elements = array();
	var $isContainer=false;
	var $error='';

	
	function __construct($tag,$name,$isContainer=false)
	{
		parent::__construct($tag);
		$this->name = $name;
		$this->isContainer=$isContainer;
	}
	function addValidator($v)
	{
		$this->validators[] = $v;
	}
	function addElement($e)
	{
		$this->elements[] = $e;
	}
	function verify()
	{
		$noerror=true;
		if(!$this->isContainer)
		{
			foreach($this->validators as $v)
			{
				if(!$v->check($this->value))
				{
					$this->error=$v->errorText();
					$noerror=false;
				}
			}
		}
		else
		{
			foreach($this->elements as $e)
			{
				if(!$e->verify())
				{
					return false;
					$noerror=false;
				}
			}
		}
		return $noerror;
	}
	function useValues($values)
	{
		if($this->isContainer)
		{
			foreach($this->elements as $e)
				if(is_a($e,__CLASS__))
					$e->useValues($values);
		}
		else if(isset($values[$this->name]))
			$this->value=$values[$this->name];
	}
	function verifError()
	{
		return $this->errors;
	}
	function html($showErrors = false)
	{
		if(!$this->isContainer)
		{
			return parent::html($showErrors);
		}
		
		
		$elementsHtml = '';
		foreach($this->elements as $e)
			$elementsHtml.= $e->html().Html::br();
			
		parent::setContent($elementsHtml);
		return parent::html();
	}
}

class FormInput extends FormulaireElement
{
	var $label='';
	var $displaySize =0;
	var $maxChar = 0;
	
	function __construct($name,$desc,$defValue='',$displaySize=0,$maxChar=0)
	{
		parent::__construct('input',$name,false);
		$this->label = $desc;
		$this->value = $defValue;
		$this->addAttrib('value',$defValue);
		$this->addAttrib('id',$name);
		$this->addAttrib('name',$name);
	}
	
	function html($showErrors = false)
	{
		$this->addAttrib('value',$this->value);
		$this->html = Html::tag('label',$this->label,array('for'=>$this->name));
		$this->html .= parent::html($showErrors);
		if($this->error!='')
			$this->html .= Html::tag('span','*'.$this->error,array('class'=>'error'));
		return $this->html;
	}
}

class FormFieldset extends FormulaireElement
{

}

class FormSelect extends FormulaireElement
{

}

class FormTextarea extends FormulaireElement
{

}
?>