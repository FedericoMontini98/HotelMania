//Sezione dedicata alla dashboard delle location da visualizzare nella pagina "location.php", deve contenere le varie location trovate dalla ricerca

function DashboardLocations(){}

//Funzione che aggiunge gli Hotel alla dashboard che rispettano i parametri di ricerca
DashboardLocations.aggiungiLocation=function(data,pren){
	var elementoDashboard = document.getElementById("_risultatiRicerca");
	//Verifica integrità
	if(data===null || data.length <=0 || elementoDashboard===null){
		return;
	}
	//Creo gli oggetti "Hotel" da inserire nella dashboard
	for(i=0; i<data.length; i++){
		var elementoHotel = DashboardLocations.creaHotel(data[i],pren);
		elementoDashboard.appendChild(elementoHotel);
	}
}

//Funzione che crea gli elementi hotel da inserire nella dashboard
DashboardLocations.creaHotel=function(hotelData,pren){
	var hotelDiv=document.createElement("div");
	hotelDiv.setAttribute("id","hotel-" + hotelData.IDHotel);
	hotelDiv.setAttribute("class","hotel");
	//Creo gli elementi
	var immagine=DashboardLocations.creaImmagine(hotelData,pren);
	var descrizione=DashboardLocations.creaDescrizione(hotelData);
	//Li inserisco del div dell'hotel
	hotelDiv.appendChild(immagine);
	hotelDiv.appendChild(descrizione);
	return hotelDiv;
}

DashboardLocations.creaDescrizione = function(hotelData){
	var divDescrizione = document.createElement("div");
	divDescrizione.setAttribute("class", "descrizione_Hotel");
	//Sezione titolo
	var linkTitolo = document.createElement("a");
	var divTitolo = document.createElement("div");
	linkTitolo.setAttribute("href", "./../hotelPage.php?id="+hotelData.IDHotel);
	divTitolo.setAttribute("class","titolo_Hotel");
	divTitolo.textContent=hotelData.Nome + " - " + hotelData.Citta;

	linkTitolo.appendChild(divTitolo);
	divDescrizione.appendChild(linkTitolo);

	var spaziatura = document.createElement("hr");
	divDescrizione.appendChild(spaziatura);

	//Inserisco il voto in stelle dell'hotel
	var divValut = document.createElement("div");
	divValut.setAttribute("class","valutazione");
	divValut.setAttribute("id","valutazione_ID_"+hotelData.IDHotel);

	//Creo lo span in cui inserire il testo antecedente la valutazione
	var spanVault=document.createElement("span");
	spanVault.textContent="Il parere dei clienti:";
	divDescrizione.appendChild(spanVault);

	//Prelevo il numero di valutazione intero
	var StelleIntere=Math.floor(hotelData.Valutazione);
	//Prelevo le eventuali mezze stelle
	var Stelle_aMeta=Math.ceil(hotelData.Valutazione - StelleIntere);
	//Calcolo il numero di stelle vuote
	var StelleVuote=5-Stelle_aMeta-StelleIntere;

	//Inserisco ciclicamente il numero di immagini di stelle individuato
	var i=0;
	while(i<StelleIntere){
		var stelleHotel_P = document.createElement("img");
		stelleHotel_P.setAttribute("src","./../../immagini/StelleRecensione/filled-star.png");
		stelleHotel_P.setAttribute("class","filled_star");
		stelleHotel_P.setAttribute("alt","stella_intera");
		divValut.appendChild(stelleHotel_P);
		i++;
	}
	i=0;
	while(i<Stelle_aMeta){
		var stelleHotel_M = document.createElement("img");
		stelleHotel_M.setAttribute("src","./../../immagini/StelleRecensione/half-star.png");
		stelleHotel_M.setAttribute("class","half_star");
		stelleHotel_M.setAttribute("alt","stella_meta");
		divValut.appendChild(stelleHotel_M);
		i++;
	}
	i=0;
	while(i<StelleVuote){
		var stelleHotel_V = document.createElement("img");
		stelleHotel_V.setAttribute("src","./../../immagini/StelleRecensione/empty-star.png");
		stelleHotel_V.setAttribute("class","empty_star");
		stelleHotel_V.setAttribute("alt","stella_vuota");
		divValut.appendChild(stelleHotel_V);
		i++;
	}
	divDescrizione.appendChild(divValut);
	return divDescrizione;
}

//Funzione che crea l'elemento img e associa l'immagine corrispondente
DashboardLocations.creaImmagine=function(hotelData,pren){
	var hotelLink =document.createElement("a");
	hotelLink.setAttribute("class","hotel-link-img");
	//pren è una variabile che tiene conto della pagina da cui sto accedendo alla pagina dell'hotel, mi permette di ritornare alla pagina corretta
	var precPag = (pren) ? "pren" : "loc";
	hotelLink.setAttribute("href", "./../hotelPage.php?id=" + hotelData.IDHotel + "&prec=" + precPag);
	//Creo l'oggetto immagine
	var immagine=document.createElement("img");
	immagine.setAttribute("onerror","DashboardLocations.imgError(this)");
	immagine.setAttribute("src", "./../../immagini/hotel-" + hotelData.IDHotel+".jpg");
	immagine.setAttribute("alt", "hotel-" + hotelData.IDHotel);
	hotelLink.appendChild(immagine);

	return hotelLink;
}

DashboardLocations.imgError = function(immagine){
	immagine.setAttribute("src","./../../immagini/error.jpg");
}

//Funzione che esegue il refresh delle locations in base ai parametri di ricerca inseriti dall'utente
DashboardLocations.aggiorna = function(data,pren){
		DashboardLocations.svuota();
		DashboardLocations.aggiungiLocation(data,pren);
}

//Mostra la dashboard vuota con uno warning
DashboardLocations.impostaVuota =function(){
	DashboardLocations.svuota();
	//Creo lo warning
	var warningDiv = document.createElement("div");
	warningDiv.setAttribute("class", "warning");
	var warningSpan =  document.createElement("span");
	warningSpan.textContent = "Locations terminate :(";

	//Inserisco i vari elementi nell'elemento _risultatiRicerca di location.php
	warningDiv.appendChild(warningSpan);
	var risultatiRicerca= document.getElementById("_risultatiRicerca");
	risultatiRicerca.appendChild(warningDiv);
}

//Svuota la dashboard
DashboardLocations.svuota = function(){
	var elementoDashboard= document.getElementById("_risultatiRicerca");
	if(elementoDashboard === null)
		return;
	var primoChild=elementoDashboard.firstChild;
	while(primoChild!==null){
		elementoDashboard.removeChild(primoChild);
		primoChild=elementoDashboard.firstChild;
	}
}

//Funzione che si occupa di gestire i pulsanti nel caso ci siano o non ci siano altre location da mostrare, EOD: End of Data, pagina: pagina attuale
DashboardLocations.naviga = function(pagina,EOD){
	//Gestisco il pulsante per tornare indietro tra le pagine
	var indietro= document.getElementsByClassName("prec");
	for(var i=0;i<indietro.length;i++){
		if(pagina===1)
			indietro[i].disabled=true;
		else
			indietro[i].disabled=false;
	}
	//Gestisco il pulsante per andare avanti tra le pagine
	var avanti = document.getElementsByClassName("succ");
	for(var i=0;i<avanti.length;i++){
		if(EOD)
			avanti[i].disabled=true;
		else
			avanti[i].disabled=false;
	}
	//Aggiorno il numero di pagina
	var N_Pagina = document.getElementsByClassName("N_pagina");
	var i=0;
	while(i<N_Pagina.length){
		N_Pagina[i].textContent="Pagina "+pagina;
		i++;
	}
}