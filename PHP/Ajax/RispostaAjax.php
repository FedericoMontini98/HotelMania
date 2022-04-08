
<?php
	/* Classe contenente i vari parametri contenuti in una tupla del result-set */
	class Hotel{
		public $IDHotel;
		public $Nome;
		public $Citta;
		public $Prezzo;
		public $Valutazione;

		function Hotel($IDHotel=null, $Nome=null, $Citta=null, $Prezzo=null, $Valutazione=null){
			$this->IDHotel=$IDHotel;
			$this->Nome=$Nome;
			$this->Citta=$Citta;
			$this->Prezzo=$Prezzo;
			$this->Valutazione=$Valutazione;
		}
	}
	/* AjaxResponse è la classe che verrà inviata al client ogni richiesta Ajax */
	class RispostaAjax{
		public $CodiceRisposta; /* 0: Ok 1: Errore */
		public $messaggio;
		public $data;

		function rispostaAjax($codiceRisposta=1, $messaggio="Errore"){
			$this->CodiceRisposta=$codiceRisposta;
			$this->messaggio=$messaggio;
			$this->data=null;
		}
	}

	class Prenotazione{
		public $IDPrenotazione;
		public $Cliente;
		public $Location;
		public $DataInizio;
		public $DataFine;
		public $Prezzo;
		public $Nome;
		public $Citta;
		public $Valutazione;
		public $Persone;

		function Prenotazione($IDPrenotazione=null,$Cliente=null, $Location=null, $DataInizio=null, $DataFine=null, $Prezzo=null, $Nome=null, $Citta=null, $Valutazione=null,$Persone=null){
			$this->IDPrenotazione=$IDPrenotazione;
			$this->Cliente=$Cliente;
			$this->Location=$Location;
			$this->DataInizio=$DataInizio;
			$this->DataFine=$DataFine;
			$this->Prezzo=$Prezzo;
			$this->Nome=$Nome;
			$this->Citta=$Citta;
			$this->Valutazione=$Valutazione;
			$this->Persone=$Persone;
		}
	}


?>