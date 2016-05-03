<?php
defined('INCLUDING') or die('Restricted access');

if(isset($_POST['register']))
{
	require_once(METHODS_PATH . '/persona.class.php');

	$newuser = new persona;
	
	$nome = $_POST['nome'];
	$cognome = $_POST['cognome'];
	$dnasc = $_POST['datanascita'];
	$sex = $_POST['sex'];
	$email = $_POST['email'];
	$pass = $_POST['password'];

	try{
		$newuser->register($email, $pass, $nome, $cognome, $dnasc, $sex);
		$success_diag="Registrazione avvenuta con successo! Conferma l'email per procedere.";
	}
	catch (Exception $e){
		$diag = $e->getMessage();
	}
}
?>