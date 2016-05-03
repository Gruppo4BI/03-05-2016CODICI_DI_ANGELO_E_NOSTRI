<?php
include_once('user.class.php');
class azienda extends user{
	public function __costruct(){}
	/* funzione per impostare i dati nell'azienda se non è gia registrata */
	public function set($entryid)
	{
		$this->id = $entryid;	
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./config.php";
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		/* INSERIMENTO DATI PERSONA*/
		$sql = "SELECT RAGIONE_SOCIALE,PARTITA_IVA, INDIRIZZO,NUMERO_CIVICO,
		 CAP, CITTA, REGIONE, NAZIONE, NOME, FOTO, DESCRIZIONE 
		FROM AZIENDE JOIN PROVINCE ON PROVINCIA=CODICE 
		WHERE ID_UTENTE = '".$entryid."';";
		$q = $mysqli->query($sql);
		$this->dati = $q->fetch_assoc();
		
		
	}

	public function who(){ //Ritorna nome e cognome per stampa veloce
		return $this->dati['RAGIONE_SOCIALE'];
	}
	public function setNome($Nome){
	
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		$update= "UPDATE AZIENDE SET RAGIONE_SOCIALE=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Nome, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	
	}
	
	public function setPartitaIva($Partita_iva){
	
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		$update= "UPDATE AZIENDE SET PARTITA_IVA=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Partita_iva, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	
	}
	public function setPhoto($NuovaFoto){
	
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		$update= "UPDATE AZIENDE SET FOTO=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $NuovaFoto, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	
	}
	public function setIndirizzo($via,$cap,$citta,$regione,$nazione,$provincia){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		$update= "UPDATE AZIENDE SET INDIRIZZO=?, CAP=?, CITTA=?, REGIONE=?,  NAZIONE=?, PROVINCIA=?
		WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('ssssssi', $via, $cap, $citta, $regione, $nazione, $provincia, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	public function setDescrizione($NuovaDescrizione){
	
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		$update= "UPDATE AZIENDE SET DESCRIZIONE=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $NuovaDescrizione, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
}