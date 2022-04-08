//File che si occupa di gestire il caricamento della Dashboard contenente le location meglio recensite
function CaricaLocation(){}

CaricaLocation.init=function(){
	CaricaLocation.ACT_PAGE=1;
}

CaricaLocation.METHOD = "GET";
CaricaLocation.ASYNC= true;

//Funzione che si occupa di interpretare la risposta e di chiamare le funzioni relative di aggiornamento
CaricaLocation.onAjaxResponse=function(response){
	//Successo
	if(response.CodiceRisposta==="0")
		DashboardRecensioni.aggiorna(response.data);
	//Dati finiti
	if(response.CodiceRisposta==="1")
		DashboardRecensioni.setEmpty(response.message);
}


CaricaLocation.carica = function(){
	//Preparo la query
	var url = "./PHP/Ajax/bestLocation.php";
	var _response=CaricaLocation.onAjaxResponse;
	//Inoltro la richiesta
	AjaxManager.performAjaxRequest(CaricaLocation.METHOD,url,CaricaLocation.ASYNC,null,_response);
}

/*******************************************************/
/*************   SEZIONE LOCATION.PHP  *****************/
/*******************************************************/

CaricaLocation.ACT_PAGE=1;
CaricaLocation.N_HOTEL_RICERCA=9;
CaricaLocation.EOD="-1";
CaricaLocation.SUCC="0";

//Funzione di ricerca della pagina "location.php" e "prenotazioni.php", tipo di ricerca differenziata dal
//Parametro prov che indica da quale pagina stiamo cercando di fare la ricerca
CaricaLocation.cerca=function(prov,stringa){
	//Caso generico, ho appena cliccato su "le nostre locations"
	if(stringa.length===0 || stringa === ''){
		stringa=null;
	}
	if(prov === "location"){
		prov=null;
	}
	//Nuova ricerca restart del contatore delle pagine
	CaricaLocation.ACT_PAGE=1;
	CaricaLocation.caricaDati(prov, stringa);
}

//Funzione che individua un determinato tipo di location
CaricaLocation.caricaDati=function(prov=null,stringa=null,IDUtente=null){
	//Preparo la query della ricerca
	var query="?N_hotel=" + CaricaLocation.N_HOTEL_RICERCA + "&offset=" + (CaricaLocation.ACT_PAGE -1) * CaricaLocation.N_HOTEL_RICERCA;
	if(prov!==null)
		query+=("&prov=" + prov);
	if(stringa!==null && stringa!=='')
		query+=("&str=" + stringa);
	if(IDUtente!==null)
		query+=("&IDUtente=" + IDUtente);
	var url;
	var Funz_risposta;
	//Caso accesso da GestisciPrenotazioni.php
	if(IDUtente!==null){
		Funz_risposta=CaricaLocation.onAjaxResponsePrenotazioni;
	}
	//Caso accesso da location.php
	else{
		Funz_risposta=CaricaLocation.onAjaxResponse_loc;
	}
	url="./../Ajax/Find_location.php"+query;
	//Invio la richiesta
	AjaxManager.performAjaxRequest(CaricaLocation.METHOD,url,CaricaLocation.ASYNC,null,Funz_risposta);
}

CaricaLocation.onAjaxResponse_loc=function(risposta){
	//Non ho nessun dato di questo tipo
	if(risposta.CodiceRisposta===CaricaLocation.EOD && CaricaLocation.ACT_PAGE ===1){
		DashboardLocations.impostaVuota();
		DashboardLocations.naviga(CaricaLocation.ACT_PAGE,true);
		return;
	}
	//Ci sono risultati
	if(risposta.CodiceRisposta===CaricaLocation.SUCC){
		DashboardLocations.aggiorna(risposta.data , false);
		}
	var EOD=(risposta.data===null || risposta.data.length < CaricaLocation.N_HOTEL_RICERCA);
	DashboardLocations.naviga(CaricaLocation.ACT_PAGE,EOD);
	if(risposta.data===null)
		DashboardLocations.impostaVuota(risposta.messaggio);
}

/*******************************************************/
/********   SEZIONE GestisciPrenotazioni.PHP  **********/
/*******************************************************/

CaricaLocation.cercaPren=function(prov,stringa,IDUtente){
	//Caso generico, ho appena cliccato su "le nostre locations"
	if(stringa.length===0 || stringa === ''){
		stringa=null;
	}
	if(prov === "location"){
		prov=null;
	}
	//Nuova ricerca restart del contatore delle pagine
	CaricaLocation.ACT_PAGE=1;
	CaricaLocation.caricaDatiPren(prov, stringa,IDUtente);
}

//Funzione che individua un determinato tipo di location
CaricaLocation.caricaDatiPren=function(prov=null,stringa=null,IDUtente=null){
	//Preparo la query della ricerca
	var query="?N_hotel=" + CaricaLocation.N_HOTEL_RICERCA + "&offset=" + (CaricaLocation.ACT_PAGE -1) * CaricaLocation.N_HOTEL_RICERCA;
	if(prov!==null)
		query+=("&prov=" + prov);
	if(stringa!==null && stringa!=='')
		query+=("&str=" + stringa);
	if(IDUtente!==null)
		query+=("&IDutente=" + IDUtente);
	var url_p;
	var Funz_risposta_p;
	//Caso accesso da GestisciPrenotazioni.php
	Funz_risposta_p=CaricaLocation.onAjaxResponse_Pren;
	url_p="./../Ajax/Find_location.php" + query;
	//Invio la richiesta
	AjaxManager.performAjaxRequest(CaricaLocation.METHOD,url_p,CaricaLocation.ASYNC,null,Funz_risposta_p);
}

CaricaLocation.onAjaxResponse_Pren=function(risposta){
	//Non ho nessun dato di questo tipo
	if(risposta.CodiceRisposta===CaricaLocation.EOD && CaricaLocation.ACT_PAGE ===1){
		DashboardLocations.impostaVuota();
		DashboardLocations.naviga(CaricaLocation.ACT_PAGE,true);
		return;
	}
	//Ci sono risultati
	if(risposta.CodiceRisposta===CaricaLocation.SUCC){
		DashboardPren.aggiorna(risposta.data);
		}
	var EOD=(risposta.data===null || risposta.data.length < CaricaLocation.N_HOTEL_RICERCA);
	DashboardPren.naviga(CaricaLocation.ACT_PAGE,EOD);
	if(risposta.data===null)
		DashboardLocations.impostaVuota(risposta.messaggio);
}

//Vado indietro tra le pagine
CaricaLocation.prec=function(prov,pattern){
	//Torno ad inizio pagina
	scrollTo(0,0);

	if(CaricaLocation.ACT_PAGE>1)
		CaricaLocation.ACT_PAGE--;
	CaricaLocation.caricaDati(prov,pattern,null);
}

//Vado avanti tra le pagine
CaricaLocation.succ = function(prov,pattern){
	//Torno ad inizio pagina
	scrollTo(0,0);
	CaricaLocation.ACT_PAGE++;
	CaricaLocation.caricaDati(prov,pattern,null);
}	

//Vado indietro tra le pagine prenotazioni
CaricaLocation.precPren=function(prov,pattern,IDUtente){
	//Torno ad inizio pagina
	scrollTo(0,0);

	if(CaricaLocation.ACT_PAGE>1)
		CaricaLocation.ACT_PAGE--;
	CaricaLocation.caricaDatiPren(prov,pattern,IDUtente);
}

//Vado avanti tra le pagine prenotazioni
CaricaLocation.succPren = function(prov,pattern,IDUtente){
	//Torno ad inizio pagina
	scrollTo(0,0);
	CaricaLocation.ACT_PAGE++;
	CaricaLocation.caricaDatiPren(prov,pattern,IDUtente);
}	