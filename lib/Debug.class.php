<?php
$debugI = 0;

class Debug
{
	var $instance;

	//Constructeur privé
	private function Debug(){}
	
	//SINGLETON
	function out($what)
	{
		if(Site::config()->isDevMode())
			echo '<p style="background-color:white;color:red;">[DEBUG] - '.$what.'</p>';
	}
	function track($i=-1)
	{
		if(Site::config()->isDevMode())
			echo ($i == -1) ? 'Track<br />' : 'Track '.$i.' <br />';
	}
	function dump($var, $varName='')
	{
		ob_start ();
		var_dump($var);
		$out = ob_get_contents();
		ob_end_clean();
		if($varName != '')
		$out = $varName.' : '.$out;
		Debug::out($out);
	}
}

class DebugLoop
{
	var $iLoop=0;
	function __contruct()
	{
	
	}
	
	function debugLoop($maxIter=20)
	{
			$this->iLoop++;
			if($this->iLoop == $maxIter)
			{
				$this->debugBt();
			}
	}
	function debugBt()
	{
		debug_print_backtrace ();
		die();
		$arrayb = debug_backtrace();
		echo '<h3>Debug : Backtrace</h3>';
		echo '<lu>';
		foreach($arrayb as $id)
			echo '<li>'.
				(isset($id['class']) ? $id['class'].'::' : 'function ')
				.$id['function'].' - '.$id['file'].'('.$id['line'].')</li>';
		echo '</ul>';
		die();
	}
}
?>