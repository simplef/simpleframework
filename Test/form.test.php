<?php
include('../init.php');

$pr = Site::instance()->getNewRender();
/*
$f = new Formulaire('nouveau_compte',true);
	$e1 = new FormulaireElement('MyFieldset','desc','fieldset','Value ...');
		$sub1 = new FormulaireElement('el2','Sous element 1','text','123');
			$sub1->addValidator(new NumberValidator);
		$sub2 = new FormulaireElement('el3','Sous element 2','text','Valeur2');

	$e1->addElement($sub1);
	$e1->addElement($sub2);*/
$f = new Formulaire('nouveau_compte',true);
$e1 = new FormInput('number','Un nombre ...');
$e1->addValidator(new NumberValidator);
$e2 = new FormInput('name','Non null');
$e2->addValidator(new NotNullValidator);
$e3 = new FormInput('pseudo','Caracteres autorisés');
$e3->addValidator(new StringValidator);
$f->addElement($e1);
$f->addElement($e2);
$f->addElement($e3);
$f->fillReceived();

$out = '<h1>Formulaire Test</h1>';
if($f->sent())
{
	$out .= '<ul><li>Envoyé</li>';
	if($f->verify())
	{
		$out .= '<li>Formulaire validé</li>';
	}
	$out .= '</ul>';
}
$pr->renderHtml($out.$f->html(true));

?>