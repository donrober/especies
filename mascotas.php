<?php 
	include("construye.php"); 	
?>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" action="db_dao_proc.php" method="POST" enctype="multipart/form-data">
	<div id='topNav' name='topNav'>
		<?php $link = new control_html();
			$link->control = "link";
			$link->nombrecontrol = "linkIndex";
			$link->texto = "Regresa index.php";
			$link->winTarget = "_self";
			$link->link = "./index.php";
			echo $link->crea_control();			
		?>
	</div>
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
			<?php $ddl = new control_html();
				// DAO								
				$ddl->tbl = " cat_especies ce inner join cat_generos cg on ce.idgenero = cg.idgenero ".
					"inner join cat_subespecies cs on ce.idespecie = cs.idespecie";
				$ddl->campos = "cs.idsubespecie as regId, concat(cg.nombre, ' - ', ce.nombre, ' - ', cs.nombre) as Valor";
				$ddl->ordenapor = "Valor";
				// DAO				
				
				$ddl->control = "ddldao";
				$ddl->nombrecontrol = "padre";				
				// Asigna comportamiento al ddl 
				$ddl->evento = "";				
				$ddl->nombrescript = "";
				$ddl->tiposcript = "";
				$ddl->origen = "";
				$ddl->destino = "";
				//Opcional: Actualiza valor de registro Id para update.
				$ddl->actualizaid = -11;
				$ddl->nombreid = "regId";
				echo $ddl->crea_control();
			?>
		</td>
	</tr>
	<tr>
		<td>
			Nombre:&nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" /><br/>
			Color:&nbsp;&nbsp;&nbsp;<input id="color" name="color" type="text" /><br/>
			Edad:&nbsp;&nbsp;&nbsp;<input id="edad" name="edad" type="text" />&nbsp;&nbsp;(a&ntilde;os)<br/>
			Peso:&nbsp;&nbsp;&nbsp;<input id="peso" name="peso" type="text" />&nbsp;&nbsp;(kilos)<br/>	
			Altura:&nbsp;&nbsp;&nbsp;<input id="altura" name="altura" type="text" />&nbsp;&nbsp;(cent&iacute;metros)<br/>
			Ancho:&nbsp;&nbsp;&nbsp;<input id="ancho" name="ancho" type="text" />&nbsp;&nbsp;(cent&iacute;metros)<br/>
			Largo:&nbsp;&nbsp;&nbsp;<input id="largo" name="largo" type="text" />&nbsp;&nbsp;(cent&iacute;metros)<br/>			
		</td>
	</tr>
	<tr>
		<td>Imagen:&nbsp;&nbsp;&nbsp;
			<input type="file" name="img" id="img" />
		</td>
	</tr>
	<tr><td><div id='refDiv' name='refDiv'></div></td></tr>
</table>
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<input type="hidden" name="regId" id="regId" value="-1" />
<input type="hidden" name="imagen" id="imagen" value="" />
<input type="hidden" name="nada" id="nada" value="" />
<input type="hidden" name="regApaId" id="regApaId" value="-1" />
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
<script language='javascript'>
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

		xmlhttp.open('POST', 'refdao_mascota.php', true); 
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
				
				if (respuesta[5] != "")
				{
					document.getElementById('regApaId').value = respuesta[5];
					for (j = 0; j < comboPadre.options.length; j++)
					{	
						if (comboPadre.options[j].value == respuesta[5])
						{
							comboPadre.options[j].selected = true;					
						}
					}					
				}
				else
				{
					document.getElementById('regApaId').value = 0;
					document.getElementById('padre').options[0].selected = true;
				}				
			} 
		}				 
	}
</script>
</body>
</html>
