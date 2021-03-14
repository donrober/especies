<?php 
	include("./dao/dao.php");
?>

<?php
	// 0 = Crea; X = Actualiza
	if ($_POST['regTId'] == -1)
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
		$regTId = $_POST['regTId'];
		$regDetId = $_POST['regDetId'];
		
		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));
		
		$fecha = $_POST['fecha'];
		$provision = $_POST['provision'];
		$observaciones = $_POST['observaciones'];
		
		$parametros = array();
		array_push($parametros, "DATE_FORMAT('".trim($fecha)."','%d/%m/%y')");
		array_push($parametros, "'".trim($provision)."'");
		array_push($parametros, "'".trim($observaciones)."'");
		array_push($parametros, trim($regId));
		array_push($parametros, trim($regDetId));
		
		$db = new dao();
	
		if ($db->connect() && is_numeric($regId))
		{
			$db->update($cat_ref, "fecha,provision,observaciones,idmascota,idcuidado", $parametros, 
				" idcuidadomascota = ".$regTId);
		}
	
		$db->disconnect();

		//echo "<script language='javascript'>alert(\"".$especie."\");</script>";
		echo "<script language='javascript'>top.document.location='mascotas_cuidados.php';</script>";
	}
	
	function crea()
	{
		$regId = $_POST['regId'];
		$regDetId = $_POST['regDetId'];
		
		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

		$fecha = $_POST['fecha'];
		$provision = $_POST['provision'];
		$observaciones = $_POST['observaciones'];

		$parametros = "";
		$parametros = "DATE_FORMAT('".trim($fecha)."','%d/%m/%y'),".
			"'".trim($provision)."',".
			"'".trim($observaciones)."',".
			trim($regId).",".
			trim($regDetId);

		$db = new dao();
	
		if ($db->connect())
		{
			$db->insert($cat_ref, "fecha,provision,observaciones,idmascota,idcuidado", $parametros);
		}
	
		$db->disconnect();

		//echo "<script language='javascript'>alert(\"".$parametros."\");</script>";
		echo "<script language='javascript'>top.document.location='mascotas_cuidados.php';</script>";	
	}

	function arr2str($pArr)
	{
		$str = "";
		foreach ($pArr as $i => $value) 
		{
			if (strlen($str) != 0)
			{
				$str .= ",";
			}
			
			$str .= $i;
		}
		
		return $str;
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
