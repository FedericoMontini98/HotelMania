function prenotazioni(){}

prenotazioni.METHOD="GET";
prenotazioni.ASYNC=true;
prenotazioni.SUCC="0";

prenotazioni.rimuoviPrenotazione=function(IDPrenotazione){
	var query="?IDPrenotazione=" + IDPrenotazione;
	var url_p="./../Ajax/rimuoviPrenotazione.php"+query;
	var Fun_Risposta=prenotazioni.onAjaxResponse;

	AjaxManager.performAjaxRequest(prenotazioni.METHOD,url_p,prenotazioni.ASYNC,null,Fun_Risposta);
}

prenotazioni.onAjaxResponse=function(risposta){
	if(risposta.CodiceRisposta!==CaricaLocation.SUCC)
		alert("Errore, non puoi disdire una prenotazione a meno di una settimana prima");
	else
		alert("Prenotazione disdetta consuccesso");
}