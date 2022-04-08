//Funzione che segnala a schermo che le due password inserite non coincidono
function InputErrato(div){
	div.style.borderColor = 'red';
	div.style.boxShadow = '0px 0px 10px red';
	var errore=div.parentNode.getElementsByClassName("erroreDigitazione")[0];
	if(errore){
		errore.style.visibility = 'visible';
	}

}

//Funzione  che verifica se le password inserite coincidono
function valida(form){
	if(form.Password.value!=form.confermaPassword.value){
		form.confermaPassword.value='';
		form.Password.value='';
		InputErrato(form.confermaPassword);
		InputErrato(form.Password);
		return false;
	}
	return true;
}