<?php
if(!defined('_IN'))
	exit;
/*
2 manieres d'acceder à une configuration :
Config::get('isDevMode');
ou
Config::conf()->isDevMode();
ou
Config::isDevMode(); (codé a la barbare x) )

Si PHP > 5.3, la fonction magique "__callStatic" est implémentée :
Config::isDevMode(); sans hack.

Chez free :
PHP Version 5.1.3RC4-dev
*/
class Config
{
	/*
	#######################################
	# Variables
	#######################################
	*/
	
	var $_config=null;
	static $instance=null;
	
	/*
	#######################################
	# Constructeur, accesseurs
	#######################################
	*/
	private function Config(){}
	function conf()
	{
		if (!isset(self::$instance)) 
		{
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
	}
	function instance()
	{
		if (!isset(self::$instance)) 
		{
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
	}
	function setConf($c)
	{
		Config::instance()->_config = $c;
	}
	
	/*
	#######################################
	# Méthodes magiques
	#######################################
	*/
	function __call($method,$args)
	{
		return Config::instance()->_config->$method($args);
	}
	static function __callStatic($method,$args)
	{
		return Config::instance()->_config->$method($args);
	}
	function get($func)
	{
		return Config::instance()->_config->$func();
	}
	
	
	/*
	##################################################
	# Méthodes un peu moins magiques :-)
	##################################################
	*/
	function useDb()
	{	return Config::instance()->_config->useDb();	}
	function DbHost()
	{	return Config::instance()->_config->DbHost();}
	function DbLogin()
	{	return Config::instance()->_config->DbLogin();	}
	function DbPass()
	{	return Config::instance()->_config->DbPass();		}
	function DbName()
	{	return Config::instance()->_config->DbName();}
	
	function getLibDir()
	{	return Config::instance()->_config->getLibDir();}
	function getModelDir()
	{	return Config::instance()->_config->getModelDir();}
	function getTemplatesDir()
	{	return Config::instance()->_config->getTemplatesDir();}
	function getVueDir()
	{	return Config::instance()->_config->getVueDir();}
	function getCacheDir()
	{	return Config::instance()->_config->getCacheDir();}
	
	function getSiteBaseUrl()
	{	return Config::instance()->_config->getSiteBaseUrl();	}
	function getTemplateExt()
	{	return Config::instance()->_config->getTemplateExt();	}
	function getDefaultTemplateName()
	{	return Config::instance()->_config->getDefaultTemplateName();}
	function getCacheFileExt()
	{	return Config::instance()->_config->getCacheFileExt();}
	function getSiteShortName()
	{	return Config::instance()->_config->getSiteShortName(); }
	function getFavicon()
	{	return Config::instance()->_config->getFavicon();}
	function isDevMode()
	{	return Config::instance()->_config->isDevMode();}
}