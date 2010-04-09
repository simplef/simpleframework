<?php
if(!defined('_IN'))
	exit();

class Singleton
{
	
	private function Singleton(){}
	
	
}

class Site extends Singleton
{
	//SINGLETON
	private static $instance;
	
	var $includeList = array();
	// = ceux donnés dans la config
	var $modelDir = '';
	var $vueDir = '';
	var $libDir='';
	
	var $repRacine = '';
	
	var $config = null;
	var $timeMgr = null;
	var $db = null;
	
	/*
	PUBLIC
	*/
	//Constructeur privé
	private function Site(){}
	public function load($repRacine='',$doNothing = false)
	{
		$this->repRacine = $repRacine;
		if(!defined('REP_RACINE'))
			define('REP_RACINE',$repRacine);
		if($doNothing)
			return;
		
		if(!$this->_loadConfig()) throw new Exception('Site:Site() - _loadConfig() failed');
		if(!$this->addLibFile('Chrono'))throw new Exception('Site:Site() - addModel(\'Chrono\') failed');
		if(!$this->_startTime())throw new Exception('Site:Site() - _startTime() failed');
		if(!$this->_loadDefaultClasses())	throw new Exception('Site:Site() - _loadDefaultClasses() failed for file '.$errClass);
		$this->timeMgr->markTime('Default classes loaded. Will connect to DB.');
		if($this->config->useDb()) //Utiliser la DB.
		{
			if(!$this->_connectDb())throw new Exception('Site:Site() - _connectDb() failed');
			$this->timeMgr->markTime('Connected to DB.');
		}
		Config::setConf($this->config);
	}

	//"destructeur"
	function end()
	{
		$this->db->close();
	}
	
	//SINGLETON
	//Acces au singleton
	function instance()
	{
		if (!isset(self::$instance)) 
		{
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
	}
	
	function config()
	{
		return Site::instance()->getConfig();
	}
	function baseUrl()
	{
		return $this->config->getSiteBaseUrl();
	}
	function error($err)
	{
		if($this->config->isDevMode())
			$render = new FatalErrorRenderBasic($err);
	}
	function outDebug($what)
	{
		if($this->config->isDevMode())
			echo '<p><em>[debug]</em>'.$what.'</p>';
	}
	//Copie non autorisée
	private function __clone()
	{
		trigger_error('Copie d\'une classe SigleTon non autorisée : '.__CLASS__, E_USER_ERROR);
	}
	
	function addModel($name,$isFullName=false)
	{
		return $this->includeFile($this->modelDir,($isFullName ? $name : $name.'.class.php'));
	}
	function addVue($name,$isFullName=false)
	{
		return $this->includeFile($this->vueDir,($isFullName ? $name : $name.'.class.php'));
	}
	function addLibFile($name,$isFullName=false)
	{
		return $this->includeFile($this->libDir,($isFullName ? $name : $name.'.class.php'));
	}
	function includeFile($path,$fileName)
	{
		if(in_array($path.$fileName,$this->includeList)) //Déja inclut
			return true;
			
		if(!@include($this->repRacine.$path.$fileName))
			return false;
			
		$this->includeList[] = $path.$fileName;
		return true;
	}
	
	function fatal($function,$erreur)
	{
		if($this->config->isDevMode())
		{
			die('<h1 style="color:red;">Fatal error</h1>
				L\'erreur suivante a eu lieu dans la fonction <strong>'.htmlentities($function).'</strong> :
				<fieldset><legend>Erreur rapportée</legend>
				<span style="color:red;">'.htmlentities($erreur).'</span>
				</fieldset>');
		}
	}
	/*
	ACCESSEURS
	*/
	function racine(){return Site::instance()->repRacine;}
	function favicon(){return $this->config->getFavicon();}
	function getNewRender() 
	{
		$pr = new PageRender($this->config->getTemplatesDir(),$this->config->getDefaultTemplateName());
		$pr->setMetas(array());
		return $pr;
	}
	function getExecTime()
	{
		return $this->timeMgr->diff();
	}
	function getSiteShortName()
	{
		return $this->config->getSiteShortName();
	}
	function debug(){return $this->config->isDevMode();}
	function getConfig(){return $this->config;}
	/*
	PRIVATE
	*/
	//LOADING FUNCTIONS
	function _loadConfig()
	{
		$this->config = getCurrentConfig();
		if(!is_a($this->config,'ConfigBase') || !is_subclass_of($this->config,'ConfigBase'))
			throw new Exception('La classe de configuration DOIT hériter de la classe Config.');
		if($this->config->isDevMode())
			@error_reporting(E_ALL);
			
		$this->modelDir = $this->config->getModelDir();
		$this->vueDir = $this->config->getVueDir();
		$this->libDir = $this->config->getLibDir();
		define('FULL_VUE_DIR',$this->racine().$this->config->getVueDir());
		define('SITE_SHORT_NAME',$this->config->getSiteShortName());
		return true;
	}
	function _startTime()
	{
		$this->timeMgr = new Chrono;
		$this->timeMgr->start();
		$this->timeMgr->markTime('Début compteur temps');
		return true;
	}
	function _loadDefaultClasses()
	{
		$libFiles = array('Html','HtmlElement','pageRender',
		'FormulaireElement','Formulaire',
		'Validator/all.php',
		'ArrayRender','ModelCreatorForm',
		'Debug','Visiteur','Cache','MySqlDatabase','MySqlResult','DbModel','ConfigAccessor');
		$defaultVue = array();
		$defaultModel = array();
		
		foreach($libFiles as $f)
		{
			if(!$this->addLibFile($f,(strpos($f,'.php') !== false)))
					throw new Exception('Impossible d\'inclure le fichier interne : '.htmlentities($f));
		}
		foreach($defaultVue as $v)
		{
			if(!$this->addVue($v,false))
				throw new Exception('Impossible d\'inclure la Vue '.htmlentities($v));
		}
		foreach($defaultModel as $v)
		{
			if(!$this->addModel($v,false))
				throw new Exception('Impossible d\'inclure le Model '.htmlentities($v));
		}	
		return true;
	}
	function _connectDb()
	{
		$this->db = new MySqlDatabase;
		if(!$this->db->connect($this->config->DbLogin(),$this->config->DbPass(),$this->config->DbHost()))
			throw new Exception('Impossible de se connecter à la base de données.');
		if(!$this->db->selectDb($this->config->DbName()))
			throw new Exception('Database inexistante.');
		return true;
	}
	
}

?>