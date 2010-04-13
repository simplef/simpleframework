<?php
define('_IN',true);
include('init.php');

class SiteModel extends DbModel
{
	function __construct()
	{
		parent::__construct(Site::instance()->db,'sites',array('site_id','site_name','site_description'));
	}

}

$pr = Site::instance()->getNewRender();
$m = new SiteModel;
$values = array(
	'site_name' => 'sdf',
	'site_description' => 'SansDomFixe'
	);
//$m->db->insert('sites',$values);
mysql_query('INSERT INTO sites SET site_name="sdf", site_description="SansDomFixe"',$m->db->dblink);
//$m->insertNew();
$pr->renderHtml('<h1>Page de test de la classe DbModel</h1>');
?>