<?php 
//Ne peux pas utiliser Config:: ici (espace global). Pas encore chargé.
define('SMARTY_DIR', Site::racine().Site::instance()->config->getLibDir().'Smarty/'); 
require(SMARTY_DIR . 'Smarty.class.php'); 


class PageRender extends Smarty 
{ 
	var $templateDir = ''; 
	var $templateName = '';
	var $filArianeArray = -1;
	var $cacheId = '';
	
	var $page = '';
	
	function __construct($tplDir,$tplDefault)
	{
		if($tplDefault == '')
			throw new Exception('Erreur d\'arguments dans le constructeur de PageRender.');
		$this->templateDir = $tplDir;
		$this->templateName = $tplDefault;
	}
	function setTemplateName($tplName) 
	{
		$this->templateName = $tplName; 
	}
	/*
	##################################
	# Systeme de cache
	##################################
	*/
	function useCache($cacheId='',$cacheTime=3600)
	{
		if(Config::isDevMode())
			return false;
		$this->compile_check = false;
		$this->caching = 2; //1 durée de cache / fichier
		$this->cache_lifetime = $cacheTime;
		$this->cacheId = $cacheId;
		$this->refreshCacheDir();
		return true;
	}
	function refreshCacheDir()
	{
		$dirTmp = Site::racine().Config::getCacheDir().'Smarty/'.$this->templateName.'/';
		if(!is_dir($dirTmp))
		{
			if(!mkdir($dirTmp,0777,true))
			{
				Site::error('Impossible de creer le dossier de cache : '.$dirTmp);
				return false;
			}
		}
				
		$this->cache_dir = $dirTmp;
		return true;
	}
	function isCached()
	{
		if(!$this->refreshCacheDir())
		{
			Debug::out('pageRender::isCached() : Impossible de rafraichir le dossier de cache. Mauvaise utilisation ?');
			return false;
		}
		$page = 'page'.Config::getTemplateExt();
		return $this->is_cached($page, $this->cacheId);
	}
	
	function clearAllCache()
	{
		$this->clear_all_cache();
	}
	
	function getPref()
	{
		return Config::getSiteBaseUrl();
	}
	
	/*
	##################################
	# Fonction utilisées avant la génération
	##################################
	*/
	function setMetas($metas = array())
	{
		$defaultMetas = array('Robots'=>'all');
		$finalMetas = array_merge($defaultMetas,$metas);
		$metas = '';
		foreach($finalMetas as $name => $content)
			$metas .= '<meta name="'.$name.'" content="'.htmlentities($content).'" />';
		$this->setVar("meta",$metas);
	}

	function setCssDir()
	{
		$dir = $this->getPref().$this->templateDir."css/".$this->templateName.'/';
		$this->setVar("cssDirectory",$dir);
	}

	function setFavicon()
	{
		$this->setVar('favicon',Site::instance()->favicon());
	}


	function setCurrentTemplate()
	{
		$this->setVar('currentTemplate',$this->templateName );
	}
	
	
	function setRacine()
	{
		$this->setVar('racine',$this->getPref());	
	}
	
	function setExecTime()
	{
		$this->setVar('generateTime',Site::instance()->getExecTime());
	}
	
	function setFil()
	{
		if($this->filArianeArray == -1) //Pas de fil
		{
			$this->setVar('filArianeActive',false);
			return;
		}
		
		//Fil Ok
		$this->setVar('filArianeActive',true);
		$this->setVar('filAriane',$this->filArianeArray);
	}
	
	function setPub()
	{

	}
	/*End*/
	
	/*
	##################################
	# Fil d'ariane
	##################################
	*/
	function fil_add($url,$txt)
	{
		if($this->filArianeArray == -1)
		{
			$this->filArianeArray = array();
			$this->filArianeArray[SITE_SHORT_NAME] = $this->getPref() == '' ? './' : $this->getPref();
		}
		$this->filArianeArray[$txt] = $this->getPref().$url;
	}	
	
	function setVar($n,$v)
	{
		$this->assign($n,$v);
	}
	
	/*
	##################################
	# Afficher
	##################################
	*/
	function afficher($name)
	{
		//Gestion du cache
		$this->page = $name;
		$fileName = $name.'.tpl';
		ob_start();

		$this->template_dir = Site::racine().$this->templateDir.$this->templateName; 
		$this->compile_dir = Site::racine().$this->templateDir.$this->templateName.'/c/'; 

		if(defined('TPL_TITLE'))
			$this->setVar('titre',TPL_TITLE);
		else
			$this->setVar('titre','');

		//Definition de variables génériques
		$this->setVar('pageName',$fileName);
		
		// Modifier ici (et dans le template) pour définir le titre.
		// ... Ou bien dans AddTemplateCustomVars()
		$this->setMetas();
		$this->setCssDir();
		$this->setFavicon();
		$this->setRacine();
		$this->setExecTime();
		$this->setPub();
		$this->setFil();
		$this->setVar('racine',$this->getPref());
		$this->setVar('site_short_name',Config::getSiteShortName());
		
		// Variables personnalisées, pour l'utilisateur
		AddTemplateCustomVars($this, false);
		
		if($this->cacheId!='')
			$this->display('page.tpl',$this->cacheId);
		else
			$this->display('page.tpl');
		ob_end_flush();
	}
	function afficherSiCache()
	{
		if($this->cacheId!='' && $this->isCached())
		{		// Disponible en cache
			AddTemplateCustomVars($this, true);
			$this->display('page.tpl',$this->cacheId); 
			return true;
		}
			// Non disponible
		return false;
	}
	
	/*
	##################################
	# Utilisation simple sans template pour la page
	##################################
	*/
	function renderHtml($html)
	{
		$this->setVar('htmlContent',$html);
		$this->afficher('render_html');
	}

};
?>
