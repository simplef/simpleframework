<?php

if(!defined('_IN'))
	exit;

function AddTemplateCustomVars($obj, $isCached)
{
	if($isCached)
		return;
	
	// Ajouter ici les items de template personalises.
	// (...)
	
	// Ajouter en dessous les items de template, en fonction de la page
	// (Si ils sont presents sur plusieurs pages, sinon, les definir sur la page)
	/** Exemple :
	switch($obj->page)
	{
		case 'index':
		case 'page2':
		{
			
			$obj->setVar('total_account', AccountMgr::GetCount());
			
		}
		default:
		{
			
		}	
	}
	//**/
}
?>
