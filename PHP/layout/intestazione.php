
<?php
	//File di configurazione dell'Header, questo header è posto in comune con tutte le pagine del sito
	require_once __DIR__ . "./../../config.php";
	require_once DIR_BASE . "/PHP/utility/sessionUtility.php";
?>

<header>
	<div id = "titolo_Header">
		<div class="elemento">
			<a href="//<?php echo LOCAL_ROOT;?>/index.php" id = "logoHotelMania">
				<img src = "//<?php echo LOCAL_ROOT; ?>/immagini/icona.png" alt="icona" id="icona">
			</a>
		</div>
		<div class="elemento">
			<a href="//<?php echo LOCAL_ROOT;?>/index.php" id ="titoloHotelMania">
				<h1>HotelMania</h1>
			</a>
		</div>
		<div class= "welcomingContainer">
			<?php
				//Se la sessione non è ancora stata iniziata setto la variabile $_SESSION
				if(!isset($_SESSION))
					session_start();
				//Verifico se è stato fatto l'accesso, nel caso mostro il messaggio di benvenuto
				if(logged()){
			?>
				<div class = "welcoming">
					<p>Benvenuto/a!</p>
					<p><?php echo $_SESSION['nomeUtente']?></p>

				</div>
			<?php
				}
			?>
		</div>
	</div>
</header>