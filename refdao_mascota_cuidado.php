<?php 
	include("construye.php");
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
				$cat_padre = substr($cat_ref, 0, strpos($cat_ref, "_"));
				
				$result = $db->select($cat_padre, "nombre, color, edad, altura, peso, idsubespecie, imagen, ancho, largo", 
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
		elseif ($tipoConsulta == "cuidadoMascota")
		{
			$ddl = new control_html();
			// DAO								
			$ddl->tbl = "cat_cuidados";
			$ddl->where = " idusuario = 1 ";
			$ddl->campos = "idcuidado as regId, nombre as Valor";
			$ddl->ordenapor = "Valor";
			// DAO				
			
			$ddl->control = "ddldao";
			$ddl->nombrecontrol = "cuidados";				
			/* Asigna comportamiento al ddl */
			$ddl->evento = "onchange";				
			$ddl->nombrescript = "evalua_registro_detalle";
			$ddl->tiposcript = "";
			$ddl->origen = "cuidados";
			$ddl->destino = "nada";
			/* Opcional: Actualiza valor de registro Id para update. */
			$ddl->actualizaid = 1;
			$ddl->nombreid = "regApaId";
			echo $ddl->crea_control();
		}		
		elseif ($tipoConsulta == "detalleCuidados")
		{
			$regIdDet = $_POST['regDetId'];
			$ddl = new control_html();
			// DAO								
			$ddl->tbl = "cat_cuidados cc inner join mascotas_cuidados cm on cc.idcuidado = cm.idcuidado";
			$ddl->where = " cc.idusuario = 1 and cm.idcuidado = ".$regIdDet." and cm.idmascota = ".$regId;
			$ddl->campos = "idcuidadomascota as regId, DATE_FORMAT(fecha,'%d/%m/%y') as Valor";
			$ddl->ordenapor = "Valor";
			// DAO				
			
			$ddl->control = "ddldao";
			$ddl->nombrecontrol = "fechasCuidado";				
			/* Asigna comportamiento al ddl */
			$ddl->evento = "onchange";				
			$ddl->nombrescript = "lista_detalles_registro";
			$ddl->tiposcript = "";
			$ddl->origen = "fechasCuidado";
			$ddl->destino = "nada";
			/* Opcional: Actualiza valor de registro Id para update. */
			$ddl->actualizaid = 1;
			$ddl->nombreid = "regDetId";
			echo $ddl->crea_control();
		}
		elseif ($tipoConsulta == "detallesCuidado")
		{
			$regIdT = $_POST['regTId'];
			if ($db->connect())
			{
				$catalogo = $_SERVER["HTTP_REFERER"];
		
				$cat = substr($catalogo, 0, strpos($catalogo, "?"));
				if ($cat == "") {$cat = $catalogo;}
				$cat_ref = strrchr($cat, "/");		
				$cat_ref = str_replace(".php", "", str_replace("/", "", $cat_ref));
				
				$result = $db->select($cat_ref, "idcuidadomascota, DATE_FORMAT(fecha,'%d/%m/%y') as fecha, provision, observaciones, idmascota, idcuidado ", 
					"idcuidadomascota=".$regIdT, null);				
					
				while ($row = mysql_fetch_assoc($result)) 
				{
					$script = $row['idcuidadomascota']."|".$row['fecha']."|".$row['provision']."|".$row['observaciones']."|".$row['idmascota']."|".$row['idcuidado'];
				}			

				$db->disconnect();		

				// Liberar resultados
				mysql_free_result($result);			

				echo $script;
			}
		}
		
		// Cerrar la conexión
		// mysql_close($link);
		mysql_close();
	}	
?>
