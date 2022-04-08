<?php 				//File che si occupa di gestire la sessione
	//La funzione setSessionID si occupa di settare la variabile $_SESSION correttamente
	function setSessionID($nome,$IDUtente){
		$_SESSION['nomeUtente']=$nome;
		$_SESSION['HotelManiaIDUtente']=$IDUtente;
	}

	//Funzione che si occupa di eseguire l'accesso come Admin
	function adminLog(){
		//Generata tramite Random.org
		$codiceAdmin='EGBXm5kVH57fWJ';
		$_SESSION['admin'] = $codiceAdmin;
	}

	//Funzione che si occupa di verificare se l'utente che ha fatto l'accesso è l'admin. Restituisce true se vero, false altrimenti
	function isAdmin(){
		//Generata tramite Random.org
		$codiceAdmin = 'EGBXm5kVH57fWJ';
		if(isset($_SESSION['admin']) && $_SESSION['admin'] = $codiceAdmin)
			return true;
		return false;
	}

	//Funzione logged: si occupa di verificare se l'utente ha fatto il login, necessario per l'accesso a determinate funzionalità. Nel caso restituisce il valore di 'HotelManiaIDUtente'
	function logged(){
		if(isset($_SESSION['HotelManiaIDUtente']) && isset($_SESSION['nomeUtente'])){
			return $_SESSION['HotelManiaIDUtente'];
		}
		return false;
	}