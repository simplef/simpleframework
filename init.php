<?php
if(!defined('_IN'))
	exit();
//ini_set("memory_limit" , "500M");

// Definir le repertoire racine
if(!defined('REP_RACINE'))
	define('REP_RACINE',str_replace('\\', '/', dirname(__FILE__)).'/');

//On commence bien :-)
class FatalErrorRenderBasic
{
	private function InfTablRow($name,$val)
	{
		return '<tr><td><strong>'.$name.'</strong></td><td style="color:red;">'.nl2br(htmlentities($val));
	}
	function __construct($erreur)
	{
		$header = '<title>Fatal Error</title>
		<h1 style="color:red;">FrameWork Erreur Fatale</h1>
		<strong style="color:blue"><span>Erreur fatale</span> : impossible de continuer le chargement de la page.</strong>
		<fieldset><legend>Informations sur l\'erreur :</legend>';
		if(is_subclass_of($erreur,'Exception') || is_a($erreur,'Exception'))
			$body = '<table>'.$this->InfTablRow('Message',$erreur->getMessage()).
							$this->InfTablRow('Fichier',$erreur->getFile()).
							$this->InfTablRow('Ligne',$erreur->getLine()).
							$this->InfTablRow('Backtrace',$erreur->getTraceAsString()).
							'</table>';
		else if(is_string($erreur))
			$body = htmlentities($erreur);
		$footer = '</fieldset><p>Si cette erreur persiste, contactez un administrateur.<br /><br />@SimpleFramework, tous droits réservés.</p>';
		die($header.$body.$footer);
	}
}

///Anti MagicQuotes
if(get_magic_quotes_gpc())
{
	foreach($_GET as $k => $v)
		$_GET[$k] = stripslashes($v);
	foreach($_POST as $k => $v)
		$_POST[$k] = stripslashes($v);
}

require(REP_RACINE.'Config/Config.class.php');
_includeSite(REP_RACINE);

try
{
	Site::instance()->load(REP_RACINE);
}
catch(Exception $e)
{
	$erreurHandler = null;
	if(class_exists('FatalErrorRender'))
		$erreurHandler = new FatalErrorRender($e);
	else
		$erreurHandler = new FatalErrorRenderBasic($e);
}
Site::instance()->timeMgr->markTime('Fin du fichier init.php');
?>