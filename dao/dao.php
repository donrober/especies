<?php

class dao
{
	private $db = NULL;
	private $connection_string = NULL;
	private $db_host = "127.0.0.1:3306";        
	private $db_user = "root";        
	private $db_pass = "sqlero";        
	private $db_name = "subespecies";        
	private $con = false;
	private $result = array();
	 
	public function connect()
	{
		if(!$this->con)
		{
			try 
			{
			    	$this->db = mysql_connect($this->db_host, $this->db_user, $this->db_pass) 
					or die('No se pudo conectar: ' . mysql_error());
				//echo 'Connected successfully';
				$this->db = mysql_select_db($this->db_name) or die('No se pudo seleccionar la base de datos');
			    	$this->con = true;
			}
			catch (Exception $e)
			{
				echo "script language='javascript>alert('".$e."');</script>";
			    	$this->con = false;
			}
		}
		
		return $this->con; //already connected, do nothing and show true
	}

	public function disconnect()
	{
		if($this->con)
		{
			//mysql_close($this->db);
			unset($this->db);
			$this->con = false;
			return true;
		}
	}	

	public function selectddl($pTable, $pRows = '*', $pWhere = null, $pOrder = null)
	{
		$q = 'select 0 as regId, \'(Selecciona) \' as Valor union SELECT '.$pRows.' FROM '.$pTable;

		if($pWhere != null)
			$q .= ' WHERE '.$pWhere;
	    	if($pOrder != null)
			$q .= ' ORDER BY '.$pOrder;
			
			//echo $q;

	    	$this->numResults = null;

		try 
		{
	    		$this->result = mysql_query($q) or die('Consulta fallida: ' . mysql_error());
	    		$this->numResults = count($this->result);
	    		$this->numResults === 0 ? $this->result = null : true ;
	    		return $this->result;
	    	}
	    	catch (PDOException $e)
	    	{
			return $e->getMessage();
		}
	}

	public function select($pTable, $pRows = '*', $pWhere = null, $pOrder = null)
	{
		$q = 'SELECT '.$pRows.' FROM '.$pTable;

		if($pWhere != null)
			$q .= ' WHERE '.$pWhere;
	    	if($pOrder != null)
			$q .= ' ORDER BY '.$pOrder;
					
			$this->numResults = null;

		try 
		{
	    		$this->result = mysql_query($q) or die('Consulta fallida: ' . mysql_error());
	    		$this->numResults = count($this->result);
	    		$this->numResults === 0 ? $this->result = null : true ;
	    		return $this->result;
	    	}
	    	catch (PDOException $e)
	    	{
			return $e->getMessage();
		}
	}

	public function update($pTable, $pRows, $pValues, $pWhere)
	{
		$q = 'UPDATE '.$pTable.' SET ';
		$rows = split(",", $pRows);
		$i = 0;

		foreach ($rows as $row => $value) 
		{			
			$q .= $value.' = '.$pValues[$i];			
			$i += 1;
			if ($i != count($pValues)) {$q .= ', ';}
		}

		$q .= ' WHERE '.$pWhere;
		
		try 
		{
	    		$result = mysql_query($q) or die('Error al actualizar: ' . mysql_error());
	    		return true;
	    	}
	    	catch (PDOException $e)
	    	{
			return $e->getMessage();
		}
	}

	public function insert($pTable, $pRows, $pValues)
	{
		$q = 'INSERT INTO '.$pTable.'('.$pRows.') VALUES ('.$pValues.')';		
		
		$this->numResults = null;

		try 
		{
	    		$result = mysql_query($q) or die('Error al insertar: ' . mysql_error());
	    		return true;
	    	}
	    	catch (PDOException $e)
	    	{
			return $e->getMessage();
		}
	}

	public function getResult()
	{
		// code
	}
}

?>
