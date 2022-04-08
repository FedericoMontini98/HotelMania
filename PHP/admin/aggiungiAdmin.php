<?php 
	session_start();
	require_once __DIR__ . ".\..\..\config.php";
	require_once DIR_BASE . "PHP/utility/sessionUtility.php";
	require_once DIR_BASE . "PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE . "PHP/utility/gestoreDB.php";

	$errore=null;

	if(!logged()){
		$page='//'.LOCAL_ROOT.'/PHP/signin.php';
		redirect($page);
	}

	if(!isAdmin()){
		$page='//'.LOCAL_ROOT.'/index.php';
		redirect($page);
	}

	if(isset($_POST["Email"]) && isset($_POST["Password"])){
		//Verifica inserimento password
		$esito=verificaMail($_POST["Email"]);
		if(!$esito)
			$errore=11;
		else{
			$esito=verificaPassword($_SESSION["HotelManiaIDUtente"],$_POST["Password"]);
			if(!$esito)
				$errore=10;
		}
		if($errore==null){
			impostaAdmin($_POST["Email"]);
			$errore=0;
		}
	}


?>

<!DOCTYPE HTML>
<html lang="it">
	<head>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="default-style">
		<meta name = "author" content = "Federico Montini">
		<title>HotelMania | Nuovo Admin </title>
		<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./../../css/admin.css" media="screen">
	</head>
	<body>
		<?php
			include "./../layout/intestazione.php";
			include "./../layout/barraDiNavigazione.php";
		?>
		<form class="InserisciHotel" id="ModAdmin" name="newAdmin" action="./aggiungiAdmin.php" method="POST">
			<h2>Concedi i diritti di amministratore ad un altro utente</h2><hr>

			<label>Inserisci la email del nuovo admin</label>
			<input type = "email" name = "Email" required value = <?php if(isset($_POST["Email"])) echo '"'.$_POST["Email"].'"'; else echo '""'; ?>>
			<div class = "erroreDigitazione">L'email inserita non risulta registrata</div>

			<label>Inserisci la password dell admin corrente</label>
			<input type = "password" name = "Password" required autofocus value = <?php if(isset($_POST["Password"])) echo '"'.$_POST["Password"].'"'; else echo '""'; ?>>
			<div class = "erroreDigitazione">La password inserita non è corretta</div>

			<div class="inserisci">
				<input type="submit" value="Promuovi">
			</div>
		</form>
		<!-- sezione dedicata a gestire gli errori di inserimento nel form -->
		<script>
			<?php
				if(isset($errore)){
					if($errore==11){
			?>
						document.newAdmin.Email.style.borderColor = 'red';
						document.newAdmin.Email.style.boxShadow = '0px 0px 10px red';
						document.getElementsByClassName("erroreDigitazione")[0].style.visibility='visible';
			<?php
					}
				}

				if(isset($errore)){
					if($errore==10){
			?>
						document.newAdmin.Password.style.borderColor = 'red';
						document.newAdmin.Password.style.boxShadow = '0px 0px 10px red';
						document.getElementsByClassName("erroreDigitazione")[1].style.visibility='visible';
			<?php
					}
				}
				if(isset($errore)){
					if($errore==0){
			?>
						alert("Admin aggiunto");
						location.href="./admin.php";
			<?php
					}
				}
			?>
		</script>
	</body>
</html>