<!-- Pagina adibita alla registrazione di un utente - Lato Server -->
<?php
	session_start();
	require_once __DIR__ . "./../config.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";
	$TipoErrore=null;
	//Se il login è già stato fatto posso uscire 
	if(logged()){
		//Ritorno alla pagina index
		header('Location: //'.LOCAL_ROOT.'/index.php');
		exit;
	}
	//Verifico siano stati inseriti tutti i campi
	if(isset($_POST['Nome']) && isset($_POST['Cognome']) && isset($_POST['CodiceFiscale']) && isset($_POST['CartaDiCredito']) && isset($_POST['Indirizzo']) && isset($_POST['Citta']) && isset($_POST['Email']) && isset($_POST['Password'])){
		//Campi settati correttamente, procedo ad inserire il nuovo utente
		$esito=inserisciUtente($_POST['Nome'],$_POST['Cognome'],$_POST['CodiceFiscale'],$_POST['CartaDiCredito'],$_POST['Indirizzo'],$_POST['Citta'],$_POST['Email'],$_POST['Password']);
		if($esito['risultato']==false){
			if($esito['codiceErrore']==10){
				$TipoErrore="CodCarta";
			}
			if($esito['codiceErrore']==11){
				$TipoErrore="CodFiscale";
			}
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

<!-- Lato Client -->
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta name = "author" content = "Federico Montini">
	<title>HotelMania | Registrati </title>
	<link rel="stylesheet" type="text/css" href="./../css/signup.css" media="screen">
	<script src="./../JavaScript/signup.js"></script>
</head>
<body>
	<?php
		include "./layout/intestazione.php";
	?>
	<div id="contenitore_SignUpForm" class = "contenitore-SignUpForm"><p>Entra nella nostra famiglia!</p>
		<form id="signUpForm" name = "_signUpForm" action = "//<?php echo LOCAL_ROOT.'/PHP/signup.php'?>" method="POST">
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
				<label>Password: </label>
				<input type= "password" name="Password" pattern=".{10,40}" title="La lunghezza della password deve avere almeno 10 caratteri ma non più di 40" value = <?php if(isset($_POST["Password"])) echo '"'.$_POST["Password"].'"'; else echo '""';?> required>
				<div class="erroreDigitazione">Le due password non coincidono</div>
			</div>
			<div class="registro">
				<label>Conferma Password: </label>
				<input type= "password" name="confermaPassword" required>
			</div>

			<!-- Inseriti tutti i campi creo il pulsante "Registrati" -->
			<div class="pulsanteRegistrati">
				<input class = "registrati_button" type="submit" value="Registrati!">
			</div>
		</form>

		<script>
			document._signUpForm.onsubmit = new Function("return valida(document._signUpForm)");
			<?php
				//Notifica a schermo se il codice fiscale è duplicato
				if($TipoErrore == 'CodFiscale'){
					echo 'var CodF = document._signUpForm.CodiceFiscale;';
					echo 'InputErrato(CodF)';
				}
				if($TipoErrore == 'CodCarta'){
					echo 'var CodC = document._signUpForm.CartaDiCredito;';
					echo 'InputErrato(CodC)';
				}
			?>
		</script>
	</div>
</body>