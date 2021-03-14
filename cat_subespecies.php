<?php include("construye.php"); ?>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_proc.php" method="POST" enctype="multipart/form-data">
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
		<td>
			Nombre:&nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" /><br/>
			<?php $ddl = new control_html();
				$ddl->control = "ddl";
				$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
							"union ".
							"select IdSubespecie, concat(c1.nombre, ' ', c2.nombre) ".
							"from cat_subespecies c2, cat_especies c1 where c2.idespecie = c1.idespecie order by Valor ");
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
		<td colspan="2">Otros nombres:&nbsp;&nbsp;&nbsp;<input id="otrosnombres" name="otrosnombres" type="text" style="width: 600px;"/></td>
	</tr>
	<tr>
		<td colspan="3">Descripci&oacute;n:
			<textarea id="descripcion" name="descripcion" rows="5" cols="120"></textarea>
		</td>
	</tr>
	<tr>
		<td>Imagen:&nbsp;&nbsp;&nbsp;
			<input type="file" name="img" id="img" />
		</td>
		<td>Especie:
			<?php	
				/* Limpia comportamiento del control */
				$ddl->evento = "";
				$ddl->nombrescript = "";
				$ddl->tiposcript = "";
				$ddl->origen = "";
				$ddl->destino = "";
				$ddl->actualizaid = 0;
				$ddl->nombreid = "";
	
				$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
							"union ".
							"select ce.IdEspecie, concat(cg.nombre, ' - ', ce.nombre) ".
							"from cat_especies ce inner join cat_generos cg on ce.idgenero = cg.idgenero".
							" order by Valor ");
				$ddl->nombrecontrol = "padre";
				echo $ddl->crea_control();
			?>
			<br/><div id='taxDiv' name='taxDiv'></div>
		</td>
		<td>
<?php	
	/* Limpia comportamiento del control */
	$ddl->evento = "";
	$ddl->nombrescript = "";
	$ddl->tiposcript = "";
	$ddl->origen = "";
	$ddl->destino = "";
	$ddl->actualizaid = 0;
	$ddl->nombreid = "";
	
	$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
				"union ".
				"select IdUbicacion, nombre ".
				"from cat_ubicaciones");
	$ddl->nombrecontrol = "ubicacion";

	$boton = new control_html();
	$boton->control = "boton";
	$boton->nombrecontrol = "botUbica";
	$boton->nombrescript = "ubicaciones";
	$boton->tiposcript = "listas";
	$boton->origen = "ubicacion";
	$boton->destino = "multiubics";
	$boton->evento = "onclick";
	$boton->texto = "A&ntilde;ade";

	echo "<td>Ubicaci&oacute;n:&nbsp;&nbsp;&nbsp;";
	echo $ddl->crea_control();
	echo "<br/ >";
	echo $boton->crea_control();
	echo "<div>\n";
	echo "<select multiple id=\"multiubics\" name=\"multiubics\" size=\"2\">";
	echo "</select>";
	
	$boton->nombrecontrol = "botQuitaUbics";
	$boton->nombrescript = "quitaUbicsSeleccionados";
	$boton->tiposcript = "limpialistas";
	$boton->origen = "multiubics";
	$boton->destino = "regmultiubics";
	$boton->listaId = "ubicacion";
	$boton->evento = "onclick";
	$boton->texto = "Elimina";

	echo "</div>";
	echo $boton->crea_control();
	echo "</td> ";	

	$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
				"union ".
				"select IdMalestar, nombre ".
				"from cat_malestares");
	$ddl->nombrecontrol = "malestar";

	$boton->nombrecontrol = "botMolesta";
	$boton->nombrescript = "malestares";
	$boton->tiposcript = "listas";
	$boton->origen = "malestar";
	$boton->destino = "multiusos";
	$boton->evento = "onclick";
	$boton->texto = "A&ntilde;ade";
		
	echo "<td>Malestar:&nbsp;&nbsp;&nbsp;";
	echo $ddl->crea_control();
	echo "<br/ >";
	echo $boton->crea_control();
	echo "<div>\n";
	echo "<select multiple id=\"multiusos\" name=\"multiusos\" size=\"2\">";
	echo "</select>";
	
	$boton->nombrecontrol = "botQuitaUsos";
	$boton->nombrescript = "quitaUsosSeleccionados";
	$boton->tiposcript = "limpialistas";
	$boton->origen = "multiusos";
	$boton->destino = "regmultiusos";
	$boton->listaId = "malestar";
	$boton->evento = "onclick";
	$boton->texto = "Elimina";
	
	echo "</div>";
	echo $boton->crea_control();	
	echo "</td> ";

	$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
				"union ".
				"select IdProblema, nombre ".
				"from cat_problemas");
	$ddl->nombrecontrol = "problema";

	$boton->nombrecontrol = "botProblema";
	$boton->nombrescript = "problemas";
	$boton->tiposcript = "listas";
	$boton->origen = "problema";
	$boton->destino = "multiproblemas";
	$boton->evento = "onclick";
	$boton->texto = "A&ntilde;ade";
		
	echo "<td>Problema:&nbsp;&nbsp;&nbsp;";
	echo $ddl->crea_control();
	echo "<br/ >";
	echo $boton->crea_control();
	echo "<div>\n";
	echo "<select multiple id=\"multiproblemas\" name=\"multiproblemas\" size=\"2\">";
	echo "</select>";
	
	$boton->nombrecontrol = "botQuitaProblemas";
	$boton->nombrescript = "quitaProblemasSeleccionados";
	$boton->tiposcript = "limpialistas";
	$boton->origen = "multiproblemas";
	$boton->destino = "regmultiproblemas";
	$boton->listaId = "problema";
	$boton->evento = "onclick";
	$boton->texto = "Elimina";
	
	echo "</div>";
	echo $boton->crea_control();	
	echo "</td> ";
	
	echo "</tr><tr><td><div id='refDiv' name='refDiv'></div></td><td></td>";	
?>
	</td></tr>
</table>
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<input type="hidden" name="regId" id="regId" value="-1" />
<input type="hidden" name="imagen" id="imagen" value="" />
<input type="hidden" name="regmultiubics" id="regmultiubics" value="" />
<input type="hidden" name="regmultiusos" id="regmultiusos" value="" />
<input type="hidden" name="regmultiproblemas" id="regmultiproblemas" value="" />
<input type="hidden" name="regApaId" id="regApaId" value="-1" />
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
<script language='javascript'>
	function evalua_registro(pIndex)
	{
		var xmlhttp; 
		var params = 'regId=' + pIndex + '&consulta=datossubespecie'; 
		var respuestas = "";
		var comboPadre = document.getElementById('padre');
		
		document.getElementById('taxDiv').innerHTML = "";
		document.getElementById('regId').value = pIndex;		

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_cat_subespecies.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText; 
				var respuesta = respuestas.split('|');
				
				document.getElementById('nombre').value = respuesta[0];
				document.getElementById('otrosnombres').value = respuesta[1];
				document.getElementById('descripcion').value = respuesta[2];
				document.getElementById('refDiv').innerHTML = "<img src=" + String.fromCharCode(39) + String.fromCharCode(46) + String.fromCharCode(47) + respuesta[3] + String.fromCharCode(39) + " " + String.fromCharCode(47) + ">";
				document.getElementById('imagen').value = respuesta[3];
				actualiza_lista('ubicacion', 'multiubics', respuesta[4], 'regmultiubics');
				actualiza_lista('malestar', 'multiusos', respuesta[5], 'regmultiusos');
				actualiza_lista('problema', 'multiproblemas', respuesta[6], 'regmultiproblemas');
				if (respuesta[7] != "")
				{
					document.getElementById('regApaId').value = respuesta[7];
					for (j = 0; j < comboPadre.options.length; j++)
					{	
						if (comboPadre.options[j].value == respuesta[7])
						{
							comboPadre.options[j].selected = true;					
						}
					}
					construye_taxonomia(pIndex);
				}
				else
				{
					document.getElementById('regApaId').value = 0;
					document.getElementById('padre').options[0].selected = true;
				}				
			} 
		}				 
	}

	function construye_taxonomia(pIndex)
	{
		var params = 'regId=' + pIndex + '&consulta=taxonomia';
		var respuestas = "";

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_cat_subespecies.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 

		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText; 
				document.getElementById('taxDiv').innerHTML = respuestas;
			} 
		}
	}

	function actualiza_lista(pNombreCombo, pNombreLista, pIndices, pHidden)
	{		
		var elSelect=document.getElementById(pNombreCombo);
		var indices = (pIndices + ',').split(',');
		var i = 0;
		var j = 0;

		document.getElementById(pNombreLista).options.length = 0;

		for (i=0; i < elSelect.options.length; i++)
		{
			var opcion = new Option(document.getElementById(pNombreCombo).options[i].text, 
			document.getElementById(pNombreCombo).options[i].value); 

			for (j = 0; j < indices.length; j++)
			{	
				if (indices[j] == opcion.value && opcion.value != 0)
				{
					var optsLen = document.getElementById(pNombreLista).length; 
					document.getElementById(pNombreLista).options[optsLen] = opcion; 
					document.getElementById(pHidden).value += opcion.value.toString() + String.fromCharCode(44);
				}					
			}
		}		
	}
</script>
</body>
</html>
