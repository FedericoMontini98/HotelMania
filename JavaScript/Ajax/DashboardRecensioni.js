//In questo file mi occupo di gestire la dashboard delle camere con le migliori recensioni
//in questo file creerò tutte le funzioni necessarie ad aggiungere rimuovere ed aggiornare
//la dashboard
function DashboardRecensioni(){}

DashboardRecensioni.inserisci = function(data){
	var dashboard = document.getElementById("_bestLocation");
	//Verifica correttezza parametri
	if (dashboard === null || data === null || data.length <= 0)
			return;
	//Procedo a creare gli elementi-hotel con le recensioni migliori
	for(i=0;i<data.length;i++){
		var elemento = DashboardRecensioni.creaElementoHotel(data[i]);
		dashboard.appendChild(elemento);
	}
}

DashboardRecensioni.creaElementoHotel = function(data,indice){
	//Creo il div per ogni elemento-hotel
	var hotelDiv = document.createElement("div");
	hotelDiv.setAttribute("class","homeHotel");
	hotelDiv.setAttribute("id","hotel-" + data.IDHotel);
	hotelDiv.appendChild(DashboardRecensioni.creaElemento(data,i));
	return hotelDiv;
}	

//Creo i singoli elementi hotel
DashboardRecensioni.creaElemento=function(data,indice){
	//Creo il div in cui inserire l'elemento
	var divLink= document.createElement("a");
	divLink.setAttribute("class", "link-Immagine-Hotel");
	//Link di referenza alla pagina dedicata all'hotel
	divLink.setAttribute("href", "./PHP/hotelPage.php?id=" + data.IDHotel);

	//Gli attribuisco l'immagine da mostrare
	var immagine=document.createElement("img");
	immagine.setAttribute("alt", "hotel-"+data.IDHotel);
	immagine.setAttribute("src", "./immagini/hotel-"+data.IDHotel+".jpg");
	immagine.setAttribute("onerror", "DashboardRecensioni.imgError(this)");

	//Li posiziono ordinatamente nella classifica delle votazioni
	var posizionamento = document.createElement("p");
	posizionamento.setAttribute("id","votes-" + (i+1));
	posizionamento.setAttribute("class","ranking");
	posizionamento.textContent= "Posizione: "+ (i+1);

	var infos = document.createElement("div");
	infos.setAttribute("class","info");
	var nome=document.createElement("p");
	var luogo=document.createElement("p");
	var hr=document.createElement("hr");
	nome.textContent=data.Nome;
	luogo.textContent=data.Citta;
	infos.appendChild(nome);
	infos.appendChild(hr);
	infos.appendChild(luogo);

	divLink.appendChild(posizionamento);
	divLink.appendChild(immagine);
	divLink.appendChild(infos);
	return divLink;
}

DashboardRecensioni.imgError=function(immagine){
	immagine.setAttribute("src","/Progetto_Montini/immagini/error.jpg");
}

DashboardRecensioni.aggiorna = function(data){
	//Svuoto la dashboard e la ricarico
	DashboardRecensioni.svuota();
	DashboardRecensioni.inserisci(data);
}

//Funzione adibita a mostrare la dashboard vuota
DashboardRecensioni.setEmpty=function(){
	//Svuoto la dashboard
	DashboardRecensioni.svuota();

	//Creo un messaggio da mostrare
	var divMessaggio = document.createElement("div");
	divMessaggio.setAttribute("class","warning");

	var spanMessaggio = document.createElement("span");
	spanMessaggio.textContent= "Migliori Hotel terminati";
	//Inserisco lo span dentro il div
	divMessaggio.appendChild(spanMessaggio);
	//Prendo un elemento della dashboard
	RICONTROLLA
	var elemento = document.getElementById("_bestLocation");
	//Inserisco il codice sopra creato
	elemento.appendChild(divMessaggio);
}

//rimuove tutti gli elementi dalla dashboard
DashboardRecensioni.svuota=function(){
	//Prendo gli elementi nella dashboard
	var dash = document.getElementById("_bestLocation")
	//Se è già vuota smetto
	if(dash===null) return;
	//Altrimenti rimuovo
	var primoElemento=dash.firstChild;
	while(primoElemento!==null){
		dash.removeChild(primoElemento);
		primoElemento=dash.firstChild;
	}
}


