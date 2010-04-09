<?php
if(!defined('_IN'))
	exit();
	
class Chrono
{
	var $debutTime = 0;
	var $timesMarked = array();
	
	function Chrono(){}
	function getTime()
	{
		$timeArray = explode(' ', microtime());
		$time =  $timeArray[0]+$timeArray[1];
		return round($time,8);
	}
	function start()
	{
		$this->debutTime = $this->getTime();
	}
	
	function diff()
	{
		return ($this->getTime() - $this->debutTime);
	}
	
	function markTime($name)
	{
		$this->timesMarked[$name] = sprintf('%f',$this->diff());
	}
	function getTimesArray()
	{
		return $this->timesMarked;
	}
	function getHTMLLogs()
	{
		$render =  new ArrayRender();
		return $render->render($this->getTimesArray());
	}
}

?>