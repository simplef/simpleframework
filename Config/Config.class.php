<?php
if(!defined('_IN'))
	exit();

function getCurrentConfig()
{
	return new ConfigNoDb;
}

function _includeSite($racine)
{
	include($racine.getCurrentConfig()->getLibDir().'Site.class.php');
}

//Configuration par défaut
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
	{	return 'http://daemondev.free.fr/dev/';	}
	function getTemplateExt()
	{	return '.tpl';	}
	function getDefaultTemplateName()
	{	return 'default';}
	function getCacheFileExt()
	{	return '.cache';}
	function getSiteShortName()
	{	return 'Simple Framework Site : 0.0.7'; }
	function getFavicon()
	{	return 'http://www.macdirectory.fr/img/favicons/favicon_defaut.png';}
	function isDevMode()
	{	return true;}
}

//Configuration locale
class ConfigLocal extends ConfigBase
{
	function useDb()
	{	return true;	}
	function DbLogin()
	{	return 'root';	}
	function DbPass()
	{	return '';		}
	function DbName()
	{	return 'framework';}
	function isDevMode()
	{	return true;}
}

//Configuration online
class ConfigOnline extends ConfigBase
{
	function useDb()
	{	return true;	}
	function DbHost()
	{	return 'localhost';}
	function DbLogin()
	{	return '';	}
	function DbPass()
	{	return '';		}
	function DbName()
	{	return '';}
	function isDevMode()
	{	return true;}
}

//NoDb
class ConfigNoDb extends ConfigBase
{
	function useDb()
	{	return false;	}
	function isDevMode()
	{	return true;}
}

?>