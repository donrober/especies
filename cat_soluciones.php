<?php include("construye.php"); ?>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_proctratamientos.php" method="POST">
	<div id='topNav' name='topNav'>
		<?php $link = new control_html();
			$link->control = "link";
			$link->nombrecontrol = "linkReinos";
			$link->texto = "Reinos";
			$link->winTarget = "_self";
			$link->link = "./cat_reinos.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkFilos";
			$link->texto = "Filos";
			$link->winTarget = "_self";
			$link->link = "./cat_filos.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkClases";
			$link->texto = "Clases";
			$link->winTarget = "_self";
			$link->link = "./cat_clases.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkOrdenes";
			$link->texto = "Ordenes";
			$link->winTarget = "_self";
			$link->link = "./cat_ordenes.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkFamilias";
			$link->texto = "Familias";
			$link->winTarget = "_self";
			$link->link = "./cat_familias.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkGeneros";
			$link->texto = "G&eacute;neros";
			$link->winTarget = "_self";
			$link->link = "./cat_generos.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkEspecies";
			$link->texto = "Especies";
			$link->winTarget = "_self";
			$link->link = "./cat_especies.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkSubespecies";
			$link->texto = "Subespecies";
			$link->winTarget = "_self";
			$link->link = "./cat_subespecies.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkMalestares";
			$link->texto = "Malestares";
			$link->winTarget = "_self";
			$link->link = "./cat_malestares.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkProblemas";
			$link->texto = "Problemas";
			$link->winTarget = "_self";
			$link->link = "./cat_problemas.php";			
			echo $link->crea_control();
			$link->nombrecontrol = "linkSoluciones";
			$link->texto = "Soluciones";
			$link->winTarget = "_self";
			$link->link = "./cat_soluciones.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkTratamientos";
			$link->texto = "Tratamientos";
			$link->winTarget = "_self";
			$link->link = "./cat_tratamientos.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkUbicaciones";
			$link->texto = "Ubicaciones";
			$link->winTarget = "_self";
			$link->link = "./cat_ubicaciones.php";
			echo $link->crea_control();
		?>
	</div>
<table>
	<tr>
		<td>Nombre:&nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" /></td>
	</tr>
	<tr>
		<td>Descripci&oacute;n:
			<textarea id="descripcion" name="descripcion" type="text" /></textarea>
		</td>
	</tr>
</table>
<input type="hidden" name="regId" id="regId" value="" />
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
</body>
</html>
