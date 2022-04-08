<?php
	//Inizio la sessione
	session_start();
	require_once __DIR__ . "./../../config.php";
	//Ne resetto tutte le variabili
	$_SESSION=array();
	//Chiudo la sessione
	session_destroy();
	//Ritorno alla home
	header('Location: //'.LOCAL_ROOT.'/index.php');
	exit;
?>