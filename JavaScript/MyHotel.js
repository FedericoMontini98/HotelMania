function valuta(form){
	var valore=form.valutazioneStelle.value;
	if(valore>=0 && valore<=5){
		return true;
	}
	alert("Numero stelle inserite non conforme!");
	return false;
}

function settaStelle(div,valutazione){
	var stellePiene=Math.floor(valutazione);
	var stellemeta=Math.ceil(valutazione-stellePiene);
	var stellevuote=5-stellePiene-stellemeta;
	
	for(var i=0;i<stellePiene;i++){
		var stella=document.createElement("img");
		stella.setAttribute("src","./../immagini/StelleRecensione/filled-star.png");
		stella.setAttribute("alt","stellaPiena");
		stella.setAttribute("class","stellaHotel");
		div.appendChild(stella);
	}

	for(var i=0;i<stellemeta;i++){
		var stella_M=document.createElement("img");
		stella_M.setAttribute("src","./../immagini/StelleRecensione/half-star.png");
		stella_M.setAttribute("alt","stellaMeta");
		stella_M.setAttribute("class","stellaHotel");
		div.appendChild(stella_M);
	}

	for(var i=0;i<stellevuote;i++){
		var stella_V=document.createElement("img");
		stella_V.setAttribute("src","./../immagini/StelleRecensione/empty-star.png");
		stella_V.setAttribute("alt","stellaVuota");
		stella_V.setAttribute("class","stellaHotel");
		div.appendChild(stella_V);
	}
}