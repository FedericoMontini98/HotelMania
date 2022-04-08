<?php
//Sezione dedicata al caricamento dei 3 hotel con recensioni migliori nella dashboard di index.php

//Le funzioni che vengono richiamate sono definite dentro Find_Location.php
	require_once __DIR__ ."./../../config.php";
	require_once DIR_BASE . "/PHP/utility/GestoreFunzioniDB.php";
	require_once DIR_BASE . "/PHP/Ajax/RispostaAjax.php";

	$rispostaBest=new RispostaAjax();
	$tuple=cercaMiglioriRecensioni();
	//Verifico che ci siano dei risultati
	if($tuple === null || !$tuple){
		$risultato = impostaVuota();
		echo json_encode($risultato);
		return;
	}
	//Restituisco i risultati
	$messaggio="OK";
	$rispostaX=impostaRisposta($tuple,$messaggio);
	echo json_encode($rispostaX);
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
?>