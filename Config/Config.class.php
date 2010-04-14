<?php
if(!defined('_IN'))
	exit();
	
include (str_replace('\\','/',dirname(__FILE__)).'/ConfigBase.class.php');

function getCurrentConfig()
{
	return new ConfigNoDb;
}

function _includeSite($racine)
{
	include($racine.getCurrentConfig()->getLibDir().'Site.class.php');
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