<?php

//Configuration par defaut.
// Modifier la configuration dans Config.class.php et non pas ici.
class ConfigBase
{
	function useDb()
	{	return true;	}
	function DbHost()
	{	return 'localhost';}
	function DbLogin()
	{	return 'root';	}
	function DbPass()
	{	return '';		}
	function DbName()
	{	return 'mysql';}
	
	function getLibDir()
	{	return 'lib/';}
	function getModelDir()
	{	return 'Model/';}
	function getTemplatesDir()
	{	return 'Templates/';}
	function getVueDir()
	{	return 'Vue/';}
	function getCacheDir()
	{	return 'Cache/';}
	
	function getSiteBaseUrl()
	{	return 'http://localhost/framework/';	}
	function getTemplateExt()
	{	return '.tpl';	}
	function getDefaultTemplateName()
	{	return 'default';}
	function getCacheFileExt()
	{	return '.cache';}
	function getSiteShortName()
	{	return 'Simple Framework Site : 0.1'; }
	function getFavicon()
	{	return 'http://www.macdirectory.fr/img/favicons/favicon_defaut.png';}
	function isDevMode()
	{	return true;}
}

?>