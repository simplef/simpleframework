<?php
include('MySqlDatabase.class.php');
include('MySqlResult.class.php');

echo '<ul>';

function output($str,$ok=true,$die=false)
{
	if($ok)
		echo '<li style="color:green;">'.htmlentities($str).'</li>';
	else
		echo ('<li style="color:red;">'.htmlentities($str).'</li>');
	if($die)
		exit;
}

function doCheck($cond,$txt,$die=false)
{
	if($cond)
		output($txt.' -- [OK]',true);
	else
		output($txt.' -- [ERREUR]',false,$die==true);
}

$resultat = '';
$db = new MySqlDatabase(true);

doCheck($db->connect(),'Connection',true);

doCheck($db->selectDb('dbteste'),'Selection de la DB');


if($resultat = $db->select(array('id','field1','field2'),'test1',null,0,2))
	output('Requete executée');
else
	output('Requete échouée',false);
if($data = $resultat->fetchAll())
	output('1 - $data = $resultat->fetchAll() [OK]');
else
	output('1 - $data = $resultat->fetchAll() [ERREUR]',false);
if($data = $resultat->fetchAll('name'))
	output('2 - $data = $resultat->fetchAll(name) [OK]');
else
	output('2 - $data = $resultat->fetchAll(name) [ERREUR]',false);

if($db->update('characters',array('name="admina"','level=80'),array('guid=4')))
	output('Update OK');
else
	output('Update : erreur',false);
	
	
echo '</ul>';	
?>