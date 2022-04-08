<?php
	//File contenente funzioni che si occupano di gestire la connessione col database
	require_once __DIR__ ."/../../config.php";
	//File contenente le credenziali per accedere al DB
	require_once DIR_BASE . "PHP/utility/configurazioneDB.php";

	//Alloco classe
	$DB = new gestoreDB();

	//Definisco la classe che utilizzerò per gestire il Database
	class gestoreDB{
		private $sql_connection = null;
		function gestoreDB(){
			$this->openConnection();
		}

		function openConnection(){
			//Verifico se sono già connesso
			if($this->sql_connection == null){
				global $hostDB;
				global $usernameDB;
				global $passwordDB;
				global $nomeDB;
				//Tento di aprire la connessione
				$this->sql_connection = new mysqli($hostDB, $usernameDB, $passwordDB);
				//Se fallisco mostro errore e termino
				if($this->sql_connection->connect_error)
					die('Errore durante la connessione (' . $this->sql_connection->connect_errno . ') ' . $this->sql_connection->connect_error);
				//Sono connesso scelgo il DB
			    $this->sql_connection->select_db($nomeDB) or
			    	die('Errore nella scelta del DB: ' . mysqli_error());
			}
		}

		//Funzione che esegue la query
		function performQuery($query){
			//La connessione è aperta?
			if($this->sql_connection == null){
				//No la apro
				$this->openConnection();
			}
			return $this->sql_connection->query($query);
		}

		//Funzione che si occupa di evitare casi di SQLInjection filtrando il parametro
		function sqlInjectionFilter($parametro){
			//La connessione è aperta?
			if($this->sql_connection == null){
				//No la apro
				$this->openConnection();
			}
			return $this->sql_connection->real_escape_string($parametro);
		}

		//estrae il codice dell'errore generato
		function getErrorNumber(){
			if($this->sql_connection == null)
				return null;
			return $this->sql_connection->errno;
		}
		//estrae il testo dell'errore generato
		function getErrorText(){
			if($this->sql_connection == null)
				return null;
			return $this->sql_connection->error;
		}

		function closeConnection(){
			if($this->sql_connection !== null)
				$this->sql_connection->close();
			$this->sql_connection = null;
		}
	}
?>