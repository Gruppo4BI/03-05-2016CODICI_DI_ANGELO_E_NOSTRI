<?php
require_once(METHODS_PATH . '/persona.class.php');

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if(isset($_POST['setpassword'])){
	
	

	$pass = $_POST['newPassword'];
	$pass1 = $_POST['confirmPassword'];
	
	if($pass == $pass1){
		try{
			$_SESSION['loggeduser']->changePassword($_POST['newPassword']);
			$success_diag="Password cambiata con successo.";
		}
		catch (Exception $e){
			$diag=$e->getMessage();
		}
	}
	else {$diag="Le password non coincidono.";}
	
}


if(isset($_POST['setmail'])){
	
	$mail = $_POST['nuovaemail'];
	$mail1 = $_POST['confermaemail'];
	
	if($mail == $mail1){
		
		try{
			$_SESSION['loggeduser']->changeEmail($_POST['nuovaemail']);
			$success_diag="Email cambiata con successo.";
		}
		catch (Exception $e){
			$diag=$e->getMessage();
		}
	}
	else {
		$diag="Le email non coincidono.";
	}
}

if(isset($_POST['cambianome'])){
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	try{
			$_SESSION['loggeduser']->setNome($nome);
			$_SESSION['loggeduser']->setCognome($cognome);
			$success_diag="Dati cambiati con successo.";
		}
		catch (Exception $e){
			$diag=$e->getMessage();
		}
}


if(isset($_POST['cambiaindirizzo'])){
	
	if($_POST['indirizzo']==""){
		$via=$_SESSION['loggeduser']->getDati()['INDIRIZZO'];
	} else{$via=$_POST['indirizzo'];}
	
	if($_POST['cap']==""){
		$cap=$_SESSION['loggeduser']->getDati()['CAP'];
	} else{$cap=$_POST['cap'];}
	
	if($_POST['citta']==""){
		$citta=$_SESSION['loggeduser']->getDati()['CITTA'];
	} else{$citta=$_POST['citta'];}
	
	if($_POST['nazione']==""){
		$nazione=$_SESSION['loggeduser']->getDati()['NAZIONE'];
	} else{$nazione=$_POST['nazione'];}
	
	if($_POST['regione']==""){
		$regione=$_SESSION['loggeduser']->getDati()['REGIONE'];
	} else{$regione=$_POST['regione'];}
	
	if($_POST['provincia']==""){
		$provincia=$_SESSION['loggeduser']->getDati()['PROVINCIA'];
	} else{$provincia=$_POST['provincia'];}
	
	$_SESSION['loggeduser']->setIndirizzo($via,$cap,$citta,$regione,$nazione,$provincia);
	$success_diag="Indirizzo cambiato con successo.";
	
	
}



?>