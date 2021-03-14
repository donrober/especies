<?php
	// 0 = Crea; X = Actualiza	
	if ($_POST['regId'] == -1)
	{
		crea();
	}
	else
	{	
		actualiza();
	}
	
	function actualiza()
	{
		$regId = $_POST['regId'];
		$otrosnombres = $_POST['otrosnombres'];
		$descripcion = $_POST['descripcion'];
		$ubicacion = $_POST['regmultiubics'];
		$malestar = $_POST['regmultiusos'];
		$problema = $_POST['regmultiproblemas'];
		$idEspecie = $_POST['padre'];	

		$ubicacion = limpiarepetidos(",", $ubicacion);
		$malestar = limpiarepetidos(",", $malestar);
		$problema = limpiarepetidos(",", $problema);

		$target_path = "uploads/";

		$target_path = $target_path.basename($_FILES['img']['name']);
		
		if(move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) 
		{
		    	echo "The file ".basename( $_FILES['img']['name'])." has been uploaded";
		} 
		else
		{
		    	echo "There was an error uploading the file, please try again!";
			$target_path = $_POST['imagen'];
		}

		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		$query = "update ".$cat_ref." set otros_nombres = '".$otrosnombres."', ".
			"descripcion = '".$descripcion."', ".
			"imagen = '".$target_path."', ".
			"IdUbicacion = '".$ubicacion."', ".
			"IdMalestar = '".$malestar."', ".
			"IdProblema = '".$problema."', ".
			"IdEspecie = '".$idEspecie."' ".
			"where IdSubespecie = ".$regId;
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al actualizar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_subespecies.php';</script>"; 
	}
	
	function crea()
	{
		$target_path = "uploads/";

		$target_path = $target_path.basename($_FILES['img']['name']);
		
		if(move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) 
		{
		    echo "The file ".basename( $_FILES['img']['name'])." has been uploaded";
		} 
		else
		{
		    echo "There was an error uploading the file, please try again!";
		}

		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

		$nombre = $_POST['nombre'];
		$otrosnombres = $_POST['otrosnombres'];
		$descripcion = $_POST['descripcion'];
		$ubicacion = $_POST['regmultiubics'];
		$malestar = $_POST['regmultiusos'];
		$problema = $_POST['regmultiproblemas'];
		$idEspecie = $_POST['padre'];

		$ubicacion = limpiarepetidos(",", $ubicacion);
		$malestar = limpiarepetidos(",", $malestar);
		$problema = limpiarepetidos(",", $problema);			
		
		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		$query = "insert into ".$cat_ref."(nombre, otros_nombres, descripcion, imagen, IdUbicacion, IdMalestar, IdProblema, IdEspecie) ".
			"VALUES ".
			"('".$nombre."','".$otrosnombres."','".$descripcion."','".$target_path.
			"','".$ubicacion."','".$malestar."','".$problema."', '".$idEspecie."')";
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al insertar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_subespecies.php';</script>";
	}

	function limpiarepetidos($pDelimitador, $pCadena)
	{
		$valores = explode($pDelimitador, $pCadena);
		$limpios = array();
		$limpia = "";

		foreach ($valores as $valor)
		{			
			if (!in_array(trim($valor), $limpios))
			{
				array_push($limpios, trim($valor));
			}
		}

		foreach ($limpios as $valor)
		{
			if ($valor != "")
			{
				if (strlen($limpia) > 0)
				{
					$limpia .= ",";
				}
			
				$limpia .= $valor;
			}					
		}
		
		return $limpia;
	}
?>
