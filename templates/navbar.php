<?php
defined('INCLUDING') or die('Restricted access');
include_once './config.php';
include_once(METHODS_PATH . '/user.class.php');
include_once(METHODS_PATH . '/persona.class.php');
include_once(METHODS_PATH . '/azienda.class.php');

if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}



/* Navbar */
if(isset($_SESSION['loggeduser']) && $_SESSION['loggeduser']->isLoggedIn())
	
	include 'navbar-logged.php';
else
	include 'navbar-guest.php';

if(isset($diag)){
	if ($diag!=""){
		echo print_diag($diag);
	}
}
if(isset($success_diag)){
	if ($success_diag!=""){
		echo print_successdiag($success_diag);
	}
}

?>