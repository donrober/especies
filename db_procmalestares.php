<?php
	if ($_POST['regId'] == "" || $_POST['regId'] == -1)
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
		$descripcion = $_POST['descripcion'];
		$idsTratamientos = $_POST['regTratsId'];

		$idsubespecie = ($_POST['subespecie'] == "" ? $_POST['subId'] : $_POST['subespecie']);

		$idsTratamientos = limpiarepetidos(",", $idsTratamientos);	
		
		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		$query = "update ".$cat_ref." set descripcion = '".$descripcion."', ".
			"IdTratamiento = '".$idsTratamientos."', idsubespecie = ".$idsubespecie." ".
			"where IdMalestar = ".$regId;
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al actualizar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_malestares.php';</script>"; 
	}

	function crea()
	{
		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));		
		
		$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
		//echo 'Connected successfully';
		mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcion'];

		$idsTratamientos = $_POST['regTratsId'];

		$idsTratamientos = limpiarepetidos(",", $idsTratamientos);

		$idsubespecie = ($_POST['subespecie'] == "" ? $_POST['subId'] : $_POST['subespecie']);

		$query = "insert into ".$cat_ref."(nombre, descripcion, IdTratamiento, idsubespecie) ".
			"VALUES ".
			"('".$nombre."','".$descripcion."', '".$idsTratamientos."', ".$idsubespecie.")";
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al insertar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_malestares.php';</script>";
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
