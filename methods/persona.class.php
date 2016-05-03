<?php
/* CLASSE PERSONA (incompleta)
 * 
 * Eredita alcune proprietà dalla classe user.
 *	L'utilità di questa classe sta nel fatto che posso salvare in modo conveniente i dati dell'utente come variabile di sessione, in modo da non dover fare le stesse query ogni volta
 *	in cui voglio visualizzare qualcosa (ex: nome dell'utente loggato, indirizzo etc...)
 *	Inoltre posso stabilire all'interno di questa classe le operazioni che si possono effettuare sull'utente loggato:
 *	ex: Registrazione, Modifica dei Dati etc...
 *
 * 
 * TODO: - metodo di delete utente
 * 
 *		
 * */

include_once('user.class.php');

class persona extends user{
	
	protected $dati = array();
	
	
	public function __construct(){}
	
	
	/* Il metodo SET esegue la select dei dati della persona dal db
	 * e li inserisce nell'array associativo "dati"
	 * 
	 */
	public function set($entryid){
			
		$this->id = $entryid;	//
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./config.php";
		require_once "./database.php";
	
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
	
		/* INSERIMENTO DATI PERSONA*/
		$sql = "SELECT NOME, COGNOME, LUOGO_NASCITA, DATA_NASCITA, SESSO,
				INDIRIZZO, CAP, CITTA, REGIONE, NAZIONE, PROVINCIA, FOTO,
				EDUCAZIONE, LAVORO, INFO, AZIENDA
				FROM PERSONE WHERE ID_UTENTE = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i', $entryid);
		$q->execute();
		$res = $q->get_result();
		$this->dati  = $res->fetch_array(MYSQLI_ASSOC);
	}
	
	public function who(){ //Ritorna nome e cognome per stampa veloce
		return $this->dati['NOME']." ".$this->dati['COGNOME']; 
	}
	
	public function register($email, $password, $nome, $cognome, $DataNascita, $sex){
		
		$this->id = $this->create($email, $password, "PERSONA");
		
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$Nome = $mysqli->real_escape_string(trim($nome));
		$Cognome = $mysqli->real_escape_string(trim($cognome));
		$Data = convertiData($mysqli->real_escape_string(trim($DataNascita)));

		$insert = "INSERT INTO PERSONE (ID_UTENTE, NOME, COGNOME, DATA_NASCITA, SESSO) VALUES (?,?,?,?,?)";
		$q1 = $mysqli->prepare($insert);
		$q1->bind_param('issss', $this->id, $Nome, $Cognome, $Data, $sex);
		if(!$q1->execute()){//Esegue la insert, se fallisce:
			throw new Exception("Errore durante la registrazione.");
		} 
	}
	
	public function setNome($Nome){
		
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
				
		$update= "UPDATE PERSONE SET NOME=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Nome, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
		
	}
	
	public function setCognome($Cognome){
		
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
				
		$update= "UPDATE PERSONE SET COGNOME=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Cognome, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
		
	}
	
	
	public function setPhoto($NuovaFoto){

		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET FOTO=? WHERE ID_UTENTE = ?";
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
		
		$update= "UPDATE PERSONE SET INDIRIZZO=?, CAP=?, CITTA=?, REGIONE=?,  NAZIONE=?, PROVINCIA=?
				WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('ssssssi', $via, $cap, $citta, $regione, $nazione, $provincia, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setLuogoNascita($Luogo){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET LUOGO_NASCITA=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Luogo, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setDataNascita($data){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET DATA_NASCITA=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $data, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);	
	}
	
	
	public function setSex($Sex){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET SESSO=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Sex, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setEducation($Educazione){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET EDUCAZIONE=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Educazione, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setJob($Lavoro){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET LAVORO=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Lavoro, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setInfo($info){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET INFO=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $info, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}
	
	
	public function setAzienda($Azienda){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$update= "UPDATE PERSONE SET AZIENDA=? WHERE ID_UTENTE = ?";
		$q1 = $mysqli->prepare($update);
		$q1->bind_param('si', $Azienda, $this->id);
		$q1->execute(); //Esegue l'update
		$this->set($this->id);
	}	
	
	/* La funzione getDati ritorna l'array associativo contenente i dati della persona
	 * 
	 * Ex: persona->getDati()["NOME"] è il nome della persona */
	public function getDati(){
		return $this->dati;
	
	}
}





?>
