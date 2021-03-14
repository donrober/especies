<?php
	if ($_POST['regId'] == "" || $_POST['regId'] == -1)
	{
		crea();
	}	
	else
	{	
		if ($_POST['oper'] == "elimina")
		{	
			elimina();
		}
		elseif ($_POST['oper'] == "creaconmalestar")
		{
			creaconmalestar();
		}
		elseif ($_POST['oper'] == "actualiza")
		{
			actualiza();
		}	
	}

	function actualiza()
	{
		$regId = $_POST['regId'];
		$tratId = 0;

		if ($regId != "")
		{
			$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
			//echo 'Connected successfully';
			mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];

			$query = "update cat_tratamientos set nombre = '".$nombre."', ".
				"descripcion = '".$descripcion."' ".
				"where IdTratamiento = ".$regId;
		
			//Realizar una consulta MySQL
			$result = mysql_query($query) or die('Error al insertar en cat_tratamientos: ' . mysql_error());
			$tratId = mysql_insert_id();

			$query = "update ".$cat_ref." set IdTratamiento = ".
			"concat(IdTratamiento, ',".$tratId."') where IdMalestar = ".$regId;

			$result = mysql_query($query) or die('Error al actualizar en cat_malestares: ' . mysql_error());

			// Liberar resultados
			mysql_free_result($result);

			// Cerrar la conexión
			mysql_close($link);
		}		
	}

	function elimina()
	{
		$regId = $_POST['regId'];

		if ($regId != "")
		{
			$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
			//echo 'Connected successfully';
			mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

			$query = "DELETE FROM cat_tratamientos WHERE idTratamiento = ".$regId;
		
			//Realizar una consulta MySQL
			$result = mysql_query($query) or die('Error al eliminar: ' . mysql_error());

			// Liberar resultados
			mysql_free_result($result);

			// Cerrar la conexión
			mysql_close($link);
		}		
	}
	
	function creaconmalestar()
	{
		$catalogo = $_SERVER["HTTP_REFERER"];
		
		// Este llamado se hace desde cat_malestares		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

		$regId = $_POST['regId'];
		$tratId = 0;

		if ($regId != "")
		{
			$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
			//echo 'Connected successfully';
			mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];

			$query = "insert into cat_tratamientos(nombre, descripcion) ".
				"VALUES ".
				"('".$nombre."','".$descripcion."')";
		
			//Realizar una consulta MySQL
			$result = mysql_query($query) or die('Error al insertar en cat_tratamientos: ' . mysql_error());
			$tratId = mysql_insert_id();

			$query = "update ".$cat_ref." set IdTratamiento = ".
			"concat(IdTratamiento, ',".$tratId."') where IdMalestar = ".$regId;

			$result = mysql_query($query) or die('Error al actualizar en cat_malestares: ' . mysql_error());

			// Liberar resultados
			mysql_free_result($result);

			// Cerrar la conexión
			mysql_close($link);
		}		
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

		$query = "insert into ".$cat_ref."(nombre, descripcion) ".
			"VALUES ".
			"('".$nombre."','".$descripcion."')";
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al insertar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_tratamientos.php';</script>";
	}
?>
