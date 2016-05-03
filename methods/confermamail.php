 <?php

if(isset($_GET['confirm'])){
	
	defined("INCLUDING") or
	define("INCLUDING", 'TRUE');
	require_once "./database.php";
		
	$db = Database::getInstance();
	$mysqli = $db->getConnection();+

	
	$sql = "UPDATE UTENTI SET ATTIVO=1 WHERE CODICE_ATTIVAZIONE=?";
	$q = $mysqli->prepare($sql);
	$q->bind_param('s', $_GET['confirm'] );
	if($q->execute()){
		if($q->affected_rows>0)
		$success_diag="Account confermato con successo! Effettua il login.";
	}
	else $diag="Impossibile confermare account";
	
}