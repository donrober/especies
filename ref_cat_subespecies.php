<?php
	$regId = $_POST['regId'];
	$tipoConsulta = $_POST['consulta'];
	$script = "";
	$query = "";
		
	if ($regId != "" || $regId != -1)
	{
		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
			mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		if ($tipoConsulta == "datossubespecie")
		{
			$query = "select * from cat_subespecies where IdSubespecie=".$regId;			

			// Realizar una consulta MySQL
			$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
			// Imprimir los resultados en HTML
		
			while ($row = mysql_fetch_assoc($result)) 
			{
			    	$script = $row['nombre']."|".$row['otros_nombres']."|".$row['descripcion']."|"
				.$row['imagen']."|".$row['IdUbicacion']."|".$row['IdMalestar']."|".$row['IdProblema']."|".$row['IdEspecie'];
			}		

			// Liberar resultados
			mysql_free_result($result);			

			echo $script;
		}
		elseif ($tipoConsulta = "taxonomia")
		{
			$query = "select concat(c3.nombre, ' ', c2.nombre, ' ', c1.nombre) as subespecie, concat(c3.nombre, ' ', c2.nombre) as especie, c3.nombre as genero, ".
			"c4.nombre as familia, c5.nombre as orden, c6.nombre as clase, c7.nombre as filo, c8.nombre as reino ".
			"from cat_subespecies c1, cat_especies c2, cat_generos c3, ".
			"cat_familias c4, cat_ordenes c5, cat_clases c6, cat_filos c7, cat_reinos c8 ".
			"where c1.IdSubespecie = ".$regId. " ".
			"and c1.IdEspecie = c2.IdEspecie and c2.IdGenero = c3.IdGenero and c3.IdFamilia = c4.IdFamilia ".
			"and c4.IdOrden = c5.IdOrden and c5.IdClase = c6.IdClase and c6.IdFilo = c7.IdFilo ".
			"and c7.IdReino = c8.IdReino order by c3.nombre, c2.nombre, c1.nombre";			

			// Realizar una consulta MySQL
			$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
			// Imprimir los resultados en HTML
		
			while ($row = mysql_fetch_assoc($result)) 
			{
			    	$script = "Subespecie: ".$row['subespecie']."<br/>".
				"Especie: ".$row['especie']."<br/>".
				"Genero: ".$row['genero']."<br/>".
				"Familia: ".$row['familia']."<br/>".
				"Orden: ".$row['orden']."<br/>".
				"Clase: ".$row['clase']."<br/>".
				"Filo: ".$row['filo']."<br/>".
				"Reino: ".$row['reino'];
			}		

			// Liberar resultados
			mysql_free_result($result);			

			echo $script;
		}		
		
		// Cerrar la conexión
		mysql_close($link);
	}	
?>
