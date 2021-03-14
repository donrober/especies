<?php include("construye.php"); ?>
<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<link rel="stylesheet" href="estilo.css">
<head>
<style type="text/css">
	html { height: 100% }
	body { height: 100%; margin: 0; padding: 0 }
	#map-canvas { height: 100% }
</style>
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ-HTNiAOZfTZV8tsVyIh82XQRbzoNjeM&sensor=false&v=3">
</script>
</head>
<body>
<form id="form1" name="form1" action="db_procubicaciones.php" method="POST">
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
<table style="width: 100%; height: 100%;">
	<tr>
		<td>Nombre:&nbsp;&nbsp;&nbsp;<input id="nombre" name="nombre" type="text" /></td>
		<td></td>
	</tr>
	<tr>
		<td>Coordenadas:
			<textarea id="coordenadas" name="coordenadas" type="text" /></textarea>
		</td>
		<td style="width: 100%; height: 100%;">Mapa:
			<div id="map-canvas" name="map-canvas" />		
		</td>
	</tr>
</table>
<input type="hidden" name="regId" id="regId" value="" />
<input type="submit" name="submit" value="Crea / Actualiza" /><br/>
</form>
</body>
<script type="text/javascript">
	function initialize() 
	{
		var mapOptions = 
		{
			center: new google.maps.LatLng(-34.397, 150.644),
			zoom: 8,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
</html>
