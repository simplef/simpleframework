<?php

$changelog = array(
	'0.0.1' => 
	array('Premiere version' => array(),
		'Mise en place de Smarty' => array(),
		'Mise en place de JQuery' => array(),
		'Classes de base de gestion de bdd' => array()),
	
	'0.0.2' => 
	array('Mise en place de cette page' => array()),
	
	'0.0.3' => 
	array('Mise en place des modeles de DB' => array()),
	
	'0.0.4' => 
	array('Création de la classe Debug' => array(),
		'Mise en place d\'une gestion facilitée des formulaires (partie 1/2)' => array()),
	
	'0.0.5' => 
	array('La classe Site est un Singleton.'  => array('Fonctions Site::config() et Site::instance()')),
	
	'0.0.6' => 
	array('Gestion du cache de Smarty dans la classe PageRender' => array(),
		'Affichage des changements sur la page d\'installation'=>array('Affichage de sous changements'),
		'Classe Config pour acceder de partout a la configuration' => array('Exemple : Config::isDevMode()'),
		'Classe Debug améliorée' => array('Debug::dump()','Debug::out()')),
	'0.0.7' =>
	array('Ajout de validateurs pour les formulaires [1/2]' => array('StringValidator','NotNullValidator'),
	'Affichage correct des erreurs' => array('cf : form.test.php')),
	'0.1' =>
	array('Premiere version stable ! :)' => array(),
	'Possibilite d\'ajouter des variables persos plus simplement aux template'
		=> array('Vue/Template.php : AddTemplateCustomVars($obj, $isCached)'),
	'Passage a GIT' => array('Repo heberge sur github.com','Les changements mineurs seront indiques la bas.'),
	'Plus besoin de faire un define(\'_IN\') au debut de chaque fichier. C\'est fait dans init.php' => array(),
	'Deplacement des test dans un repoertoire Test/' => array(),
	'"Securisation" avec des .htaccess et un index.html dans le dossier CSS.' => array())
);
?>