<?php
	$regId = $_POST['regId'];
	$subId = $_POST['subId'];
	$script = "";
	$query = "";
		
	if ($regId != "-1")
	{
		$query = "select * from cat_malestares where IdMalestar=".$regId;
		
		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
		    	$script = $row['nombre']."|".$row['descripcion']."|".str_replace(",,", ",", $row['IdTratamiento']);
		}		

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo $script;
	}

	if ($subId != "-1")
	{
		$query = "select IdMalestar from cat_subespecies where IdSubespecie=".$subId;

		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida cat_malestares: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
			if (strlen($ids) > 0)
			{
				$ids .= ",";
			}
			
			$ids .= $row['IdMalestar'];
		}
		
		$query = "select * from cat_malestares where IdMalestar in (".$ids.")";
		$query = str_replace(",)", ")", str_replace("(,", "(", $query));
		
		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida cat_tratamientos: ' . mysql_error());
		// Imprimir los resultados en HTML

		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
			if ($script != "")
			{
				$script .= "|";
			}
		    	$script .= $row['IdMalestar'].",".$row['nombre'];
		}		

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo $script;
	}	
?>
