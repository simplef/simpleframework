<?php
if(!defined('_IN'))
	exit();

	/*
	Exemple :
//Création du formulaire
$f = new ModelCreatorForm('nouveau_compte',true);
$f->addField('pseudo','Votre pseudo','varchar','');
$f->addField('signature','Votre signature','text','Pas de signature ...');
$f->createForm(); //Pas obligé
echo $f->html();

//Réception
$f = new ModelCreatorForm('nouveau_compte',true);
$f->addField('pseudo','Votre pseudo','varchar','');
$f->addField('signature','Votre signature','text','Pas de signature ...');
$receivedValues = $f->getValues();
$db->insert('account',$receivedValues);

	*/


class ModelCreatorForm extends Formulaire
{
	protected $m_html='';

	function __construct($name,$useCaptcha=false)
	{
		parent::__construct($name, true, $useCaptcha, 'POST');
	}
	
	function addElement($name /*Nom dans la DB*/,
		$description='' /*ex : Votre nom d'utilisateur*/,
		$type='varchar' /*int,text,varchar,bool*/,
		$default =''/*Default value*/)
	{
		$value = $this->getParam($name);
		if($value == null)
			$value = $default;
		$this->arrayFields[$name] = new FormulaireElement($name,$description,$type,$value);
	}
	
	function createForm()
	{
		$this->loadReceivedData();
		//Ajout des champs dans la classe formulaire
		foreach($this->arrayFields as $name => $field)
		{
			parent::addElement($field);
		}
		
		$this->m_html = parent::html();
	}
	
	function html()
	{
		if($this->m_html == '')
			$this->createForm();
		return $this->m_html;
	}
	
	function loadReceivedData()
	{
		foreach($this->arrayFields as $name => $field)
		{
			if($this->getParam($name)!=null)
				$this->arrayFields[$name]->value = $this->getParam($name);
		}
	}
	function getValues()
	{
		$this->loadReceivedData();
		$ret = array();
		foreach($this->arrayFields as $name => $field)
		{
			$ret[$name] = $field->value;
		}
		return $ret;
	}

}
?>