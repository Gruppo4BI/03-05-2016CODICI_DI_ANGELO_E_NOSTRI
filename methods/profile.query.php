<?php
/* Script che si occupa di ritornare i dati dell'utente (persona) del quale visualizzo il profilo  */

//Non posso visualizzare il file direttamente, se non è stato incluso da un'altra pagina, non permettere l'accesso
defined('INCLUDING') or die('Restricted access');
include('./config.php');

$id = null;
if ( !empty($_GET['id'])) { //La pagina richiede l'id dell'utente tramite il metodo get; ex: http://bidee.com/profile.php?id=1
	$id = $_REQUEST['id'];
}

if ( null==$id ) {
	header("Location: home.php"); //Se non viene passato l'id tramite get, fa redirect alla homepage 
}
else {
	require './database.php'; //Includo la classe db
	
	$db = Database::getInstance(); //Ottengo l'istanza
	$mysqli = $db->getConnection(); //e la connessione
	
	/* DATI UTENTE */
	$data[] = array(); //L'array "$data" conterrà i dati dell'utente visualizzato
	$sql = "SELECT * FROM PERSONE WHERE ID_UTENTE = ?";
	$query = $mysqli->prepare($sql);
	$query->bind_param('i', $id);
	if ($query->execute()){ //Se la query ha successo,
	    $result = $query->get_result(); //Ottieni il risultato
	    $data  = $result->fetch_array(MYSQLI_ASSOC); //E memorizzalo in un "array associativo" (per info, vedi documentazione php)
	    if (!$data) header("Location: error.php");//
	} else{
		header("Location: error.php"); //Se la query fallisce vai alla pagina di errore
	}
	
		
	/* MEDIA REPUTAZIONE UTENTE*/	
	$sql0 = "SELECT * FROM UTENTI where ID = ?"; //I dati sulla reputazione si trovano nella tabella utenti.
	$q0 = $mysqli->prepare($sql0);
	$q0->bind_param('i', $id);
	$q0->execute();
	$res = $q0->get_result();
	$repudata  = $res->fetch_array(MYSQLI_ASSOC); //Ottengo l'array associativo
	$rep=$repudata["REPUTAZIONE"];//Mi serve solo la reputazione
		
		
	/* COMPETENZE UTENTE*/
	$skills[]=array(); //L'array "$skills" conterrà i tag delle competenze dell'utente
	$sql1="SELECT COMPETENZA FROM APPARTENENZE WHERE UTENTE = ?";
	$q1 = $mysqli->prepare($sql1);
	$q1->bind_param('i', $id);
	$q1->execute();
	$reskill = $q1->get_result();
	$skills = $reskill->fetch_all(MYSQLI_ASSOC);
	
	
	/* IDEE PUBBLICATE*/
	$sql2="SELECT * FROM IDEE WHERE CREATORE = ?";
	$q2 = $mysqli->prepare($sql2);
	$q2->bind_param('i', $id);
	$q2->execute();
	$ires= $q2->get_result();
	$ideep = $ires->fetch_all(MYSQLI_ASSOC);
	$nideepub=0;
	foreach($ideep as $var => $val){
	$nideepub++;}

	/* IDEE SEGUITE*/
	$sql3=	"SELECT * FROM OSSERVAZIONI 
		JOIN IDEE ON IDEA = ID
		WHERE UTENTE = ?";
	$q3 = $mysqli->prepare($sql3);
	$q3->bind_param('i', $id);
	$q3->execute();
	$fres= $q3->get_result();
	$nfollowed=0;
	$idees = $fres->fetch_all(MYSQLI_ASSOC);
	foreach($idees as $f)
		$nfollowed++;
	
	/* FEEDBACK RICEVUTI */
	$sql4 = "SELECT REFERENTE, RIFERITO, VOTO, F.DESCRIZIONE AS DESCR, IDEA, NOME, COGNOME, TITOLO 
			FROM FEEDBACK F
			JOIN PERSONE ON REFERENTE = ID_UTENTE
			JOIN IDEE I ON IDEA = I.ID
			WHERE RIFERITO = ?";
	$q4 = $mysqli->prepare($sql4);
	$q4->bind_param('i', $id);
	$q4->execute();
	$res4 = $q4->get_result();
	$feedback = $res4->fetch_all(MYSQLI_ASSOC);
		

	//Database::disconnect(); //automatizzato

}
?>
