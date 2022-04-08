<?php
	session_start();
	require_once __DIR__ . "/../../config.php";
	require_once DIR_BASE ."PHP/utility/gestoreDB.php";
	require_once DIR_BASE ."PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE ."PHP/utility/sessionUtility.php";
	if(!isset($_GET["c"]))
		$prov = "location";
	else
		$prov=$_GET["c"];
?>
<!DOCTYPE HTML>
<html lang ="it">
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="default-style">
	<meta name = "author" content = "Federico Montini">
	<title>HotelMania | Locations </title>
	<link rel="stylesheet" type="text/css" href="./../../css/location.css" media="screen">
	<link rel="stylesheet" type="text/css" href="./../../css/mainpage.css" media="screen">
	<!-- Inserisci gli script e eventuali altri file css -->
	<script src="./../../JavaScript/pulsanti.js"></script>
	<script src="./../../JavaScript/getResearch.js"></script>
	<script src="./../../JavaScript/Ajax/DashboardLocations.js"></script>
	<script src="./../../JavaScript/Ajax/CaricaLocation.js"></script>
	<script src="./../../JavaScript/Ajax/ajaxManager.js"></script>
</head>
<body>
	<?php
		include "./../layout/intestazione.php";
		include "./../layout/barraDiNavigazione.php";
	?>

	<div class="containerRicerca">
		<div id="barraRicerca">
			<input id="ricerca" type="text" placeholder="Cerca una location o il nome di un nostro Hotel" onkeyup="CaricaLocation.cerca('<?php echo $prov?>',this.value)">
		</div>

		<?php
			include "./../layout/pulsanti.php";
		?>
		<div class="risultatiRicerca" id="_risultatiRicerca"></div>	
		<?php
			include "./../layout/pulsanti.php";
		?>
		<script> 
			CaricaLocation.cerca('<?php echo $prov?>','');
		</script>
	</div>
</body>
</html>