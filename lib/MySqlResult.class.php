<?php

class MySqlResult
{
	/*
	______________________________________
	Attributs de la classe
	______________________________________
	*/
	var $dblink = null;
	/*
	______________________________________
	Méthodes publiques
	______________________________________
	*/
	//Constructeur,, initialisateur ...
	function MySqlResult(){} //Constructeur
	function load($dblink)
	{
		$this->dblink = $dblink;
		return true;
	}
}
class MySqlSelectResult extends MySqlResult
{
	/*
	______________________________________
	Attributs de la classe
	______________________________________
	*/
	var $numRows = 0;
	var $numFields = 0;
	var $result = null;
	/* Hérité :
	var $result = null;
	var $dblink = null;
	*/
	/*
	______________________________________
	Méthodes publiques
	______________________________________
	*/
	//Constructeur,, initialisateur ...
	function MySqlSelectResult(){} //Constructeur
	function loadFromResult($mysqlresult,$dblink)
	{
		$this->numRows = @mysql_num_rows($mysqlresult);
		$this->numFields = @mysql_num_fields($mysqlresult);
		$this->result = $mysqlresult;
		return parent::load($dblink);		
	}
	
	function fetch()
	{
		return @mysql_fetch_array($this->result);
	}
	function fetchAll($arrayKey=null)
	{
		if(!@mysql_data_seek($this->result,0))
			return false;
		
		$allData = array();
		while($data = $this->fetch())
		{
			if(!$arrayKey)
			{
				$allData[] = $data;
				continue;
			}
			else
			{
				if(!isset($data[$arrayKey]))
					return false;
				$allData[$data[$arrayKey]] = $data;
			}
		}
		return $allData;
	}

}

class MySqlModificationInfos extends MySqlResult
{
	var $affectedRows = 0;
	function MySqlModification(){} //Constructeur
	function load($dblink)
	{
		$this->affectedRows = @mysql_affected_rows($dblink);
		return parent::load($dblink);		
	}
}
class MySqlInsertInfos extends MySqlResult
{
	var $id = 0;
	var $affectedRows = 0;
	function MySqlModification(){} //Constructeur
	function load($dblink)
	{
		$this->id = @mysql_insert_id($dblink);
		$this->affectedRows = @mysql_affected_rows($dblink);
		return parent::load($dblink);		
	}
}
?>