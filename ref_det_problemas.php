<?php
	$regId = $_POST['regId'];
	$script = "";
	$query = "";
	$ids="";

	if ($regId != "")
	{

		$query = "select IdSolucion from cat_problemas where IdProblema=".$regId;

		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida cat_problemas: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
			if (strlen($ids) > 0)
			{
				$ids .= ",";
			}
			
			$ids .= $row['IdSolucion'];
		}
		
		$query = "select * from cat_soluciones where IdSolucion in (".$ids.")";
		$query = str_replace(",)", ")", str_replace("(,", "(", $query));
		
		// Realizar una consulta MySQL
		$result = mysql_query($query) or die('Consulta fallida cat_soluciones: ' . mysql_error());
		// Imprimir los resultados en HTML
		
		while ($row = mysql_fetch_assoc($result)) 
		{
		    	$script .= "<p><input type='button' id='btnDet".$row['IdTratamiento'].
			"' name='btnDet".$row['IdTratamiento']."' onclick=\"{reemplazar_ids}; elimina_detalle(".$row['IdTratamiento'].
			"); \" value='Elimina' /> ".$row['nombre']." --- ".$row['descripcion'].
			"&nbsp;&nbsp;&nbsp;<input type='button' value='Editar' id='btnEditaTrata".$row['IdTratamiento'].
			"' name='btnEditaTrata".$row['IdTratamiento']."' onclick=\"edita_detalle(".$row['IdTratamiento'].
			", '".$row['nombre']."', '".$row['descripcion']."');\" /></p>";
		}	

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		$script = str_replace("{reemplazar_ids}", "document.getElementById('regTratsId').value='".$ids."'", $script);

		echo $script;
	}	
?>
