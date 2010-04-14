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
	
	static function escapeAccents($str)
	{
		
		$accents = array(
		'£' => 'pound',		'è' => 'egrave',
    	'¤' => 'curren',		'é' => 'eacute',
		'À' => 'Agrave',		'ê' => 'ecirc',
		'Á' => 'Aacute',		'ë' => 'euml',
		'Â' => 'Acirc',		'î' => 'icirc',
		'¡' => 'iexcl',		'Ã' => 'Atilde',		'ô' => 'ocirc',
		'¢' => 'cent',		'Ä' => 'Auml',		'ù' => 'ugrave'
		);
		return Html::str_accents_replace_assoc($accents, $str);
	}
	
	static function str_accents_replace_assoc($array,$string)
	{
		$from_array = array();
		$to_array = array();
		
		foreach ($array as $k => $v){
			$from_array[] = $k;
			$to_array[] = '&'.$v.';';
		}
		
		return str_replace($from_array,$to_array,$string);
	}
	//function html($txt){return htmlentities($txt);}
	static function escape($txt){return htmlentities($txt);}
}

?>