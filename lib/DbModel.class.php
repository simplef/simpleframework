<?php

class DbModel
{
	var $db = null;
	var $tblName = null;
	var $myWhere = null;
	var $fields = null;
	var $values = null;
	
	function __construct($db,$tablName,$fields,$values = array())
	{
		$this->values = array();
		$this->db = $db;
		$this->tblName = $tablName;
		$this->fields = $fields;
		$this->values = $values;
	}
	
	function find($whereClause)
	{
		$this->myWhere = null;
		$this->values = null;
		
		$result = $this->db->select($this->fields,$this->tblName,$whereClause,0,1);
		if(!$result)
			return false;
		$this->myWhere = $whereClause;
		$row = $result->fetch();
		foreach($this->fields as $fieldName)
		{
			if(isset($row[$fieldName])) //Champ dans le résultat recu
				$this->values[$fieldName] = $row[$fieldName];
		}
		return true;
	}
	
	function getAll($where = null)
	{
		$this->myWhere = null;
		$this->values = null;
		
		$result = $this->db->select($this->fields,$this->tblName,$where);
		if(!$result)
			return false;
		$retur = array();
		while($row = $result->fetch())
		{
			$retur[] = $row;
		}
		return $retur;
	}
	
	function setValue($what,$newVal)
	{
		return $this->update(array($what => $newVal));
	}
	
	function getValue($what)
	{
		return $this->values[$what];
	}
	
	function __get($name)
	{
		if(isset($this->{$name}))
			return $this->{$name};
		if(isset($this->fields[$name]))
			return getValue($name);
		return false;
	}
	
	function update($newValues,$force = false)
	{
		$where = $this->getMyWhere();
		if(!$where && !$force)
			return false;
			
		$this->db->update($this->tblName,$newValues,$this->getMyWhere(),1);
		//MaJ en interne
		foreach($this->fields as $fieldName)
		{
			if(isset($newValues[$fieldName]))
				$this->values[$fieldName] = $newValues[$fieldName];
		}
		return true;
	}
	
	function delete($force = false)
	{
		$where = $this->getMyWhere();
		if(!$where && !$force) // /!\ Supprimer tout !!  (Mais il y a une limite :p)
			return false;
			
		$this->db->delete($this->tblName,$this->getMyWhere(),1);
		return true;
	}
	function insertNew($values)
	{
		echo var_dump($values);
		$this->db->insert($this->tblName,$values);
		$this->values = $values;
		$this->myWhere = $values;
	}
	
	private function getMyWhere()
	{
		return $this->myWhere;
	}

}
?>