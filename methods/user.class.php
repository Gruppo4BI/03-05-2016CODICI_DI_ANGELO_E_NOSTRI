<?php
/* CLASSE UTENTE PER L'IDENTIFICAZIONE DELL'UTENTE ATTUALMENTE COLLEGATO
 * Essa include metodi comuni a tutti gli utenti (sia persone che aziende) come il login, il cambio mail e/o password 
 * Per la gestione di utente e aziende si estendono classi che ereditano questi metodi ma che ne includono di altri più specifici;
 *
 * Ex: Per l'utente privato si può implementare la variazione di nome e cognome mentre per un'azienda vi sarà un metodo per il set della Ragione Sociale. 
 *
 *  Tutto ciò che è effettuato in modo analogo sia dagli utenti privati che dalle aziende va specificato tuttavia nella classe user, in modo che entrambi possano beneficiare dello stesso codice, diminuendo la ridondanza.
 * 
 * Ex: Il login è implementato per entrambi tramite la tabella del DB "Utenti", dunque una volta chiamato il login, l'oggetto user si autoidentifica con id e tipo.
 * A quel punto è possibile definire un persona o un'azienda con tale id per poterne gestire i dati.
 * 
 * */


class user {
	
	/*le uniche variabili necessarie sono id e tipo utente*/
	protected $id;
	protected $tipo;
	
	function _constructor(){} //costruttore nullo
	
	/*Funzione di login*/
	public function login($email, $password){
		
		
		defined("INCLUDING") or
			define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$umail = $mysqli->real_escape_string(trim($email));
		$upass = $mysqli->real_escape_string(trim($password));

		/* CONTROLLO DATI UTENTE*/
		$sql = "SELECT ID, EMAIL, PWD, TIPO, ATTIVO FROM UTENTI WHERE EMAIL = '".$umail."'and PWD=PASSWORD('".$upass."') ;";
		$q = $mysqli->query($sql);
		$row = $q->fetch_assoc(); //Memorizza il risultato in un array associativo
		if(!$row) //se non vi è risultato l'utente non è iscritto
			throw new Exception('Utente non iscritto!');
		if($row['ATTIVO']==0){
			throw new Exception("Account non confermato! Controlla la tua email.");
		}
		if($row){ //Se il risultato c'è invece, nel caso in cui la password coincide, memorizza id e tipo
			$this->id = $row["ID"];
		
			$this->tipo = $row["TIPO"];
		}
		else //Altrimenti la password è evidentemente errata
			throw new Exception("Password errata!");
		
		
		;
	}
	
	/* FUNZIONE DI REGISTRAZIONE, crea una utente non confermato nella tabella users*/
	public function create($email, $password, $type){
		defined("INCLUDING") or
		define("INCLUDING", 'TRUE');
		require_once "./database.php";
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		
		$umail = $mysqli->real_escape_string(trim($email));
		$upass = $mysqli->real_escape_string(trim($password));
		
		/* CONTROLLO UTENTE*/
		$sql = "SELECT EMAIL FROM UTENTI WHERE EMAIL = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('s', $umail);
		$q->execute(); //Esegue la query
		$res = $q->get_result(); //Ottiene il risultato
		$row  = $res->fetch_array(MYSQLI_ASSOC); //Memorizza il risultato in un array associativo
		if($row) {//se non vi è risultato l'utente non è iscritto
			throw new Exception('Utente già iscritto!');
		}
		else{
			$codice=bin2hex(openssl_random_pseudo_bytes(5));
			$newpass=password_hash($upass, PASSWORD_DEFAULT); //cifro la password	
			$insert = "INSERT INTO UTENTI (EMAIL, PWD, ATTIVO, TIPO, CODICE_ATTIVAZIONE) VALUES (?,?,0,?,?)";
			$q1 = $mysqli->prepare($insert);
			$q1->bind_param('ssss', $umail, $newpass, $type, $codice);
			$q1->execute(); //Esegue la insert
			$res1 = $q1->get_result(); //Ottiene il risultato
			if($q1->affected_rows > 0){
				$sql2 = "SELECT ID, EMAIL FROM UTENTI WHERE EMAIL = ?";
				$q2 = $mysqli->prepare($sql2);
				$q2->bind_param('s', $umail);
				$q2->execute(); //Esegue la query
				$res2 = $q2->get_result(); //Ottiene il risultato
				$row2  = $res2->fetch_array(MYSQLI_ASSOC); //Memorizza il risultato in un array associativo
				
				/* Invio email di conferma*/
				require_once "./config.php";
				require_once (TEMPLATES_PATH . "/confirm-form.php");
				require_once './vendor/autoload.php';
				
				$sendgrid = new SendGrid("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");
				$email    = new SendGrid\Email();
				
				$email->addTo($row2['EMAIL'])
				->setFrom("borsaidee@gmail.com")
				->setSubject("Conferma e-mail | Borsa delle Idee")
				->setHtml($mail);
				
				$sendgrid->send($email);
				
				return $row2["ID"];
			}
			else		
				throw new Exception('Errore durante la registrazione!');
		}
			
		
		
		
	}
	
	

	public function isLoggedIn(){
		return (isset($this->id) || $this->id !== "");	 //Se l'id è settato e diverso da una stringa vuota ritorna TRUE, altrimenti FALSE
	}
	
	public function isPersona(){ //Ritorna TRUE se l'utente loggato è una persona
		if($this->tipo=="PERSONA")
			return TRUE;
		else return FALSE;
		
		
	}
	
	
	public function getid(){ //Ritorna l'id dell'utente attualmente loggato
		if($this::isLoggedIn()){
			$id2=$this->id;
			return $id2;}
		else {
			return 0;
		}
			//throw new Exception('Nessun utente loggato!');}
	}
	
	public function changePassword($newPWD){ //Metodo di cambio password
		if($this::isLoggedIn()){

			defined("INCLUDING") or
				define("INCLUDING", 'TRUE');
			require_once "./database.php";
			
			$db = Database::getInstance();
			$mysqli = $db->getConnection();+
			
			$new_password = password_hash($newPWD, PASSWORD_DEFAULT);
			
			$sql = "UPDATE UTENTI SET PWD=? WHERE ID=?";
			$q = $mysqli->prepare($sql);
			$q->bind_param('si', $new_password,$this->id);
			if($q->execute()){
				if($q->get_result()){
					return true;}
				else return false;
			}
			else throw new Exception("Impossibile cambiare password");
	
		}	

	}

	public function changeEmail($newEmail){ //Metodo di cambio email
		if($this::isLoggedIn()){
			/* CAMBIO EMAIL*/
				
			defined("INCLUDING") or
			define("INCLUDING", 'TRUE');
			require_once "./database.php";
				
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
				
				
			$sql = "UPDATE UTENTI SET EMAIL=? WHERE ID=?";
			$q = $mysqli->prepare($sql);
			$q->bind_param('si', $newEmail,$this->id);
			if($q->execute()){
				if($q->get_result()){
					return true;}
				else return false;
			}
			else throw new Exception("Impossibile cambiare email");
	
		}
	}
	
	public function getEmail(){
		if($this::isLoggedIn()){
		
			defined("INCLUDING") or
			define("INCLUDING", 'TRUE');
			require_once "./database.php";
				
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$sql2 = "SELECT EMAIL FROM UTENTI WHERE ID=?";
				$q2 = $mysqli->prepare($sql2);
				$q2->bind_param('i', $this->id);
				$q2->execute();
				$res2 = $q2->get_result();
				$row2  = $res2->fetch_array(MYSQLI_ASSOC);
				return $row2['EMAIL'];
			
		}
	}
	
	public function follow($id_idea){
		if($this::isLoggedIn()){
		
			defined("INCLUDING") or
			define("INCLUDING", 'TRUE');
			require_once "./database.php";
		
			$db = Database::getInstance();
			$mysqli = $db->getConnection();
			$sql2 = "INSERT INTO OSSERVAZIONI (UTENTE,IDEA) VALUES (?,?)";
			$q2 = $mysqli->prepare($sql2);
			$q2->bind_param('ii', $this->id,$id_idea);
			if($q2->execute())
				return true;
			else return false;
				
		}
	}
}
?>
