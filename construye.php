<?php 
	include("./dao/dao.php");
?>

<?php
class control_html
{
	// Variable para realizar consultas a la base de datos
	var $query;
	
	// DAO; Variable para indicar tabla a la que se hará select
	var $tbl;
	// DAO; Variable para indicar los campos que se consultarán
	var $campos;
	// DAO; Variable para indicar los campos que se consultarán
	var $from;
	// DAO; Variable para indicar condiciones de búsqueda
	var $where;
	// DAO; Variable para indicar ordenamiento
	var $ordenapor;

	// Tipo de control; ddl, botón, lista, anchor
	var $control;
	// Valor para id y nombre del control
	var $nombrecontrol;
	// Variable retorno. Control generado.
	var $controlhtml;
	// Nombre de la función javascript
	var $nombrescript;
	// Tipo de script; para botones, actualizar listas, inhabilitar controles
	var $tiposcript;
	// Control origen. Generalmente dispara evento.
	var $origen;
	// Control al que afecta la operación del control origen
	var $destino;
	// tipo de evento del control html; onchange, onclick, ontextchanged, onload, etc...
	var $evento;
	// Etiquta para botones
	var $texto;
	// Se usa si el script actualiza valor de índice para registro	
	var $actualizaid;
	// Nombre del input tipo hidden para guardar el valor del registro
	var $nombreid;
	// Control select con los valores para listas
	var $listaId;
	// Valor del target para los <a>
	var $winTarget;
	// Link para los <a>
	var $link;

	public function getQuery() 
	{
		return $this->query;
	}	
	public function setQuery($query)
	{
		$this->query = $query;
	}

	public function crea_control()
	{
		$ctrl = $this->control;
		$ctrl_query = $this->getQuery();		
		$ctrl_nombre = $this->nombrecontrol;
		$ctrl_script = $this->tiposcript;
		$ctrl_nombrescript = $this->nombrescript;		
		$ctrl_evento = $this->evento;
		$ctrl_texto = $this->texto;
		$ctrl_link = $this->link;
		$ctrl_target = $this->winTarget;
		$funcion = "";

		if ($ctrl_nombrescript != "" && $ctrl_evento != "")
		{
			$ctrl_evento = $ctrl_evento."=(".$ctrl_nombrescript."())";
			if ($ctrl_script != "")
			{
				$funcion = $this->getScript($ctrl_script);
			}			
		}
		
		switch ($ctrl)
		{		
		case "ddldao":
			$db = new dao();
			$blnPrimero = true;
	
			if (!$db->connect())
			{
				echo "<script language='javascript'>alert('Alerta, alerta!!!');</script>";
			}
			
			$controlhtml = "";
			// Realizar una consulta MySQL
			$result = $db->selectddl($this->tbl, $this->campos, $this->where, $this->ordenapor);
			// Imprimir los resultados en HTML
			$controlhtml = "<select id='".$ctrl_nombre."' name='".$ctrl_nombre."' ".$ctrl_evento.">\n";
			while ($row = mysql_fetch_assoc($result)) 
			{					
				if ($blnPrimero)
				{
					$controlhtml .= "\t<option value='".$row['regId']."' selected>".$row['Valor']."</option>\n";
					$blnPrimero = !$blnPrimero;
				}
				else
				{
					$controlhtml .= "\t<option value='".$row['regId']."'>".$row['Valor']."</option>\n";
				}
			}
			$controlhtml .= "</select>\n";
			$controlhtml .= $funcion;

			// Liberar resultados
			mysql_free_result($result);

			// Cerrar la conexión
			$db->disconnect();			
		break;
		case "ddl":
			$link = mysql_connect('127.0.0.1:3306', 'root', 'sqlero') or die('No se pudo conectar: ' . mysql_error());
			// echo 'Connected successfully';
			mysql_select_db('subespecies') or die('No se pudo seleccionar la base de datos');

			$controlhtml = "";
			// Realizar una consulta MySQL
			$result = mysql_query($ctrl_query) or die('Consulta fallida: ' . mysql_error());
			// Imprimir los resultados en HTML
			$controlhtml = "<select id='".$ctrl_nombre."' name='".$ctrl_nombre."' ".$ctrl_evento.">\n";
			while ($row = mysql_fetch_assoc($result)) 
			{
			    $controlhtml .= "\t<option value='".$row['Id']."'>".$row['Valor']."</option>\n";
			}
			$controlhtml .= "</select>\n";
			$controlhtml .= $funcion;

			// Liberar resultados
			mysql_free_result($result);

			// Cerrar la conexión
			mysql_close($link);
		break;
		case "boton":
			$controlhtml = "<input type='button' id='".$ctrl_nombre."' name='".$ctrl_nombre."' ".$ctrl_evento." value='".$ctrl_texto."'/>\n";
		break;
		case "link":
			$controlhtml = "<a href='".$ctrl_link."' target='".$ctrl_target.
			"' id='".$ctrl_nombre."' name='".$ctrl_nombre."'>".$ctrl_texto."</a>\n";
		break;
		}
		
		return $controlhtml.$funcion;
	}

	public function getScript($pScript)
	{
		$script = "";

		switch ($pScript)
		{
		case "listas":
			$ctrl_origen = $this->origen;
			$ctrl_destino = $this->destino;
			$ctrl_nombrescript = $this->nombrescript;

			$script = "";
			
			$script = "<script language='javascript'>function ".$ctrl_nombrescript."(){ ".
			"var opcion = new Option(document.getElementById('".$ctrl_origen."').options[".
			"document.getElementById('".$ctrl_origen."').selectedIndex].text, ".
			"document.getElementById('".$ctrl_origen."').value); ".
			"var optsLen = document.getElementById('".$ctrl_destino."').length; ".
    			"document.getElementById('".$ctrl_destino."').options[optsLen] = opcion; ".
			" document.getElementById('"."reg".$ctrl_destino."').value += opcion.value.toString() + \",\"; }</script>";
			
		break;

		case "limpialistas":
			$ctrl_origen = $this->origen;
			$ctrl_destino = $this->destino;
			$ctrl_nombrescript = $this->nombrescript;
			$ctrl_lista = $this->listaId;

			$script = "";
			
			$script = "<script language='javascript'>function ".$ctrl_nombrescript."(){ ".
			"var elSelectMultiple = document.getElementById('".$ctrl_origen."'); ".
			"var regIds = document.getElementById('".$ctrl_destino."'); regIds.value = ''; ".
			"var opt; var i=0; ".
			"for (i=0; i < elSelectMultiple.length; i++) { ".
			" opt = elSelectMultiple.options[i]; ".			
			" if (!opt.selected) { ".			
			" regIds.value += opt.value + ','; ".
			" } } actualiza_lista('".$ctrl_lista."', '".$ctrl_origen."', regIds.value, '".$ctrl_destino."'); }</script>";
			
		break;

		case "bloquea":
			$ctrl_origen = $this->origen;
			$ctrl_destino = $this->destino;
			$ctrl_nombrescript = $this->nombrescript;
			$ctrl_nombreid = $this->nombreid;
			
			$script = "";

			$script = "<script language='javascript'>function ".$ctrl_nombrescript."(){ ".
			"var opcion = new Option(document.getElementById('".$ctrl_origen."').options[".
			"document.getElementById('".$ctrl_origen."').selectedIndex].text, ".
			"document.getElementById('".$ctrl_origen."').value); ".
			"var blq_control = document.getElementById('".$ctrl_destino."'); ".
    			"blq_control.disabled = (opcion.value != 0); ";			

			if ($this->actualizaid == 1)
			{					
				$script .= "if (opcion.value != 0) { ".
				" var id_control = document.getElementById('".$ctrl_nombreid."'); ".
	    			" id_control.value = opcion.value; ". 
				" evalua_registro(opcion.value); } ";
			}			

			$script .= "}</script> ";
		break;

		case "filtrapor":
			$ctrl_origen = $this->origen;
			$ctrl_destino = $this->destino;
			$ctrl_nombrescript = $this->nombrescript;
			$ctrl_nombreid = $this->nombreid;
			
			$script = "";

			$script = "<script language='javascript'>function ".$ctrl_nombrescript."(){ ".
			"var opcion = new Option(document.getElementById('".$ctrl_origen."').options[".
			"document.getElementById('".$ctrl_origen."').selectedIndex].text, ".
			"document.getElementById('".$ctrl_origen."').value); ";			

			if ($this->actualizaid == 1)
			{					
				$script .= "if (opcion.value != 0) { ".
				" var id_control = document.getElementById('".$ctrl_nombreid."'); ".
	    			" id_control.value = opcion.value; filtra_por(opcion.value, '".$ctrl_destino."'); } ";
			}			

			$script .= "}</script> ";
		break;
		}

		return $script;		
	}
}
?>
