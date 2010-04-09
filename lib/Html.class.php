<?php
if(!defined('_IN'))
	exit();

class Html
{
	static function htmlTag($tagName,$innerHTML=null,$params=null)
	{
		return Html::tag($tagName,$innerHTML,$params);
	}
	static function tag($tagName,$innerHTML=null,$params=null)
	{
		$HTML = '<'.$tagName;
		if($params!=null && is_array($params))
			foreach($params as $name => $value)
				$HTML .= ' '.$name.'="'.Html::escape($value).'"';
		if($innerHTML == null) //Type <xxx />
			return $HTML. ' />';
		//Type <machin>oOo</machin>
		$HTML .= ' >'.$innerHTML.'</'.$tagName.'>';
		return $HTML;
	}
	static function br()
	{
		if(!Config::isDevMode())
			return '<br />';
		return "<br />\n";
	}
	static function td($content)
	{
		return Html::tag('td',$content);
	}
	static function tr($content)
	{
		return Html::tag('tr',$content);
	}
	static function table($content)
	{
		return Html::tag('table',$content);
	}
	//function html($txt){return htmlentities($txt);}
	static function escape($txt){return htmlentities($txt);}
}

?>