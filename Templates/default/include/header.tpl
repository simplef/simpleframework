{* Smarty *}
{* Besoin de :
-titre
-meta
-cssDirectory
-favicon
-elementsMenu[x].url , .name, .titre
-
- *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
   	<head>
       	<title>{$titre}</title>
       	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
       	{$meta}
        	<link rel="stylesheet" media="screen" type="text/css" title="Design Par défaut" href="{$cssDirectory}style.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" ></script>
		<link rel="shortcut icon" type="image/x-icon" href="{$favicon}" />
		<script type="text/javascript" src="{$racine}js/SyntaxHighlighter/Scripts/shCore.js"></script>
		<script type="text/javascript" src="{$racine}js/SyntaxHighlighter/Scripts/shBrushCpp.js"></script>
		<script type="text/javascript" src="{$racine}js/SyntaxHighlighter/Scripts/shBrushPhp.js"></script>
		<script type="text/javascript" src="{$racine}js/SyntaxHighlighter/Scripts/shBrushHtml.js"></script>
		<script type="text/javascript" src="{$racine}js/SyntaxHighlighter/Scripts/shBrushXml.js"></script>
		<link type="text/css" rel="stylesheet" href="{$racine}js/SyntaxHighlighter/Styles/SyntaxHighlighter.css" />

	</head>
   	<body>