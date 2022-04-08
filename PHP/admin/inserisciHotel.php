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

	$errore=null;

	if(isset($_POST["Nome"]) && isset($_POST["Citta"]) && isset($_POST["Prezzo"]) && isset($_POST["Descrizione"]) /*&& isset($_POST["Immagine"])*/){
		//Inserisco
		$esito=inserisciHotel($_POST["Nome"],$_POST["Citta"],$_POST["Prezzo"],$_POST["Descrizione"]);
		if($esito==false)
			$errore=true;
		else
			$errore=false;
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
		<title>HotelMania | Nuovo Hotel</title>
		<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	</head>
	<body>
		<?php
			include "./../layout/intestazione.php";
			include "./../layout/barraDiNavigazione.php";
		?>

		<form class="InserisciHotel" action="InserisciHotel.php" method="POST">
			<h2> Inserisci i dati del nuovo Hotel </h2>
			<hr>
			<div class="campo">
				<label>Nome</label>
				<input id="campo-nome" type="text" name="Nome" required>
			</div>
			<div class="campo">
				<label>Citta</label>
				<input id="campo-citta" type="text" name="Citta" required>
			</div>
			<div class="campo">
				<label>Prezzo p/p a notte</label>
				<input id="campo-prezzo" type="number" name="Prezzo" required>
			</div>
			<div class="campo">
				<label>Descrizione</label>
				<textarea id="campo-descrizione" name="Descrizione" maxlength="4096" required></textarea>
			</div>
			<div class="inserisci">
				<input type="submit" value="Inserisci">
			</div>	
		</form>

		<script>
			<?php
				if(isset($errore) && $errore==true){
			?>
				alert("Inserimento non riuscito");
			<?php
				}
				elseif(isset($errore) && $errore==false){
			?>
				alert("Inserimento riuscito");
				location.href = "./InserisciHotel.php";
			<?php 
			}
			?>
		</script>
	</body>
</html>