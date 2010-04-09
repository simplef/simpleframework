<?php

function is_assoc($var)
{
        return is_array($var) && array_diff_key($var,array_keys(array_keys($var)));
}

class MySqlDatabase
{
	/*
	______________________________________
	Attributs de la classe
	______________________________________
	*/
	var $dblink = null;
	var $dbname = null;
	var $queryList = array();
	var $queryCount = 0;
	
	var $debug = false;
	/*
	______________________________________
	Méthodes publiques
	______________________________________
	*/
	//Constructeur, connection, db, erreurs ...
	function MySqlDatabase($debug = false){$this->debug=$debug;} //Constructeur
	function connect($username='root',$pass='',$host='localhost')
	{
		$this->dblink = @mysql_connect($host,$username,$pass);
		if(!$this->dblink)
			return false;
		return true;
	}
	function selectDb($dbname)
	{
		$this->dbname = $dbname;
		return @mysql_select_db($dbname,$this->dblink);
	}
	function close()
	{
		return mysql_close($this->dblink);
	}
	function lastError()
	{
		return @mysql_error($this->dblink);
	}
	function lastId()
	{
		return @mysql_insert_id($this->dblink);
	}
	
	//Différentes requetes possibles ...
	function select($fields,$tableNameOrTablesList,$where=null,$limitMin=null,$limitMax=null)
	{
		//SELECT a,b,c
		$qry = $this->_buildSelectQuery($fields,$tableNameOrTablesList,$where,$limitMin,$limitMax);
		
		//Requete & renvoi du résultat
		$result = null;
		if($result = $this->_query($qry)) //Pas d'erreur
		{
			$this->_countQuery('SELECT',$qry);
			$retour = new MySqlSelectResult();
			if(!$retour->loadFromResult($result,$this->dblink)) //?
				return false;
			return $retour;
		}
		else
			return false;
		
	}
	/*
	array(
	'field' => 'value'
	);
	*/
	function update($table,$newValues,$where=null,$limit=null)
	{
		$qry = $this->_buildUpdateQuery($table,$newValues,$where,$limit);
		
		//Requete & renvoi du résultat
		if($this->_query($qry)) //Update bien effectué
		{
			$this->_countQuery('UPDATE',$qry);
			$result = new MySqlModificationInfos;
			if($result->load($this->dblink))
				return $result;
			else
				return null;
		}
		else
			return false;
		
	}
	
	function delete($table,$where=null,$limit=null)
	{
		$qry = $this->_buildDeleteQuery($table,$where,$limit);
		
		//Requete & renvoi du résultat
		if($this->_query($qry)) //Update bien effectué
		{
			$this->_countQuery('DELETE',$qry);
			$result = new MySqlModificationInfos;
			if($result->load($this->dblink))
				return $result;
			else
				return null;
		}
		else
			return false;
		
	}
	
	function insert($table,$values)
	{
		$qry = $this->_buildInsertQuery($table,$values);
		
		//Requete & renvoi du résultat
		if($this->_query($qry)) //Update bien effectué
		{
			$this->_countQuery('INSERT',$qry);
			$result = new MySqlInsertInfos;
			if($result->load($this->dblink))
				return $result;
			else
				return null;
		}
		else
			return false;
		
	}
	
	//SECURITE
	function quote($str)
	{
		return '"'.mysql_real_escape_string($str).'"';
	}
	/*
	______________________________________
	Méthodes privées
	______________________________________
	*/
	function _query($qry)
	{
		if(Site::instance()->debug())
			echo 'Requete MySql : '.htmlentities($qry);
		return @mysql_query($qry,$this->dblink);
	}
	
	function _countQuery($type,$qry)
	{
		$this->queryList[] = $qry;
		$this->queryCount++;
	}
	function _buildSelectQuery($fields,$tableNameOrTablesList,$where=null,$limitMin=null,$limitMax=null)
	{
		//SELECT a,b,c
		$qry = $this->_buildSelectExp($fields);
		if(!$qry) return false;
			
		//FROM tablNames
		$qry .= ' '.$this->_buildFromExp($tableNameOrTablesList);

		//WHERE
		if($where != null) //WHERE existe
			$qry .= $this->_buildWhereExp($where);
			
		return $qry;
	}
	function _buildUpdateQuery($table,$newValues,$where,$limit)
	{
		/*
		UPDATE table
		SET a=1,b=2
		WHERE b=2 AND c=4
		TODO : Support multi table update
		*/
		$qry = 'UPDATE '.$table.' SET '.$this->_buildSetList($newValues);
			$qry .= $this->_buildWhereExp($where);
		if($limit)
			$qry .= 'LIMIT '.intval($limit);
			
		return $qry;
	}
	function _buildDeleteQuery($table,$where,$limit)
	{
		$qry = 'DELETE FROM '.$table.' '.$this->_buildWhereExp($where);
		if($limit != 0 && is_int($limit))
			$qry .= ' LIMIT '.$limit;
		return $qry;
	}
	function _buildInsertQuery($table,$values)
	{
		return 'INSERT INTO '.$table.' SET '.$this->_buildSetList($values);
	}
	function _buildSelectExp($fieldNameOrFieldsList)
	{
		if($datalist = $this->_buildDataList($fieldNameOrFieldsList))
			return 'SELECT '.$datalist;
		else
			return null;
	}
	function _buildWhereExp($where)
	{
		if($datalist = $this->_buildDataList($where,' AND '))
			return 'WHERE '.$datalist;
		else
			return '';
	}
	function _buildFromExp($tableNameOrTablesList)
	{
		if($datalist = $this->_buildDataList($tableNameOrTablesList))
			return 'FROM '.$datalist;
		else
			return '';
	}
	function _buildSetList($newValues)
	{
		
		if(is_assoc($newValues))
		{
			$qry = '';
			$first = true;
			foreach($newValues as $field => $val)
			{
				if($first == false)
					$qry .= ',';
				$qry .= $field.'='.$this->quote($val).' ';
				$first = false;
			}
			return $qry;
		}
		elseif(is_array($newValues))
		{
			$qry = '';
			$first = true;
			foreach($newValues as $modifier)
			{
				if($first == false)
					$qry .= ',';
				$qry .= $modifier.' ';
				$first = false;
			}
			return $qry;
		}
		else
			return $newValues;
	}
	function _buildDataList($values,$between=',')
	{
		if($values != null) //WHERE existe
		{
			if(is_array($values)) //Cas 1
			{
				$one = false;
				foreach($values as $exp)
				{
					if($one == true) //Déja un where avant
						$ret .= $between;

					$ret .= $exp;
					$one = true;
				}
				return $ret;
			}
			else //Cas 2
				return $values;
			
		}
		else //Cas 3
			return null;
	}
}

?>