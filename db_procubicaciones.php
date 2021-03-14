<?php
	if ($_POST['regId'] == "")
	{
		crea();
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

		$nombre = $_GET['nombre'];
		$coordenadas = $_GET['coordenadas'];

		$query = "insert into ".$cat_ref."(nombre, coordenadas) ".
			"VALUES ".
			"('".$nombre."','".$coordenadas."')";
		
		//Realizar una consulta MySQL
		$result = mysql_query($query) or die('Error al insertar: ' . mysql_error());

		// Liberar resultados
		mysql_free_result($result);

		// Cerrar la conexión
		mysql_close($link);

		echo "<script language='javascript'>top.document.location='cat_ubicaciones.php';</script>";
	}
?>
