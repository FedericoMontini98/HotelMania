<?php
	ob_start();
	//Sezione dedicata alla pagina personale di ogni hotel, posso accedervi solo se ho eseguito il log-in in quanto è possibile prenotare
	session_start();
	require_once __DIR__ .".\..\config.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";

	//Verifico sia stato fatto il login
	if(!logged()){
		$page='//'.LOCAL_ROOT.'/PHP/signin.php';
		redirect($page);
	}
	$errore=false;

	//Controlli per una eventuale prenotazione
	$IDHotel=$_GET["id"];

	$hotel=getHotel($IDHotel);
	$nome=$hotel["Nome"];
	$citta=$hotel["Citta"];
	$prezzo=$hotel["Prezzo"];
	$valutazione=$hotel["Valutazione"];
	$descrizione=$hotel["Descrizione"];

	//Sezione che gestisce il pulsante
	if(isset($_POST["DataInizio"]) && isset($_POST["DataFine"]) && isset($_POST["N_Persone"])){
		$todays_date = date("d-m-Y");
		$stamp_todayDate= strtotime($todays_date);
		$stamp_dataInizio= strtotime($_POST["DataInizio"]);
		$stamp_dataFine= strtotime($_POST["DataFine"]);
		if($stamp_dataInizio<$stamp_todayDate || $stamp_dataFine<$stamp_dataInizio){
			$errore=true;
		}
		else{
			$di=$_POST["DataInizio"];
			$df=$_POST["DataFine"];
			$N_Persone=$_POST["N_Persone"];
			//Tento di inserire la prenotazione
			$errore=aggiungiPrenotazione($_SESSION['HotelManiaIDUtente'],$di,$df,$N_Persone,$IDHotel);
			//Riuscita redirezione alla pagina delle prenotazioni
			if($errore === null){
				$page="./utente/GestisciPrenotazioni.php";
				redirect($page);
			}
		}
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
	<link rel="stylesheet" type="text/css" href="./../css/mainpage.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../css/hotel.css" media="screen">
	<script src="./../JavaScript/slider.js"></script>
	<script src="./../JavaScript/MyHotel.js"></script>
</head>
<body>
	<?php
	include "./layout/intestazione.php";
	include "./layout/barraDiNavigazione.php";
	?>
	<div id="contenitore-totale">
		<div id="content"> <h2 class="foto"> Foto della nostra location </h2>
			<div id="slide_Show" class="slide-Show">
				<!-- Script creazione Slider -->
				<script>	
					var ContenitoreSlide=document.getElementById("slide_Show");
					var slideshow = new sliderCreator(ContenitoreSlide,8000);
				</script>
				<div class = "slides">
					<img id="img-1" src=<?php echo "./../immagini/hotel-".$IDHotel.".jpg";?> alt="hotel-<?php echo $IDHotel ?>" onerror = "document.getElementById('img-1').setAttribute('src','./../immagini/error.jpg')">
				</div>
				<div class = "slides">
					<img id="img-2" src=<?php echo "./../immagini/camera-".$IDHotel.".jpg";?> alt="camera-<?php echo $IDHotel ?>" onerror = "document.getElementById('img-2').setAttribute('src','./../immagini/error.jpg')">
				</div>
				<div class = "slides">
					<img id="img-3" src=<?php echo "./../immagini/hall-".$IDHotel.".jpg";?> alt="hall-<?php echo $IDHotel ?>" onerror = "document.getElementById('img-3').setAttribute('src','./../immagini/error.jpg')">
				</div>
				<!-- Inserisco i pulsanti che mi permettano di muovermi tra le offerte -->
				<button class="SlidePrevious displayLeft" onclick="slideshow.spostaSlide(-1)">&#5176;</button>
				<button class="SlideNext displayRight" onclick="slideshow.spostaSlide(+1)">&#5171;</button>
				<!-- Inserisco L'effetto di rotazione delle offerte -->
				<script>
					slideshow.ruota();
				</script>
			</div>
		</div>
		<div id="contenitore-descrizione">
			<h2 class="p">Prenota Subito!!</h2>
			<hr class="p">
			<div class="info" id="Citta">
				<p><strong>Citta :</strong> <?php echo $citta?></p>
			</div>
			<div class="info" id="Prezzo">
				<p><strong>Prezzo :</strong> <?php echo $prezzo?>€ per ogni notte a persona</p>
			</div>
			<div class="info" id="Descrizione">
				<p><strong>Descrizione :</strong> <?php echo $descrizione?></p>
			</div>
			<div class="info" id="Valutazione">
				<p><strong>Valutazione :</strong> <?php echo $valutazione?>/5</p>
			</div>
			<hr class="p">
			<div id="formPrenotazione">
				<form id="prenotaForm" name="_prenotaForm" action = "//<?php echo LOCAL_ROOT.'/PHP/hotelPage.php?id='.$IDHotel?>" method="POST">
					<div class="campo">
						<label> Data Inizio: </label>
						<input type= "date" name="DataInizio" value = <?php if(isset($_POST["DataInizio"])) echo '"'.$_POST["DataInizio"].'"'; else echo '""';?> required autofocus>
					</div>
					<div class="campo">
						<label> Data Fine: </label>
						<input type= "date" name="DataFine" value = <?php if(isset($_POST["DataFine"])) echo '"'.$_POST["DataFine"].'"'; else echo '""';?> required>
					</div>
					<div class="campo">
						<label> Numero Persone: </label>
						<input type= "number" min="1" name="N_Persone" value = <?php if(isset($_POST["N_Persone"])) echo '"'.$_POST["N_Persone"].'"'; else echo '""';?> required>
					</div>
					<div class= "pulsantePrenota">
						<input class ="pulsante_Prenota" type="submit" value="Prenota ora!">
					</div>
				</form>
				<script>
					<?php if($errore==true){ ?>
						alert("Date non coerenti, verifica di avere inserito una data successiva ad oggi e che la data fine non sia antecedente la data di inizio");
					<?php } ?>
				</script>
			</div>
		</div>
	</div>
	<?php
	$es=haSoggiornato($_SESSION['HotelManiaIDUtente'],$IDHotel)->fetch_assoc();
	if($es){
	?>
		<a id="linkRecensione" href="./utente/recensisci.php?id=<?php echo $IDHotel ?>">Grazie per averci scelto, dicci come è stata la tua esperienza!</a>
	<?php
	}
	?>
	<!-- Sezione dedicata a mostrare le recensioni lasciate da altri utenti -->
	<?php 
		$ris=haRecensioni($IDHotel)->fetch_assoc();
		if($ris){
	?>
			<h1>Cosa ne pensano i nostri clienti:</h1>
	<?php
		}
	?>
	<div id="recensioniUtenti">
		<?php
			$i=0;
			$recensioni=getRecensioni($IDHotel);

			while($tupla=$recensioni->fetch_assoc()){
		?>
			<div class="ContenitoreRecensione">
				<h1><?php echo $tupla["Nome"]." ".$tupla["Cognome"].":"?></h1>
				<div class="contenitoreStelle"></div>
				<div class="contenitore-Descrizione">
					<p class="contenitoreDescrizione"><?php echo $tupla["Descrizione"];?></p>
				</div>
				<script>settaStelle(document.getElementsByClassName("ContenitoreRecensione")[<?php echo $i;?>].getElementsByClassName("contenitoreStelle")[0],<?php echo $tupla["Votazione"]?>)</script>
			</div>
		<?php
			$i++;
			}
		?>
	</div>
</body>
</html>