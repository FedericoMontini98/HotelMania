<?php
	ob_start();
	//Sezione dedicata alla pagina personale di ogni hotel, posso accedervi solo se ho eseguito il log-in in quanto è possibile prenotare
	session_start();
	require_once __DIR__ .".\..\..\config.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";

	$IDHotel=$_GET["id"];
	
	//Verifico sia stato fatto il login
	if(!logged()){
		$page='//'.LOCAL_ROOT.'/PHP/signin.php';
		redirect($page);
	}

	//Sezione che gestisce la zona recensione
	if(isset($_POST["valutazioneStelle"]) && isset($_POST["_recensione"])){
		$recensisci=inserisciRecensione($_SESSION["HotelManiaIDUtente"],$IDHotel,$_POST["valutazioneStelle"],$_POST["_recensione"]);
		$page= '//'.LOCAL_ROOT.'/PHP/hotelPage.php?id='.$IDHotel;
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
	<title>HotelMania | Hotel </title>
	<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/recensisci.css" media="screen">
	<script src="./../../JavaScript/MyHotel.js"></script>
</head>
<body>
	<?php
	include "./../layout/intestazione.php";
	include "./../layout/barraDiNavigazione.php";
	?>
		<div class="ContenitoreRecensione" id="_ContenitoreRecensione">
			<form id="recensione" name="formRecensione" onsubmit="return valuta(document.formRecensione)" method= "POST" action="./recensisci.php?id=<?php echo $IDHotel; ?>">
			<h2>Ti sei trovato bene?<br> Lascia una recensione!</h2>
				<div class="container-valutazione">
					<span>Dacci un voto!</span>
					<div class = "valutazione">
						<input required type = "radio" class="_nessunaValutazione" id="nessunaValutazione" name="valutazioneStelle" value="0" checked>
						<input required type = "radio"  name = "valutazioneStelle" id = "valutazione_1" value = "1">
						<label for = "valutazione_1">1 stella</label>
						<input required type = "radio" name = "valutazioneStelle" id = "valutazione_2" value = "2">
						<label for = "valutazione_2">2 stelle</label>
						<input required type = "radio" name = "valutazioneStelle" id = "valutazione_3" value = "3">
						<label for = "valutazione_3">3 stelle</label>
						<input required type = "radio" name = "valutazioneStelle" id = "valutazione_4" value = "4">
						<label for = "valutazione_4">4 stelle</label>
						<input required type = "radio" name = "valutazioneStelle" id = "valutazione_5" value = "5">
						<label for = "valutazione_5">5 stelle</label>
					</div>
				</div>
				<textarea required class ="testo-valutazione" name="_recensione" maxlength="2048" minlength="1" placeholder="Descrivi la tua esperienza!"></textarea>
				<input type="submit" name="recensisci" value="Recensisci!" class="invia">
			</form>
		</div>
</body>
</html>