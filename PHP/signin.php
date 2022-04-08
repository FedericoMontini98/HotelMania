<!-- Lato server -->
<?php
	session_start();

	require_once __DIR__ . ".\..\config.php";
	require_once DIR_BASE . "PHP\utility\gestoreDB.php";
	require_once DIR_BASE . "PHP\utility\sessionUtility.php";
	require_once DIR_BASE . "PHP\utility\GestoreFunzioniDB.php";

	//Verifico se è già stato fatto un login
	if(logged()){
		//Ritorno alla pagina index
		header('Location: //'.LOCAL_ROOT.'/index.php');
		exit;
	}
	$errore=null;
	//Verifico le credenziali fornite
	if(isset($_POST["Email"])&&isset($_POST["Password"])){
		//Tento il login con le credenziali fornite
		$errore=logIn($_POST["Email"],$_POST["Password"]);
		//Login eseguito con successo ritorno all'index
		if($errore === true){
			header('Location: //'.LOCAL_ROOT.'/index.php');
			exit;
			}
		//Ce stato un errore, lo mostro a schermo
		else
			echo '<script> alert("'.$errore.'"); </script>';
	}

?>

<!-- Lato Client -->
<!DOCTYPE HTML>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta name = "author" content = "Federico Montini">
	<title>HotelMania | Sign In </title>
	<link rel="stylesheet" type="text/css" href="./../css/signin.css" media="screen">
</head>
<body>
	<?php
		include "./layout/intestazione.php";
	?>
	<div id="contenitore_SignInForm" class="contenitore-SignInForm">
		<p> Bentornato!</p>
		<form id="signInForm" name="_signInForm" action = "//<?php echo LOCAL_ROOT.'/PHP/signin.php'?>" method="POST">
			<div class="registro">
				<label> Email: </label>
				<input type= "email" name="Email" value = <?php if(isset($_POST["Email"])) echo '"'.$_POST["Email"].'"'; else echo '""';?> required autofocus>
			</div>
			<div class="registro">
				<label> Password: </label>
				<input type= "password" name="Password" value = <?php if(isset($_POST["Password"])) echo '"'.$_POST["Password"].'"'; else echo '""';?> required>
			</div>

			<div class= "pulsanteLogIn">
				<input class ="login_Button" type="submit" value="Entra!">
			</div>
		</form>
		<a class="ref_reg" href="./signup.php">Non sei ancora registrato? Fallo adesso!</a>
	</div>
</body>
</html>
