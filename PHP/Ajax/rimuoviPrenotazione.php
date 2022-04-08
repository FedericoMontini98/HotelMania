<?php
	session_start();
	require_once __DIR__ . "./../../config.php";
	require_once DIR_BASE . "/PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE . "/PHP/Ajax/RispostaAjax.php";

	$risposta= new RispostaAjax();

	if(!isset($_GET['IDPrenotazione'])){
		echo json_encode($risposta);
		return;
	}

	$check= checkPrenotazione($_SESSION['HotelManiaIDUtente'], $_GET['IDPrenotazione']);
	if(checkResponse($check)){
		$esito=rimuoviPrenotazione($_SESSION['HotelManiaIDUtente'], $_GET['IDPrenotazione']);
		$messaggio="OK";
		$risposta=setRisposta($esito,$messaggio);
		echo json_encode($risposta);
		return;
	}
	$risposta=setFail();
	echo json_encode($risposta);
	return;



	function checkResponse($checkPrenotazione){
		if($checkPrenotazione===null || !$checkPrenotazione)
			return false;
		if($checkPrenotazione->num_rows<=0)
			return false;
		return true;
	}

	function setRisposta($esito,$messaggio){
		return new RispostaAjax("0",$messaggio);
	}

	function setFail(){
		return new RispostaAjax("-1","Prenotazione non trovata o data non coerente");
	}
?>