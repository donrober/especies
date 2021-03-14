<?php 
	include("construye.php"); 	
?>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_dao_proc_mascota_cuidado.php" method="POST" enctype="multipart/form-data">
	<div id='topNav' name='topNav'>
		<?php 
			$link = new control_html();
			$link->control = "link";
			$link->nombrecontrol = "linkIndex";
			$link->texto = "Regresa index.php";
			$link->winTarget = "_self";
			$link->link = "./index.php";
			echo $link->crea_control();
			$link->control = "link";
			$link->nombrecontrol = "linkMascotas";
			$link->texto = "Mascotas";
			$link->winTarget = "_self";
			$link->link = "./mascotas.php";
			echo $link->crea_control();			
		?>
	</div>
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<input type="hidden" name="regId" id="regId" value="-1" />
<input type="hidden" name="imagen" id="imagen" value="" />
<input type="hidden" name="nada" id="nada" value="" />
<input type="hidden" name="regTId" id="regTId" value="-1" />
<input type="hidden" name="regDetId" id="regDetId" value="-1" />
<input type="hidden" name="regApaId" id="regApaId" value="-1" />
<table>
	<tr>
		<td>
			<?php $ddl = new control_html();
				// DAO								
				$ddl->tbl = "mascotas";
				$ddl->campos = "IdMascota as regId, nombre as Valor";
				$ddl->ordenapor = "Valor";
				// DAO				
				
				$ddl->control = "ddldao";
				$ddl->nombrecontrol = "nombres";				
				/* Asigna comportamiento al ddl */
				$ddl->evento = "onchange";				
				$ddl->nombrescript = "inhabilita";
				$ddl->tiposcript = "bloquea";
				$ddl->origen = "nombres";
				$ddl->destino = "nada";
				/* Opcional: Actualiza valor de registro Id para update. */
				$ddl->actualizaid = 1;
				$ddl->nombreid = "regId";
				echo $ddl->crea_control();
			?>
		</td>
		<td>			
			<div id='refDiv' name='refDiv'></div>			
			
			<input id="nombre" name="nombre" type="hidden" /><br/>
			<input id="color" name="color" type="hidden" />
			<input id="edad" name="edad" type="hidden" />
			<input id="peso" name="peso" type="hidden" />
			<input id="altura" name="altura" type="hidden" />
			<input id="ancho" name="ancho" type="hidden" />
			<input id="largo" name="largo" type="hidden" />
		</td>
	</tr>
	<tr>
		<td>			
			<div id='refCuidados' name='refCuidados'></div>
		</td>
		<td></td>
	</tr>
	<tr>
		<td>
			<div id='refFecCuidados' name='refFecCuidados'></div>
		</td>
		<td>
			Fecha (dd/mm/yy):<input id="fecha" name="fecha" type="text" onchange="validaFecha()" /><br/>
			<input type="button" id="btnRegEvento" name="btnRegEvento" value="Recordatorio++" onclick="addRecordatorio()" disabled="true" />
		</td>
	</tr>
	<tr>
		<td>
			Provisi&oacute;n:
			<textarea id="provision" name="provision" type="text" /></textarea>
		</td>
		<td>
			Observaciones:
			<textarea id="observaciones" name="observaciones" type="text" /></textarea>
		</td>
	</tr>
</table>
<input type="submit" name="submit" value="Crea / Actualiza" class="submitir" /><br/>
</form>
<script language='javascript'>
	function validaFecha()
	{
		var fec = document.getElementById('fecha');
		var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{2})$/;
		
		if (fec.value == null || fec.value == "" || !pattern.test(fec.value))
		{
			document.getElementById('btnRegEvento').disabled = true;
		}
		else
		{
			document.getElementById('btnRegEvento').disabled = false;
		}
	}
	
	function addRecordatorio()
	{
		var xmlhttp; 
		var params = "";
		var respuestas = "";
		var comboCuidados = document.getElementById('cuidados');
		var comboNombres = document.getElementById('nombres');
		
		params = 'fec=' + document.getElementById('fecha').value + '&cuidado=' + comboNombres.options[comboNombres.selectedIndex].innerHTML + ' - ' +
		comboCuidados.options[comboCuidados.selectedIndex].innerHTML + '&descripcion=' + document.getElementById('provision').value; 
		
		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'goglevent_mascota_cuidado.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params);
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText;
				document.write(respuestas);
			} 
		}
	}
	
	function evalua_registro(pIndex)
	{
		var xmlhttp; 
		var params = 'regId=' + pIndex + '&consulta=datosmascota'; 
		var respuestas = "";
		var comboPadre = document.getElementById('padre');
		
		document.getElementById('regId').value = pIndex;		

		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'refdao_mascota_cuidado.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText;
				var respuesta = respuestas.split('|');
				
				document.getElementById('nombre').value = respuesta[0];
				document.getElementById('color').value = respuesta[1];
				document.getElementById('edad').value = respuesta[2];
				document.getElementById('altura').value = respuesta[3];
				document.getElementById('peso').value = respuesta[4];
				document.getElementById('ancho').value = respuesta[7];
				document.getElementById('largo').value = respuesta[8];
				
				document.getElementById('refDiv').innerHTML = "<img src=" + String.fromCharCode(39) + String.fromCharCode(46) + String.fromCharCode(47) + respuesta[6] + String.fromCharCode(39) + " width='50%' height='50%' " + String.fromCharCode(47) + ">";

				document.getElementById('imagen').value = respuesta[6];	
				document.getElementById('regApaId').value = respuesta[5];				
				lista_cuidados(pIndex);
			} 
		}				 
	}
	
	function lista_cuidados(pIndex)
	{
		var xmlhttp; 
		var params = 'regId=' + pIndex + '&consulta=cuidadoMascota'; 
		var respuestas = "";
		
		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'refdao_mascota_cuidado.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText;
				var respuesta = respuestas.split('|');
				
				document.getElementById('refCuidados').innerHTML = respuesta[0];	
			} 
		}

	}
	
	function evalua_registro_detalle()
	{ 
		//idmascota + idcuidado = parametros
		var xmlhttp; 
		var params = 'regId=' + document.getElementById('regId').value + '&consulta=detalleCuidados&regDetId=' + document.getElementById("cuidados").value; 
		var respuestas = "";
		
		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'refdao_mascota_cuidado.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200) 
			{ 
				respuestas = xmlhttp.responseText;
				var respuesta = respuestas.split('|');
				
				document.getElementById('refFecCuidados').innerHTML = respuesta[0];	
				document.getElementById('regDetId').value = document.getElementById("cuidados").value;
			} 
		}				 
	}
	
	function lista_detalles_registro()
	{
		var xmlhttp; 
		var params = 'regId=' + document.getElementById("regId").value + '&consulta=detallesCuidado&regTId=' + document.getElementById("fechasCuidado").value; 
		var respuestas = "";
		
		if (window.XMLHttpRequest) 
		{ xmlhttp=new XMLHttpRequest(); }
		else
		{ xmlhttp=new ActiveXObject('Microsoft.XMLHTTP'); } 

		xmlhttp.open('POST', 'refdao_mascota_cuidado.php', true); 
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(params); 
		document.getElementById('btnRegEvento').disabled = true;
		
		xmlhttp.onreadystatechange = function() 
		{ 
			if (xmlhttp.readyState==4 && xmlhttp.status==200 && document.getElementById("fechasCuidado").value != 0) 
			{ 
				respuestas = xmlhttp.responseText;
				var respuesta = respuestas.split('|');
				
				document.getElementById('fecha').value = respuesta[1];
				document.getElementById('provision').value = respuesta[2];
				document.getElementById('observaciones').value = respuesta[3];
				
				document.getElementById('regId').value = respuesta[4];
				document.getElementById('regDetId').value = respuesta[5];
				document.getElementById('regTId').value = respuesta[0];
				document.getElementById('btnRegEvento').disabled = false;
			} 
		}
	}
</script>
</body>
</html>
