<?php 
	//Pagina adibita alla gestione delle prenotazioni e dei dati dell'utente
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";
	$TipoErrore=null;
	//Verifico sia stato fatto il login
	if(!logged()){
		header('Location: //'.LOCAL_ROOT.'/PHP/signin.php');
		exit;
	}

	if(!isset($_GET["c"]))
		$prov = "pren";
	else
		$prov=$_GET["c"];

		//Verifico siano stati inseriti tutti i campi
	if(isset($_POST['Nome']) && isset($_POST['Cognome']) && isset($_POST['CodiceFiscale']) && isset($_POST['CartaDiCredito']) && isset($_POST['Indirizzo']) && isset($_POST['Citta']) && isset($_POST['Email'])){

		//Campi settati correttamente, procedo ad inserire il nuovo utente
		$esito=updateUtente($_SESSION['HotelManiaIDUtente'],$_POST['Nome'],$_POST['Cognome'],$_POST['CodiceFiscale'],$_POST['CartaDiCredito'],$_POST['Indirizzo'],$_POST['Citta'],$_POST['Email']);
		if($esito['risultato']==false){
			//Codice errore generico
			echo '<script> alert("Errore: '.$esito['codiceErrore'].' ritenta più tardi.");</script>';
		}
		else{
			//Imposto la sessione
			$IDUtente=getIDUtente($_POST['CodiceFiscale']);
			setSessionID($_POST['Nome'],$IDUtente);
			header('Location: //'.LOCAL_ROOT.'/index.php');
		}
	}
?>

<!DOCTYPE HTML>
<html lang ="it">
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="default-style">
	<meta name = "author" content = "Federico Montini">
	<title>HotelMania | Utente </title>
	<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/GestisciPrenotazioni.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/location.css" media="screen">
	<!-- aggiungi script -->
	<script src="./../../JavaScript/getResearch.js"></script>
	<script src="./../../JavaScript/Ajax/DashboardLocations.js"></script>
	<script src="./../../JavaScript/Ajax/DashboardPren.js"></script>
	<script src="./../../JavaScript/Ajax/CaricaLocation.js"></script>
	<script src="./../../JavaScript/Ajax/ajaxManager.js"></script>
	<script src="./../../JavaScript/pulsanti.js"></script>
	<script src="./../../JavaScript/Ajax/prenotazioni.js"></script>
</head>

<body>
	<?php
		include "./../layout/intestazione.php";
		include "./../layout/barraDiNavigazione.php";
	?>
	<div class="containerRicerca">
		<div class="barraRicerca">
			<input id="ricerca" type="text" placeholder="Cerca una location in cui sei stato" onkeyup="CaricaLocation.cercaPren('<?php echo $prov?>',this.value,<?php echo $_SESSION['HotelManiaIDUtente']?>)">
		</div>
		<?php
			include "./../layout/pulsanti-prenotazioni.php";
		?>
		<div class="risultatiRicerca" id="_risultatiRicerca"></div>	
		<?php
			include "./../layout/pulsanti-prenotazioni.php";
		?>

		<script> 
			CaricaLocation.cercaPren('<?php echo $prov?>','',<?php echo $_SESSION['HotelManiaIDUtente']?>);
		</script>
	</div>
	<div class="gestisciDatiUtente">
			<div id="contenitore_ModifyForm" class = "contenitore-ModifyForm"><p class="c">Hai sbagliato a inserire i dati? Modifica i tuoi dati personali!</p>
		<form id="ModifyForm" name = "_ModifyForm" action = "//<?php echo LOCAL_ROOT.'/PHP/utente/GestisciPrenotazioni.php'?>" method="POST">
			<div class="registro">
				<label>Nome: </label>
				<input type= "text" name="Nome" pattern="[A-Za-z]+" value = <?php if(isset($_POST["Nome"])) echo '"'.$_POST["Nome"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Cognome: </label>
				<input type= "text" name="Cognome" pattern="[A-Za-z]+" value = <?php if(isset($_POST["Cognome"])) echo '"'.$_POST["Cognome"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Codice Fiscale: </label>
				<input type= "text" name="CodiceFiscale" pattern=".{16}" value = <?php if(isset($_POST["CodiceFiscale"])) echo '"'.$_POST["CodiceFiscale"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Numero carta di credito: </label>
				<input type= "text" name="CartaDiCredito" pattern=".{16}" value = <?php if(isset($_POST["CartaDiCredito"])) echo '"'.$_POST["CartaDiCredito"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Citta: </label>
				<input type= "text" name="Citta" value = <?php if(isset($_POST["Citta"])) echo '"'.$_POST["Citta"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Indirizzo: </label>
				<input type= "text" name="Indirizzo" value = <?php if(isset($_POST["Indirizzo"])) echo '"'.$_POST["Indirizzo"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
				<label>Email: </label>
				<input type= "email" name="Email" value = <?php if(isset($_POST["Email"])) echo '"'.$_POST["Email"].'"'; else echo '""';?> required>
			</div>
			<div class="registro">
			<!-- Inseriti tutti i campi creo il pulsante "Registrati" -->
			<div class="pulsanteRegistrati">
				<input class = "registrati_button" type="submit" value="Modifica dati personali">
			</div>
		</form>
	</div>
	</div>
</body>
</html>