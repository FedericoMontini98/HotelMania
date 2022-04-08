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
	$directory="./../../immagini/";
	$errore=null;
	$msg=null;

	if(isset($_POST["IDHotel"]) && isset($_POST["Classificazione"]) && isset($_FILES["Immagine"])){
		$estensione=strtolower(pathinfo($_FILES["Immagine"]["name"],PATHINFO_EXTENSION));
		if($_POST["Classificazione"]==1){
			$path=$directory . "hotel-" . $_POST["IDHotel"] . "." . $estensione;
		}
		else if($_POST["Classificazione"]==2){
			$path=$directory . "camera-" . $_POST["IDHotel"] . "." . $estensione;
		}
		else if($_POST["Classificazione"]==3){
			$path=$directory . "hall-" . $_POST["IDHotel"] . "." . $estensione;
		}
		else{
			$msg="errore: categoria sconosciuta";
			$errore=true;
			$path=null;
		}

		//Verifico che il libro a cui associare l'immagine esista
		if(trovaHotel($_POST["IDHotel"])==null){
			$errore=true;
			$msg="Il libro specificato non esiste";
		}

		//Verifico che il file sia effettivamente un'immagine
		else if($_FILES["Immagine"]["tmp_name"] == '' || !getimagesize($_FILES["Immagine"]["tmp_name"])){
			$errore=true;
			$msg="Il file non è una immagine";
		}

		//Verifico che l'immagine sia effettivamente un JPG
		else if($estensione!=="jpg"){
			$errore=true;
			$msg="Immagine non nel formato corretto";
		}

		//Verifico la dimensione dell'immagine
		else if($_FILES["Immagine"]["size"] > 900000){
			$errore=true;
			$msg="Immagine troppo grande";
		}
		//Se non si sono verificati errori procedo a salvare il file
		if(path!==null && $errore!==true){
			if(move_uploaded_file($_FILES["Immagine"]["tmp_name"], $path)){
				$errore=false;
				$msg="File" .basename($_FILES["Immagine"]["name"]) . "è stato caricato con successo";
			}
			else{
				$errore=true;
				$msg="caricamento non riuscito";
			}
		}
	}
?>

<!DOCTYPE HTML>
<html lang="it">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="default-style">
		<meta name = "author" content = "Federico Montini">
		<title>HotelMania | Nuova Immagine </title>
		<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	</head>
	<body>
		<?php
			include "./../layout/intestazione.php";
			include "./../layout/barraDiNavigazione.php";
		?>
		<!-- Form caricamento immagine enctype necessario per poter caricare file -->
		<form class="InserisciHotel" action="inserisciImmagini.php" method="POST" enctype="multipart/form-data">
			<h2> Inserisci un immagine </h2>
			<hr>
			<div>
				<label>Inserisci l'ID dell'hotel per cui vuoi caricare un'immagine:</label>
				<input type="number" step="1" min="1" name="IDHotel" required autofocus></input>
			</div>
			<div>
				<label>Inserisci il tipo di immagine: 1-generica, 2-camera e 3-hall</label>
				<input type="number" step="1" min="1" max="3" name="Classificazione" required></input>
			</div>
			<div>
				<label>Inserisci l'immagine in formato JPG</label>
				<input type="file" name="Immagine" id="Immagine" required></input>
			</div>
			<div class="inserisci">
				<input type="submit" value="Inserisci">
			</div>
		</form>

		<script>
			<?php
			if($errore!==null){
				echo "alert('".$msg."');";
				if($errore==false){
					echo 'location.href = "./admin.php"';
				}
			}
			?>
		</script>
	</body>
</html>