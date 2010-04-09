<?php
if(!defined('_IN'))
	exit();
	
	
class CacheMgr
{
	var $options = array(
	'rep_racine' 	=> '',
	'path' 			=> 'cache/',
	'file_ext' 		=> '.cache');
	/*
	PUBLIC
	*/
	function CacheMgr($options)
	{
		foreach($this->options as $index => $value)
			if(isset($options[$index]))
				$this->option[$index] = $options[$index];
	}
	function getValue($cacheName,$index)
	{
		$cacheContent = $this->getCacheFileContent($cacheName);
		if(!isset($cacheContent[$index]))
			return false;
		//Outdated value ?
		if( $cacheContent[0] < time())
		{
			array_splice($cacheContent,$index);
			$this->setCacheFileContent($cacheName,$cacheContent); //Sauvegarde ...
			return false; 
		}
		return $cacheContent[$index][1]; //Existe et a jour => INDEX 0 = temps de cache; timestamp MAX.
	}
	function setValue($cacheName,$index,$newValue,$timeToCache)
	{
		if(intval($timeToCache) <= 0) //ERREUR
			return false;
			
		$cacheContent = $this->getCacheFileContent($cacheName);
		$cacheContent[$index] = array(time()+$timeToCache,$newValue);
		$this->setCacheFileContent($cacheName,$cacheContent);
	}
	/*
	PRIVATE
	*/
	//SET/GET sur les fichies de cache.
	function getCacheFileContent($name)
	{
		return $this->getFileContent($this->options['path'].$name.$this->options['file_ext']);
	}
	function setCacheFileContent($name,$contenu)
	{
		return $this->setFileContent($this->options['path'].$name.$this->options['file_ext'],$contenu);
	}
	function getFileContent($fileName)
	{
		return @unserialize(@file_get_contents($fileName));
	}
	function setFileContent($fileName,$contenu)
	{
		return @file_put_contents ($fileName,@serialize($contenu));
	}
	
}

?>