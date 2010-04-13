<?php
if(!defined('_IN'))
	exit();

/* A completer en fonction du site ...
Absolument pas securise pour le moment, mais n'est pas utilise.
*/
class Visiteur
{
	static function ip()
	{
		return $_SERVER["REMOTE_ADDR"];
	}
	static function referer()
	{
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
	}
	static function method()
	{
		return isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
	}
	static function useragent()
	{
		return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}
	static function browser($object=true)
	{
		return get_browser(null, !$object);
	}
	
	static function connected()
	{
		return isset($_GET['connected']) || Visiteur::admin();
	}
	static function admin()
	{
		return isset($_GET['admin']);
	}
	static function connect()
	{
		return false;
	}
}

?>