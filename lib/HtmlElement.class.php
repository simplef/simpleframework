<?php
if(!defined('_IN'))
	exit;

class HtmlElement
{
	var $m_simple=false;
	var $m_tagName='';
	var $m_innerHtml='';
	//Tableau associatif. AttributName => Value
	var $m_attributs = array();
	function __construct($tagName,$innerHtml='')
	{
		$this->m_simple = ($innerHtml == '') ? true: false;
		$this->m_innerHtml = $innerHtml;
		$this->m_tagName = $tagName;
	}
	function addAttrib($name,$value)
	{
		$this->m_attributs[$name] = $value;
	}
	function setContent($c)
	{
		$this->m_simple = ($c == '') ? true: false;
		$this->m_innerHtml = $c;
	}
	function setTag($tagName)
	{
		$this->m_tagName = $tagName;
	}
	
	function html()
	{
		return Html::tag($this->m_tagName,$this->m_innerHtml,$this->m_attributs);
	}
}
?>