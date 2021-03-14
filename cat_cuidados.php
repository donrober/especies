<?php include("construye.php"); ?>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_proccuidados.php" method="POST">
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
			$link->nombrecontrol = "linkIndex";
			$link->texto = "Regresa index.php";
			$link->winTarget = "_self";
			$link->link = "./index.php";
			echo $link->crea_control();
		?>
	</div>
<table>
	<tr>
		<td>Nombre:&nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" /></td>
		<td>
		<?php $ddl = new control_html();
			$ddl->control = "ddl";
			$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
						"union ".
						"select IdCuidado, nombre ".
						"from cat_cuidados");
			$ddl->nombrecontrol = "nombres";
			/* Asigna comportamiento al ddl */
			$ddl->evento = "onchange";
			$ddl->nombrescript = "inhabilita";
			$ddl->tiposcript = "bloquea";
			$ddl->origen = "nombres";
			$ddl->destino = "nombre";
			/* Opcional: Actualiza valor de registro Id para update. */
			$ddl->actualizaid = 1;
			$ddl->nombreid = "regId";
			echo $ddl->crea_control();
		?>
		</td>
	</tr>
	<tr>
		<td>Descripci&oacute;n:
			<textarea id="descripcion" name="descripcion" type="text" /></textarea>
		</td>
		<td></td>
	</tr>
</table>
<input type="hidden" name="regId" id="regId" value="-1" />
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
<script language='javascript'>
	function evalua_registro(pIndex)
	{
		var xmlhttp; 
		var params = 'regId=' + pIndex; 
		var respuestas = "";

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_cat_cuidados.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 

		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText; 
				var respuesta = respuestas.split('|');
				
				document.getElementById('nombre').value = respuesta[0];
				document.getElementById('descripcion').value = respuesta[1];
			} 
		}
		
		document.getElementById('regId').value = pIndex;		 
	}
</script>
</body>
</html>
