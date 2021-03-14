<?php 
	include("./dao/dao.php");
?>

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
		
		$target_path = "uploads/";
		$target_path = $target_path.basename($_FILES['img']['name']);

		$catalogo = $_SERVER["HTTP_REFERER"];
		
		$cat = substr($catalogo, 0, strpos($catalogo, "?"));
		if ($cat == "") {$cat = $catalogo;}
		$cat_ref = strrchr($cat, "/");		
		$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));
		
		if(move_uploaded_file($_FILES['img']['tmp_name'], $target_path) && is_numeric($regId)) 
		{
			$nombre = $_POST['nombre'];
			$color = $_POST['color'];
			$edad = $_POST['edad'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$ancho = $_POST['ancho'];
			$largo = $_POST['largo'];

			$especie = ($_POST['padre'] == "" ? $_POST['regApaId'] : $_POST['padre']);

			$parametros = array();
			array_push($parametros, "'".trim($nombre)."'");
			array_push($parametros, "'".trim($color)."'");
			array_push($parametros, trim($peso));
			array_push($parametros, trim($edad));
			array_push($parametros, trim($especie));
			array_push($parametros, trim($altura));
			array_push($parametros, trim($ancho));
			array_push($parametros, trim($largo));
			array_push($parametros, "'".trim($target_path)."'");

			$db = new dao();
		
			if ($db->connect() && is_numeric($regId))
			{
				$db->update($cat_ref, "nombre, color, peso, edad, idsubespecie, altura, ancho, largo, imagen", $parametros, 
					" idmascota = ".$regId);
			}
		
			$db->disconnect();

			//echo "<script language='javascript'>alert(\"".$parametros."\");</script>";
			echo "<script language='javascript'>top.document.location='mascotas.php';</script>";
		} 
		else
		{
			$nombre = $_POST['nombre'];
			$color = $_POST['color'];
			$edad = $_POST['edad'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$ancho = $_POST['ancho'];
			$largo = $_POST['largo'];
			
			$especie = ($_POST['padre'] == "" ? $_POST['regApaId'] : $_POST['padre']);

			$target_path = $_POST['imagen'];

			$parametros = array();
			array_push($parametros, "'".trim($nombre)."'");
			array_push($parametros, "'".trim($color)."'");
			array_push($parametros, trim($peso));
			array_push($parametros, trim($edad));
			array_push($parametros, trim($especie));
			array_push($parametros, trim($altura));
			array_push($parametros, trim($ancho));
			array_push($parametros, trim($largo));
			array_push($parametros, "'".trim($target_path)."'");

			$db = new dao();
		
			if ($db->connect() && is_numeric($regId))
			{
				$db->update($cat_ref, "nombre, color, peso, edad, idsubespecie, altura, ancho, largo, imagen", $parametros, 
					" idmascota = ".$regId);
			}
		
			$db->disconnect();

			//echo "<script language='javascript'>alert(\"".$especie."\");</script>";
			echo "<script language='javascript'>top.document.location='mascotas.php';</script>";
		}
	}
	
	function crea()
	{
		$target_path = "uploads/";

		$target_path = $target_path.basename($_FILES['img']['name']);
		
		if(move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) 
		{
		    	$catalogo = $_SERVER["HTTP_REFERER"];
		
			$cat = substr($catalogo, 0, strpos($catalogo, "?"));
			if ($cat == "") {$cat = $catalogo;}
			$cat_ref = strrchr($cat, "/");		
			$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));

			$nombre = $_POST['nombre'];
			$color = $_POST['color'];
			$edad = $_POST['edad'];
			$altura = $_POST['altura'];
			$peso = $_POST['peso'];
			$especie = $_POST['padre'];
			$ancho = $_POST['ancho'];
			$largo = $_POST['largo'];

			$parametros = "";
			$parametros = "'".trim($nombre)."',".
				"'".trim($color)."',".
				trim($peso).",".
				trim($edad).",".
				trim($especie).",".
				trim($altura).",".
				trim($ancho).",".
				trim($largo).",".
				"'".$target_path."'";

			$db = new dao();
		
			if ($db->connect())
			{
				$db->insert($cat_ref, "nombre, color, peso, edad, idsubespecie, altura, ancho, largo, imagen", $parametros);
			}
		
			$db->disconnect();

			//echo "<script language='javascript'>alert(\"".$parametros."\");</script>";
			echo "<script language='javascript'>top.document.location='mascotas.php';</script>";
		} 
		else
		{
		    echo "There was an error uploading the file, please try again!";
		}		
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
