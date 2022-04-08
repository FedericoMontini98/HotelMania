<?php 
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";

	if(!logged()){
		$page='//'.LOCAL_ROOT.'/PHP/signin.php';
		redirect($page);
	}

	if(!isAdmin()){
		$page='//'.LOCAL_ROOT.'/index.php';
		redirect($page);
	}

	function redirect($page){
		header('Location: '.$page);
		exit;
	}
?>

<!DOCTYPE HTML>
<html lang="it">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="default-style">
		<meta name = "author" content = "Federico Montini">
		<title>HotelMania | Admin </title>
		<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	</head>
	<body>
		<?php
			include "./../layout/intestazione.php";
			include "./../layout/barraDiNavigazione.php";
		?>

		<div class="navigaSezioneAdmin">
			<h2>Area Amministratore</h2>
			<hr>
			<ul style="list-style-type:disc">
				<li><a href="./inserisciHotel.php">Inserisci un nuovo hotel</a></li>
				<li><a href="./inserisciImmagini.php">Inserisci le immagini di un hotel specifico</a></li>
				<li><a href="./modificaHotel.php">Modifica un hotel già presente</a></li>
				<li><a href="./aggiungiAdmin.php">Concedi i diritti di admin</a></li>
			</ul>		
		</div>	
	</body>	
</html>