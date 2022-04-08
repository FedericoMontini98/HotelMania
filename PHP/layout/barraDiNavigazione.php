<!-- File adibito alla creazione della barra di navigazione -->
<?php
	require_once __DIR__ . "./../../config.php";
	require_once DIR_BASE . "/PHP/utility/sessionUtility.php";
?>

<div class = "barra_navigazione">
	<!-- Verifico che la sessione sia stata startata -->
	<?php
		if(!isset($_SESSION))
			session_start();
	?>
	<!-- Sezione di destra del menù di navigazione, deve comparire solo se non è ancora stato effettuato il Login -->
	<?php
	if(!logged()){
	?>
		<div id="Login" class = "rightSection">
			<a class="nav" href = "//<?php echo LOCAL_ROOT;?>/PHP/signin.php">Login
			</a>
		</div>
		<div id="Register" class = "rightSection">
			<a class="nav" href = "//<?php echo LOCAL_ROOT; ?>/PHP/signup.php">Registrati
			</a>
		</div>
	<!-- Nel caso in cui sia stato fatto il login devo mostrare le opzioni per il logout e per la gestione delle prenotazioni -->
	<?php
	}
	else{
	?>
		<div id="Logout" class = "rightSection">
			<a class="nav" href = "//<?php echo LOCAL_ROOT;?>/PHP/utente/logout.php">Logout
			</a>
		</div>
		<div id="Prenotazioni" class = "rightSection">
			<a class="nav" href = "//<?php echo LOCAL_ROOT;?>/PHP/utente/GestisciPrenotazioni.php">Prenotazioni
			</a>
		</div>
	<!-- Sezione dedicata all'admin -->
	<?php
	}
	if(isAdmin()){
	?>
		<div id="Admin" class = "rightSection">
			<a href = "//<?php echo LOCAL_ROOT;?>/PHP/admin/Admin.php">Admin
			</a>
		</div>
	<?php 
	}
	?>
	<!-- Sezione di sinistra del menù di navigazione -->
	<div id="Homepage" class = "leftSection">
		<a class="nav" href = "//<?php echo LOCAL_ROOT;?>/index.php">HomePage
		</a>
	</div>
	<div id="location" class = "leftSection">
		<a class="nav" href = "//<?php echo LOCAL_ROOT;?>/PHP/utente/location.php">Le nostre Location
		</a>
	</div>
</div>