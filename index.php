<?php
	//Pagina principale del sito
	session_start();
	//Includo il file di configurazione
	require_once __DIR__ . "\config.php";

	//Includo il file di gestione del Database
	require_once DIR_BASE . "PHP\utility\gestoreDB.php";

	//Includo il file di gestione della sessione
	require_once DIR_BASE . "PHP\utility\sessionUtility.php";

	//Includo il file relativo alla gestione del dataBase (inserimento record, rimozione, etc.)
	require_once DIR_BASE . "PHP\utility\GestoreFunzioniDB.php";
?>

<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="default-style">
	<meta name = "keywords" content = "hotel, B&B, motel, stanza, appartamento, letto, 5 stelle">
	<meta name = "author" content = "Federico Montini">
	<meta name = "description" content = "HotelMania: la catena dei vostri sogni... con un prezzo per le vostre tasche!">

	<title>HotelMania | Homepage</title>

	<link rel="stylesheet" type="text/css" href="./css/mainpage.css" media="screen">
	<link rel="icona" href="./immagini/titolo.jpg">

	<!-- Ricorda di aggiungere gli script di JavaScript -->
	<script src="./JavaScript/slider.js"></script>
	<script src="./JavaScript/Ajax/ajaxManager.js"></script>
	<script src="./JavaScript/Ajax/CaricaLocation.js"></script>
	<script src="./JavaScript/Ajax/DashboardRecensioni.js"></script>
</head>
<body>
	<!-- Inserisco l'intestazione che sarà comune a tutte le pagine del sito -->	
	<?php
		include "./PHP/layout/intestazione.php";
		include "./PHP/layout/barraDiNavigazione.php";
	?>
	<!-- Sezione adibita allo slideshow delle offerte -->
	<div id="content"> 
		<div id="slide_Show" class="slide-Show">
			<!-- Script creazione Slider -->
			<script>	
				var ContenitoreSlide=document.getElementById("slide_Show");
				var slideshow = new sliderCreator(ContenitoreSlide,8000);
			</script>
			<div class = "slides">
				<img src="./immagini/slide1.jpg" alt="Offerta_Bali">
				<span class="slideText">
					<span> OFFERTA IMPERDIBILE! <br> Bali immerso nella natura a soli 13 euro a notte!
					</span>
				</span>
			</div>
			<div class = "slides">
				<img src="./immagini/slide2.jpg" alt="Offerta_Roma">
				<span class="slideText">
					<span> INCREDIBILE! <br> Roma, camera per due persone in una nostra location da 4* a soli 45 euro a notte!
					</span>
				</span>
			</div>
			<!-- Inserisco i pulsanti che mi permettano di muovermi tra le offerte -->
			<button class="SlidePrevious displayLeft" onclick="slideshow.spostaSlide(-1)">&#5176;
			</button>
			<button class="SlideNext displayRight" onclick="slideshow.spostaSlide(+1)">&#5171;
			</button>
			<!-- Inserisco L'effetto di rotazione delle offerte -->
			<script>
				slideshow.ruota();
			</script>
		</div>
	</div>

	<div id="offerteText">
		Benvenuti nel nostro universo! Siamo ormai una realtà da più di 20 anni che dà certezze ai propri clienti fornendo garanzie e un comodo accesso a chiunque ne abbia bisogno senza lasciare da parte i bisogni individuali di nessuno. <br> Ogni giorno lavoriamo in modo da permettere ad ognuno dei nostri clienti di poter usufruire dei nostri servizi, cerchiamo di realizzare offerte adatte alle tasche di tutti nelle location piu' belle del mondo senza perdere occasione per metterci in discussione tramite le recensioni che i nostri clienti ci lasciano.<br>
		Grazie a tutti i clienti per la fiducia, siamo felici di offrirvi vacanze indimenticabili.<br>
		
	</div>

	<div class = "contenitore" id = "BestHotel">
		<h2 class = "titolo">Le nostre location con votazioni piu' alte!</h2><hr>
		<div class = "bestLocation" id = "_bestLocation">
			<script>CaricaLocation.carica();</script>
		</div>
	</div>

	<hr>
	
	<div class="_contenitore" id = "manualeUtente">
		<a href= "./manuale.html"> Non sai destreggiarti sul nostro sito? Clicca qua per accedere al manuale!</a>
	</div>
</body>
</html>