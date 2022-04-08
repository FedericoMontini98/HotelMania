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

	if(isset($_POST["ID"]) && isset($_POST["Nome"]) && isset($_POST["Citta"]) && isset($_POST["Prezzo"]) && isset($_POST["Descrizione"])){
		$trovato=trovaHotel($_POST["ID"]);
		if($trovato){
			$esito= aggiornaHotel($_POST["ID"],$_POST["Nome"],$_POST["Citta"], $_POST["Prezzo"],$_POST["Descrizione"]);
			if(isset($esito) && $esito== false)
				$errore=true;
			else{
				$errore=false;
				$page="./admin.php";
				redirect($page);
			}
		}
		else
			$errore=true;
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
		<title>HotelMania | Modifica Hotel </title>
		<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	</head>
	<body>
		<?php
			include "./../layout/intestazione.php";
			include "./../layout/barraDiNavigazione.php";
		?>
		<form class="InserisciHotel" id="modificaHotel" action="./modificaHotel.php" method="POST">
			<h2> Inserisci l'ID dell'hotel da modificare</h2>
			<hr>
			<div class="campo">
				<label>ID: </label>
				<input id="campo-ID" type="number" min="1" name="ID" required autofocus>
			</div>
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
			<div class="inserisci" id="modifica">
				<input type="submit" value="Modifica">
			</div>	
		</form>
		<script>
			<?php
			if(isset($errore) && $errore===true){
			?>
				alert("Modifica non riuscita");
			<?php
			}
			?>
		</script>
	</body>
</html>