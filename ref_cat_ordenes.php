<?php
	$regId = $_POST['regId'];
	$script = "";
	$query = "";
		
	if ($regId != "")
	{
		$query = "select * from cat_ordenes where IdOrden=".$regId;
		
		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
		    	$script = $row['nombre']."|".$row['descripcion']."|".$row['IdClase'];
		}		

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo $script;
	}	
?>
