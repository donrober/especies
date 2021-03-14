<?php 
	include("./dao/dao.php");
?>

<?php
	$regId = $_POST['regId'];
	$tipoConsulta = $_POST['consulta'];
	$script = "";
	$query = "";	
	
	if ($regId != "" || $regId > -1)
	{
		$db = new dao();

		if ($tipoConsulta == "datosmascota")
		{
			if ($db->connect())
			{
				$catalogo = $_SERVER["HTTP_REFERER"];
		
				$cat = substr($catalogo, 0, strpos($catalogo, "?"));
				if ($cat == "") {$cat = $catalogo;}
				$cat_ref = strrchr($cat, "/");		
				$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));
				
				$result = $db->select($cat_ref, "nombre, color, edad, altura, peso, idsubespecie, imagen, ancho, largo", 
					"idmascota=".$regId, null);

				while ($row = mysql_fetch_assoc($result)) 
				{
				    	$script = $row['nombre']."|".$row['color']."|".$row['edad']."|".$row['altura']."|".$row['peso']."|".$row['idsubespecie']."|".$row['imagen']."|".
						$row['ancho']."|".$row['largo'];
				}

				$db->disconnect();		

				// Liberar resultados
				mysql_free_result($result);			

				echo $script;
			}
			else
			{
				echo "<script language='javascript'>alert('No se puede conectar a la base de datos.');</script>";
			}			
		}
		elseif ($tipoConsulta = "taxonomia")
		{
			$query = "select c1.nombre as subespecie, c2.nombre as especie, c3.nombre as genero, ".
			"c4.nombre as familia, c5.nombre as orden, c6.nombre as clase, c7.nombre as filo, c8.nombre as reino ".
			"from cat_subespecies c1, cat_especies c2, cat_generos c3, ".
			"cat_familias c4, cat_ordenes c5, cat_clases c6, cat_filos c7, cat_reinos c8 ".
			"where c1.IdSubespecie = ".$regId. " ".
			"and c1.idsubespecie = c2.idsubespecie and c2.IdGenero = c3.IdGenero and c3.IdFamilia = c4.IdFamilia ".
			"and c4.IdOrden = c5.IdOrden and c5.IdClase = c6.IdClase and c6.IdFilo = c7.IdFilo ".
			"and c7.IdReino = c8.IdReino";			

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
		// mysql_close($link);
		mysql_close();
	}	
?>
