<?php
defined('INCLUDING') or die('Restricted access');

if(isset($_POST['login']))
{
	require_once(METHODS_PATH . '/persona.class.php');
	require_once(METHODS_PATH . '/azienda.class.php');
	
	
	if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	
	
	if(isset($_SESSION['loggeduser']))
		if ($_SESSION['loggeduser']->isLoggedIn())
			throw new Exception("Un utente ha gi&agrave  effettuato il login. Effettua prima il logout.");
	
	$loggeduser = new user;
	
	$email = $_POST['email'];
	$upass = $_POST['password'];
	

	try{
		$loggeduser->login($email, $upass);
		
		if($loggeduser->isPersona()){
			$_SESSION['loggeduser']= new persona; 
			$_SESSION['loggeduser']->set($loggeduser->getid()); //fetch dei dati per la persona
		}
		else{
			$_SESSION['loggeduser']= new azienda;
			$_SESSION['loggeduser']->set($loggeduser->getid()); 
		}
	
		header("Location: home.php");

	}
	catch (Exception $e){
		$diag = $e->getMessage();
	}
	
	
	
}
?>