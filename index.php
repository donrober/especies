<?php 
	include("construye.php"); 
?>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<head>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
<form id="form1" name="form1" method="POST" enctype="multipart/form-data">
	<div id='topNav' name='topNav'>
		<?php $link = new control_html();
			$link->control = "link";
			$link->nombrecontrol = "linkCatalogos";
			$link->texto = "Cat&aacute;logos";
			$link->winTarget = "_self";
			$link->link = "./cat_reinos.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkMascotas";
			$link->texto = "Mascotas";
			$link->winTarget = "_self";
			$link->link = "./mascotas.php";
			echo $link->crea_control();
			$link->nombrecontrol = "linkMascotaCuidado";
			$link->texto = "Cuidados";
			$link->winTarget = "_self";
			$link->link = "./mascotas_cuidados.php";
			echo $link->crea_control();
			echo "</br>";
			phpinfo();
		?>
	</div>
</form>

</body>
</html>
