<?php
	require_once '/Google/Client.php';
	require_once '/Google/Service/Calendar.php';
	//require_once 'Google/Service/Plus.php';
	session_start();	
	
	$fecha = $_POST['fec'];
	$cuidado = $_POST['cuidado'];
	$descripcion = $_POST['descripcion'];
	
	$client = new Google_Client();
	$client->setApplicationName("mapas");
	$client->setClientId('78420355764-d4fh63pnmtpq89psund28buqlrd6juc0.apps.googleusercontent.com');
	$client->setClientSecret('CToVfX1qlIO0DUUDqGaqIhxf');
	$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);  
	$client->setDeveloperKey('AIzaSyDiggl82BdHo4QmLPW1HTOIxFAp1NXFEoM');
	$client->setAccessType('offline');
	$client->setScopes(array('https://www.googleapis.com/auth/calendar', 'https://www.googleapis.com/auth/calendar.readonly', 
	'https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.email'));
	
	if ($fecha != "")
	{
		$arr = explode('/', $fecha);
		$fecha = ($arr[2] + 2000).'-'.$arr[1].'-'.$arr[0];
		$_SESSION['fecha'] = $fecha;		
	}
	
	if ($descripcion != "")
	{
		$_SESSION['descripcion'] = $descripcion;
	}
	
	if ($cuidado != "")
	{
		$_SESSION['cuidado'] = $cuidado;
	}	
	
	if (isset($_GET['logout'])) 
	{
		unset($_SESSION['fecha']);
		unset($_SESSION['cuidado']);
		unset($_SESSION['descripcion']); 
		unset($_SESSION['codigo']);
		unset($_SESSION['token']);
	}
	
	if(!empty($cookie))
	{
		$client->refreshToken($this->Cookie->read('token'));
	}
	
	if (isset($_GET['code'])) 
	{	
		echo "----------------------------------------------------------";
		$client->authenticate($_GET['code']);
		$_SESSION['token'] = $client->getAccessToken();
		header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
		
		$cal = new Google_Service_Calendar($client); 		
		//$plus = new Google_Service_Plus($client);	
		
		$event = new Google_Service_Calendar_Event();
		//$me = $plus->people->get('me');
		
		$event->setSummary($_SESSION['cuidado']);
		$event->setDescription($_SESSION['descripcion']);
		$event->setLocation('');
		$start = new Google_Service_Calendar_EventDateTime();
		$start->setDateTime($_SESSION['fecha'].'T09:00:00.000-07:00');
		$event->setStart($start);
		$end = new Google_Service_Calendar_EventDateTime();
		$end->setDateTime($_SESSION['fecha'].'T10:00:00.000-07:00');
		$event->setEnd($end);
		/*$attendee1 = new Google_Service_Calendar_EventAttendee();
		$attendee1->setEmail($me['emails'][0]['value']);
		// ...
		$attendees = array($attendee1);

		$event->attendees = $attendees;*/
		
		unset($_SESSION['fecha']);
		unset($_SESSION['cuidado']);
		unset($_SESSION['descripcion']);
		
		$createdEvent = $cal->events->insert('primary', $event);	
		
		echo "<script language='javascript'>top.document.location='mascotas_cuidados.php';</script>";
	}
	else 
	{
		$authUrl = $client->createAuthUrl();
		//echo $authUrl;
		echo "<script language='javascript'>top.document.location='".$authUrl."';</script>";
		//print "<a class='login' href='$authUrl'>Connect Me!</a>";
	}
?>