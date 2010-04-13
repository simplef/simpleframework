<?php
include('init.php');
include('changes.php');
$pr = Site::instance()->getNewRender();
$pr->useCache('index',100);
if($pr->afficherSiCache())
{
}
else
{
	$pr->setVar('changelog',$changelog);
	$pr->setVar('templateHtml',htmlentities(file_get_contents('Templates/default/index_example.tpl')));
	$pr->afficher('index');
}
?>
