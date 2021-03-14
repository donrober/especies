<?php include("construye.php"); ?>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_procproblemas.php" method="POST">
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
		<td>
		<?php $ddl = new control_html();
			$ddl->control = "ddl";
			$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
						"union ".
						"select IdProblema, nombre ".
						"from cat_problemas");
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

			echo "Filtra por subespecie --->";			
			$ddl->setQuery("select 0 as Id, '(Selecciona)' as Valor ".
				"union ".
				"select cs.IdSubespecie, concat(cg.nombre, ' - ', ce.nombre, ' - ', cs.nombre) ".
				"from cat_subespecies cs inner join cat_especies ce on cs.idespecie = ce.idespecie ".
				"inner join cat_generos cg on ce.idgenero = cg.idgenero order by Valor ");
			$ddl->nombrecontrol = "subespecie";
			/* Asigna comportamiento al ddl */
			$ddl->evento = "onchange";
			$ddl->nombrescript = "filtra";
			$ddl->tiposcript = "filtrapor";
			$ddl->origen = "subespecie";
			$ddl->destino = "nombres";
			/* Opcional: Actualiza valor de registro Id para update. */
			$ddl->actualizaid = 1;
			$ddl->nombreid = "subId";
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
	<tr>		
		<td>Tratamiento:
			<input id="nomTratamiento" name="nomTratamiento" type="text" />
		</td>
		<td>Descripci&oacute;n:
			<textarea id="descTratamiento" name="descTratamiento" type="text" /></textarea>
		</td>
	</tr>
	<tr>		
		<td>
			<input type="button" id="btnTratamiento" name="btnTratamiento" onclick="anadeTratamiento();" value="Tratamiento +" disabled/>
			<br/>
			<span id="editaTratamiento" name="editaTratamiento"></span>
		</td>
		<td>			
		</td>
	</tr>
</table>
<input type="hidden" name="regId" id="regId" value="-1" />
<input type="hidden" name="subId" id="subId" value="-1" />
<input type="hidden" name="regTratsId" id="regTratsId" value="" />
<input type="hidden" name="regTId" id="regTId" value="-1" />
<div id="detTratamientos" name="detTratamientos"></div>
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
<script language='javascript'>
	function edita_detalle(pIndex, pNombre, pDescr)
	{		
		document.getElementById('regTId').value = pIndex;
		var elSpan=document.getElementById('editaTratamiento');
		var elNombre=document.createElement('input');
		var laDescripcion;
		var elBoton=document.createElement('input');
		
		if(navigator.appName.indexOf("Internet Explorer")!=-1)
		{     
			laDescripcion = document.createElement('input');
			laDescripcion.setAttribute("value", pDescr);
		}
		else
		{
			laDescripcion = document.createElement('textarea');
			laDescripcion.value = pDescr;
		}		

		elSpan.innerHTML = "";		

		// Asigna atributos		
		elNombre.setAttribute("type", 'text');
		elNombre.setAttribute("value", pNombre);
		elNombre.setAttribute("name", 'txtEditaNombre');
		elNombre.setAttribute("id", 'txtEditaNombre');

		laDescripcion.setAttribute("type", 'text');
		laDescripcion.setAttribute("name", 'txtEditaDescripcion');
		laDescripcion.setAttribute("id", 'txtEditaDescripcion');		

		elBoton.setAttribute("type", 'button');
		elBoton.setAttribute("value", 'Guardar');
		elBoton.setAttribute("name", 'btnEditaNombre');
		elBoton.setAttribute("id", 'btnEditaNombre');	
		
		elSpan.appendChild(elNombre);
		elSpan.appendChild(laDescripcion);
		elSpan.appendChild(elBoton);
		
		elBoton.onclick=function(){editaTrata(pIndex)};
	}

	function editaTrata(pIndex)
	{
		var xmlhttp; 
		var malId = document.getElementById('regId').value;

		if (pIndex != -1)
		{
			var nombre = document.getElementById('txtEditaNombre').value;
			var descripcion = document.getElementById('txtEditaDescripcion').value;
			var params = 'regId=' + pIndex + '&nombre=' + nombre + '&descripcion=' + descripcion + '&oper=actualiza'; 
			var respuestas = "";

			if (window.XMLHttpRequest) 
			{ xmlhttp=new XMLHttpRequest(); }
			else
			{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

			xmlhttp.open('POST', 'db_procsoluciones.php', true); 
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(params); 

			xmlhttp.onreadystatechange = function() 
			{ 
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{ 
					evalua_registro(malId);
				} 
			}
		
			document.getElementById('regTId').value = pIndex;
			document.getElementById('btnTratamiento').disabled = (document.getElementById('nombres').value==0);
		}
	}

	function anadeTratamiento()
	{
		var xmlhttp; 
		var pIndex = document.getElementById('regId').value;

		if (pIndex != -1)
		{
			var nombre = document.getElementById('nomTratamiento').value;
			var descripcion = document.getElementById('descTratamiento').value;
			var params = 'regId=' + pIndex + '&nombre=' + nombre + '&descripcion=' + descripcion + '&oper=creaconmalestar'; 
			var respuestas = "";

			if (window.XMLHttpRequest) 
			{ xmlhttp=new XMLHttpRequest(); }
			else
			{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

			xmlhttp.open('POST', 'db_procsoluciones.php', true); 
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send(params); 

			xmlhttp.onreadystatechange = function() 
			{ 
				if (xmlhttp.readyState==4 && xmlhttp.status==200) 
				{ 
					evalua_registro(pIndex);
				} 
			}
		
			document.getElementById('regId').value = pIndex;
			document.getElementById('btnTratamiento').disabled = (document.getElementById('nombres').value==0);
		}		
	}
	
	function evalua_registro(pIndex)
	{
		var xmlhttp; 
		var params = 'regId=' + pIndex; 
		var respuestas = "";

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_cat_problemas.php', true); 
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
				document.getElementById('regTratsId').value = respuesta[2];
				carga_detalle(pIndex);
			} 
		}
		
		document.getElementById('regId').value = pIndex;
		document.getElementById('btnTratamiento').disabled = (document.getElementById('nombres').value==0);		 
	}

	function filtra_por(pIndex, pControl)
	{
		var xmlhttp; 
		var params = 'regId=-1&subId=' + pIndex; 
		var respuestas = "";
		var paresCombo = "";
		var i = 0;
		var combo = document.getElementById(pControl);

		combo.options.length = 0;
		var opcion = new Option("(Selecciona)", -1);

		combo.options[0] = opcion;

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_cat_problemas.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 

		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText; 
				var respuesta = respuestas.split('|');

				for (i = 0; i <= respuesta.length ; i++)
				{
					var paresCombo = respuesta[i].split(',');					
					var opcion = new Option(paresCombo[1], paresCombo[0]);

					combo.options[i + 1] = opcion;	
				}
			} 
		}
		
		document.getElementById('regId').value = pIndex;
		document.getElementById('btnTratamiento').disabled = (document.getElementById('nombres').value==0);		 
	}	

	function elimina_detalle(pIndex)
	{
		var xmlhttp;
		var params = 'regId=' + pIndex + '&oper=elimina';
		var detalles = "";

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'db_procsoluciones.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 		

		var idsTratamiento = document.getElementById('regTratsId').value;
		var tratamientos = idsTratamiento.split(',');
		var idsTratamientoN = "";		

		for (var i = 0; i < tratamientos.length; i++)
		{
			if (idsTratamientoN.length > 0)
			{
				idsTratamientoN += ",";
			}
			if (tratamientos[i] != pIndex)
				idsTratamientoN += tratamientos[i];
		}

		document.getElementById('regTratsId').value = "";
		document.getElementById('regTratsId').value = idsTratamientoN;		

		carga_detalle(document.getElementById('regId').value);
	}

	function carga_detalle(pIndex)
	{
		var xmlhttp;
		var params = 'regId=' + pIndex;
		var detalles = "";

		document.getElementById('detTratamientos').innerHTML = "";

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'ref_det_problemas.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 

		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				detalles = xmlhttp.responseText; 						
				document.getElementById('detTratamientos').innerHTML = detalles;
			} 
		}

		document.getElementById('regId').value = pIndex;
	}
</script>
</body>
</html>
