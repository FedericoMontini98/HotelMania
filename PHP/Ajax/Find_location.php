<?php
 	//File chiamato dalla funzione caricadati in CaricaLocation.js
	session_start();
	require_once __DIR__ ."./../../config.php";
	require_once DIR_BASE . "/PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE . "/PHP/Ajax/RispostaAjax.php";

	$risposta=new RispostaAjax();
	//verifico sia settati i parametri fondamentali
	if(!isset($_GET['N_hotel']) || !isset($_GET['offset']))
	{
		echo json_encode($risposta);
		return;
	}
	$prov=null;
	if(isset($_GET['prov']))
		$prov=$_GET['prov'];

	$str=null;
	if(isset($_GET['str']))
		$str=$_GET['str'];
	$N_hotel=$_GET['N_hotel'];
	$offset=$_GET['offset'];

	if(isset($_GET['IDutente']))
		$IDutente=$_GET['IDutente'];

	//Se vengo dalla sezione prenotazione devo eseguire la query con l'IDUtente
	if($prov=="pren")
		$tuple=ricercaStringaUtente($offset,$N_hotel,$str,$IDutente);
	else
		$tuple=ricercaStringa($offset,$N_hotel,$prov,$str);
	if($tuple===null || !$tuple){
		$risposta=impostaVuota();
		echo json_encode($risposta);
		return;
	}
	if($tuple->num_rows<=0){
		$risposta=impostaVuota();
		echo json_encode($risposta);
		return;
	}
	$messaggio="OK";

	if($prov=="pren")
		$risposta=impostaRispostaPren($tuple,$messaggio);
	else
		$risposta=impostaRisposta($tuple,$messaggio);
	echo json_encode($risposta);
	return;

	function impostaVuota(){
		$messaggio="Hotel terminati";
		return new RispostaAjax("-1",$messaggio);
	}

	function impostaRisposta($tuple, $messaggio){
		$risposta=new RispostaAjax("0",$messaggio);
		$indice = 0;
		while($riga = $tuple->fetch_assoc()){
			$hotel = new Hotel($riga["IDHotel"], $riga["Nome"], $riga["Citta"], 
								$riga["Prezzo"], $riga["Valutazione"]);

			$risposta->data[$indice] = $hotel;
			$indice++;
		}
		return $risposta;
	}

	function impostaRispostaPren($tuple,$messaggio){
		$risposta=new RispostaAjax("0",$messaggio);
		$indice = 0;
		while($riga = $tuple->fetch_assoc()){
			$prenotazione = new Prenotazione($riga["IDPrenotazione"], $riga["Cliente"], $riga["Location"], 
								$riga["DataInizio"], $riga["DataFine"], $riga["Prezzo"], $riga["Nome"], $riga["Citta"], $riga["Valutazione"],$riga["N_Persone"]);
			$risposta->data[$indice] = $prenotazione;
			$indice++;
		}
		return $risposta;
	}
?>