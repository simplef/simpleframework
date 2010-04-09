<?php
if(!defined('_IN'))
	exit();

class ArrayRender
{
	function ArrayRender(){}
	
	function render($array)
	{
		if(!is_array($array))
			return false;
		$table = '';
		foreach($array as $name => $value)
		{
			if(is_array($value))
			{
				$table .= Html::tr(
									Html::td(Html::escape($name)).
									Html::td($this->render($value))
									);
				continue;
			}
			$table .= Html::tr(
								Html::td($this->html($name)).
								Html::td($this->html($value))
								);
		}
		return Html::table($table);
		
	}

}
?>