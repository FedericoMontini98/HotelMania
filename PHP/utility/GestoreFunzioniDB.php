<?php
//Dile contenente le funzioni per la gestione e verifica dei dati del database
require_once __DIR__ . ".\..\..\config.php";
require_once DIR_BASE . "/PHP/utility/gestoreDB.php";
require_once DIR_BASE . "/PHP/utility/sessionUtility.php";

function cercaMiglioriRecensioni(){
	global $DB;
	//Scrivo la query
	$query="SELECT * FROM Hotel ORDER BY Valutazione DESC LIMIT 3;";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}


/*Gestisci il codice Errore -- 10: carta di credito duplicata 11: codice fiscale duplicato */
function inserisciUtente($nome,$cognome,$codiceFiscale,$cartaDiCredito,$indirizzo,$citta,$email,$password){
	global $DB;
	//Proteggo i valori dalla SQLInjection
	$nome = $DB->sqlInjectionFilter($nome);
	$cognome = $DB->sqlInjectionFilter($cognome);
	$codiceFiscale = $DB->sqlInjectionFilter($codiceFiscale);
	$cartaDiCredito = $DB->sqlInjectionFilter($cartaDiCredito);
	$indirizzo = $DB->sqlInjectionFilter($indirizzo);
	$citta = $DB->sqlInjectionFilter($citta);
	$email = $DB->sqlInjectionFilter($email);
	$password= $DB->sqlInjectionFilter($password);
	//Scrivo la query
	$query="INSERT INTO Utente VALUES
			(NULL,'".$nome."','".$cognome."','".$codiceFiscale."','".$cartaDiCredito."','".$indirizzo."','".$citta."','".$email."','".$password."','NA');";
	$risultato=$DB->performQuery($query);
	$codiceErrore= $DB->getErrorNumber();
	$testoErrore= $DB->getErrorText();
	$arrayDiRitorno = array("risultato"=>$risultato, "codiceErrore"=>$codiceErrore,"testoErrore"=>$testoErrore);
	$DB->closeConnection();
	return $arrayDiRitorno;
}
/*Funzione che recupera l'ID di un utente appena registrato tramite il suo codice fiscale*/
function getIDUtente($codiceFiscale){
	global $DB;
	//Proteggo i valori dalla SQLInjection	
	$codiceFiscale= $DB->sqlInjectionFilter($codiceFiscale);
	$query = "SELECT IDUtente FROM Utente WHERE CodiceFiscale= '".$codiceFiscale."';";
	//Invio la query al db
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	//Prelevo ciò che mi interessa
	$risultato=$risultato->fetch_assoc();
	//Lo restituisco
	return $risultato['IDUtente'];
}

//Funzione chiamata in signin.php e cerca di effetturare il login con le credenziali fornite
function logIn($email, $password){
	if($email != null && $password != null){
		global $DB;
		$email = $DB->sqlInjectionFilter($email);
		$password = $DB->sqlInjectionFilter($password);
		$query = "SELECT IDUtente, Nome, _Admin FROM Utente WHERE Email='".$email."' AND Password = '".$password."';";
		//Apro una connessione e inoltro la query
		$esito=$DB->performQuery($query);
		$N_tuple = mysqli_num_rows($esito);
		$DB->closeConnection();
		//Verifico che i risultati siano consistenti
		if($N_tuple!=1)
			return "Dati inseriti non corretti";
		//Sono consistenti
		$tuplaDati=$esito->fetch_assoc();
		//Verificata l'esistenza dell'utente procedo a effettuare il login
		if(extract($tuplaDati)==3){
			if(!isset($_SESSION))
				session_start();
			setSessionID($Nome,$IDUtente);
			if($_Admin==true){
				adminLog();
			}
			return true;
		}
	}
	return 'Dati inseriti non corretti';
}

//Funzione chiamata in Find_location, ricerca hotel secondo una stringa (se inserita) 
function ricercaStringa($offset,$N_Hotel,$prov,$str){
	global $DB;
	//Proteggo i valori dalla SQLInjection	
	$offset=$DB->sqlInjectionFilter($offset);
	$N_Hotel=$DB->sqlInjectionFilter($N_Hotel);
	$prov=$DB->sqlInjectionFilter($prov);
	$query="SELECT * FROM Hotel WHERE 1=1 ";
	if($str !== null){
		$str=$DB->sqlInjectionFilter($str);
		$query = $query . "AND (Nome LIKE '%".$str."%' OR Citta LIKE '%".$str."%')";
	}
	$query= $query . " ORDER BY Valutazione DESC LIMIT ".$offset.", ".$N_Hotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function getHotel($IDHotel){
	global $DB;
	//Proteggo i valori dalla SQLInjection
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	//Preparo la query
	$query="SELECT * FROM Hotel WHERE IDHotel = ".$IDHotel.";";
	$tuple=$DB->performQuery($query);
	$DB->closeConnection();
	$risultato=$tuple->fetch_assoc();
	return $risultato;
}

function aggiungiPrenotazione($IDUtente, $dataInizio, $dataFine,$N_Persone, $IDHotel){
	global $DB;
	//Proteggo i valori dalla SQLInjection
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$dataInizio=$DB->sqlInjectionFilter($dataInizio);
	$dataFine=$DB->sqlInjectionFilter($dataFine);
	$N_Persone=$DB->sqlInjectionFilter($N_Persone);
	//Preparo la query
	$query="INSERT INTO Prenotazione VALUES (null,'".$IDUtente."','".$IDHotel."','".$dataInizio."','".$dataFine."',".$N_Persone.",CURRENT_TIMESTAMP(),null);";

	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $DB->getErrorNumber();
}

function ricercaStringaUtente($offset,$N_hotel,$str,$IDutente){
	global $DB;
	$offset=$DB->sqlInjectionFilter($offset);
	$N_hotel=$DB->sqlInjectionFilter($N_hotel);
	$IDutente=$DB->sqlInjectionFilter($IDutente);
	//Preparo la query
	$query="SELECT * FROM Prenotazione P INNER JOIN Hotel H ON H.IDHotel=P.Location WHERE 1=1 AND P.Cliente=".$IDutente." ";
	if($str !== null){
		$str=$DB->sqlInjectionFilter($str);
		$query = $query . "AND (Nome LIKE '%".$str."%' OR Citta LIKE '%".$str."%')";
	}
	$query= $query . "ORDER BY IDPrenotazione DESC LIMIT ".$offset.",".$N_hotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function checkPrenotazione($IDUtente, $IDPrenotazione){
	global $DB;
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$IDPrenotazione=$DB->sqlInjectionFilter($IDPrenotazione);
	$query="SELECT * FROM Prenotazione WHERE Cliente= ".$IDUtente."  AND IDPrenotazione= ".$IDPrenotazione." AND DataInizio>(CURRENT_DATE()+INTERVAL 1 WEEK);";

	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function rimuoviPrenotazione($IDUtente, $IDPrenotazione){
	global $DB;
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$IDPrenotazione=$DB->sqlInjectionFilter($IDPrenotazione);
	$query="DELETE FROM Prenotazione WHERE Cliente=".$IDUtente." AND IDPrenotazione= ".$IDPrenotazione.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function updateUtente($IDUtente,$nome,$cognome,$codiceFiscale,$cartaDiCredito,$indirizzo,$citta,$email){
	global $DB;
	//Proteggo i valori dalla SQLInjection
	$nome = $DB->sqlInjectionFilter($nome);
	$cognome = $DB->sqlInjectionFilter($cognome);
	$codiceFiscale = $DB->sqlInjectionFilter($codiceFiscale);
	$cartaDiCredito = $DB->sqlInjectionFilter($cartaDiCredito);
	$indirizzo = $DB->sqlInjectionFilter($indirizzo);
	$citta = $DB->sqlInjectionFilter($citta);
	$email = $DB->sqlInjectionFilter($email);
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$query="UPDATE Utente SET Nome='".$nome."', Cognome='".$cognome."', CodiceFiscale='".$codiceFiscale."', CartaDiCredito=".$cartaDiCredito.", Indirizzo='".$indirizzo."', Citta='".$citta."', Email='".$email."' WHERE IDUtente=".$IDUtente.";";
	$risultato=$DB->performQuery($query);
	$codiceErrore= $DB->getErrorNumber();
	$testoErrore= $DB->getErrorText();
	$arrayDiRitorno = array("risultato"=>$risultato, "codiceErrore"=>$codiceErrore,"testoErrore"=>$testoErrore);
	$DB->closeConnection();
	return $arrayDiRitorno;
}

function haSoggiornato($IDUtente, $IDHotel){
	global $DB;
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$query="SELECT * FROM Prenotazione WHERE Cliente=".$IDUtente." AND Location=".$IDHotel." AND DataFine < CURRENT_DATE();";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function inserisciRecensione($IDUtente,$IDHotel,$Valutazione,$Descrizione){
	global $DB;
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$Valutazione=$DB->sqlInjectionFilter($Valutazione);
	$Descrizione=$DB->sqlInjectionFilter($Descrizione);
	$query="SELECT * FROM Recensione WHERE Cliente=".$IDUtente." AND Location=".$IDHotel.";";
	$risultato=$DB->performQuery($query);
	if(!$risultato->fetch_assoc()){
		$query="INSERT INTO Recensione VALUES (".$IDUtente.",".$IDHotel.",CURRENT_TIMESTAMP(), '".$Descrizione."',".$Valutazione.");";
		$risultato=$DB->performQuery($query);
		$DB->closeConnection();
		return $risultato;
		}
	$query="UPDATE Recensione SET Descrizione='".$Descrizione."', Votazione=".$Valutazione.", Timestamp=CURRENT_TIMESTAMP() WHERE Cliente=".$IDUtente." AND Location=".$IDHotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function getRecensioni($IDHotel){
	global $DB;
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$query="SELECT * FROM Recensione R INNER JOIN Utente U ON U.IDUtente=R.Cliente WHERE Location=".$IDHotel." LIMIT 5;";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function inserisciHotel($Nome,$Citta,$Prezzo,$Descrizione){
	global $DB;
	$Nome=$DB->sqlInjectionFilter($Nome);
	$Citta=$DB->sqlInjectionFilter($Citta);
	$Prezzo=$DB->sqlInjectionFilter($Prezzo);
	$Descrizione=$DB->sqlInjectionFilter($Descrizione);

	$query="INSERT INTO Hotel VALUES (null,'".$Nome."','".$Citta."',".$Prezzo.",0,'".$Descrizione."');";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function trovaHotel($IDHotel){
	global $DB;	
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$query="SELECT * FROM Hotel WHERE IDHotel=".$IDHotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function verificaMail($Email){
	global $DB;	
	$Email=$DB->sqlInjectionFilter($Email);
	$query="SELECT * FROM Utente WHERE Email='".$Email."';";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	$esito=$risultato->fetch_assoc();
	return $esito;
}

function verificaPassword($IDUtente,$Password){
	global $DB;	
	$IDUtente=$DB->sqlInjectionFilter($IDUtente);
	$Password=$DB->sqlInjectionFilter($Password);

	$query="SELECT * FROM Utente WHERE IDUtente=".$IDUtente." AND Password='".$Password."' ;";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	$esito=$risultato->fetch_assoc();
	return $esito;
}

function impostaAdmin($Email){
	global $DB;
	$Email=$DB->sqlInjectionFilter($Email);
	$query="UPDATE Utente SET _Admin=1 WHERE Email='".$Email."';";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function aggiornaHotel($IDHotel,$Nome,$Citta,$Prezzo,$Descrizione){
	global $DB;
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);
	$Nome=$DB->sqlInjectionFilter($Nome);
	$Citta=$DB->sqlInjectionFilter($Citta);
	$Prezzo=$DB->sqlInjectionFilter($Prezzo);
	$Descrizione=$DB->sqlInjectionFilter($Descrizione);

	$query="UPDATE Hotel SET Nome='".$Nome."',Citta='".$Citta."', Prezzo=".$Prezzo.", Descrizione='".$Descrizione."' WHERE IDHotel=".$IDHotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

function haRecensioni($IDHotel){
	global $DB;
	$IDHotel=$DB->sqlInjectionFilter($IDHotel);

	$query="SELECT * FROM Recensione WHERE Location=".$IDHotel.";";
	$risultato=$DB->performQuery($query);
	$DB->closeConnection();
	return $risultato;
}

?>