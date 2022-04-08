function DashboardPren(){}

DashboardPren.imgError = function(immagine){
	immagine.setAttribute("src","./../../immagini/error.jpg");
}

//Funzione che esegue il refresh delle Pren in base ai parametri di ricerca inseriti dall'utente
DashboardPren.aggiorna = function(data){
		DashboardPren.svuota();
		DashboardPren.aggiungiPren(data);
}

DashboardPren.svuota = function(){
	var elementoDashboard= document.getElementById("_risultatiRicerca");
	if(elementoDashboard === null)
		return;
	var primoChild=elementoDashboard.firstChild;
	while(primoChild!==null){
		elementoDashboard.removeChild(primoChild);
		primoChild=elementoDashboard.firstChild;
	}
}

//Funzione che aggiunge gli Hotel alla dashboard che rispettano i parametri di ricerca
DashboardPren.aggiungiPren=function(data){
	var elementoDashboard = document.getElementById("_risultatiRicerca");
	//Verifica integrità
	if(data===null || data.length <=0 || elementoDashboard===null){
		return;
	}
	//Creo gli oggetti "Hotel" da inserire nella dashboard
	for(i=0; i<data.length; i++){
		var elementoPren = DashboardPren.creaPren(data[i]);
		elementoDashboard.appendChild(elementoPren);
	}
}

DashboardPren.creaPren=function(prenData){
	var hotelDiv=document.createElement("div");
	hotelDiv.setAttribute("id","hotel-" + prenData.Location);
	hotelDiv.setAttribute("class","hotel");
	//Creo gli elementi
	var immagine=DashboardPren.creaImmagine(prenData);
	var descrizione=DashboardPren.creaDescrizione(prenData);
	//Li inserisco del div dell'hotel
	hotelDiv.appendChild(immagine);
	hotelDiv.appendChild(descrizione);
	return hotelDiv;
}

DashboardPren.creaImmagine=function(prenData){
	var hotelLink =document.createElement("a");
	hotelLink.setAttribute("class","hotel-link-img");
	hotelLink.setAttribute("href", "./../hotelPage.php?id=" + prenData.Location);
	//Creo l'oggetto immagine
	var immagine=document.createElement("img");
	immagine.setAttribute("onerror","DashboardPren.imgError(this)");
	immagine.setAttribute("src", "./../../immagini/hotel-" + prenData.Location+".jpg");
	immagine.setAttribute("alt", "hotel-" + prenData.Location);
	hotelLink.appendChild(immagine);

	return hotelLink;
}

DashboardPren.creaDescrizione=function(prenData){
	var divDescrizione = document.createElement("div");
	divDescrizione.setAttribute("class", "descrizione_Hotel");
	//Sezione titolo
	var linkTitolo = document.createElement("a");
	var divTitolo = document.createElement("div");
	linkTitolo.setAttribute("href", "./../hotelPage.php?id="+prenData.IDHotel);
	divTitolo.setAttribute("class","titolo_Hotel");
	divTitolo.textContent=prenData.Nome + " - " + prenData.Citta;

	var divPren = document.createElement("div");
	divPren.setAttribute("class","pren_Hotel");
	divPren.textContent="Soggiorno: " +prenData.DataInizio + " / " +prenData.DataFine;

	divDescrizione.appendChild(linkTitolo);

	var spaziatura = document.createElement("hr");
	divDescrizione.appendChild(spaziatura);

	linkTitolo.appendChild(divTitolo);
	linkTitolo.appendChild(divPren);

	//Creo lo span in cui inserire il numero di giorni
	var spanPersone=document.createElement("span");
	spanPersone.textContent="Persone:"  + prenData.Persone;
	divDescrizione.appendChild(spanPersone);

	//Creo lo span in cui inserire il numero di persone
	var spanPrezzo=document.createElement("span");
	spanPrezzo.textContent="Prezzo:"  + prenData.Prezzo;
	divDescrizione.appendChild(spanPrezzo);

	//Aggiungo un pulsante che rimuove la prenotazione
	var rimuovi=document.createElement("button");
	rimuovi.setAttribute("class","cancellaPren");
	rimuovi.setAttribute("id", "cancellaPren_"+prenData.IDPrenotazione);
	rimuovi.textContent = "Disdici";
	rimuovi.style.backgroundColor="red";
	rimuovi.addEventListener("click", function(){prenotazioni.rimuoviPrenotazione(prenData.IDPrenotazione)});

	divDescrizione.appendChild(rimuovi);
	return divDescrizione;
}

DashboardPren.naviga = function(pagina,EOD){
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
	var N_Pagina = document.getElementsByClassName("N_Pagina");
	var i=0;
	while(i<N_Pagina.length){
		N_Pagina[i].textContent="Pagina "+pagina;
		i++;
	}
}

DashboardPren.naviga = function(pagina,EOD){
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
