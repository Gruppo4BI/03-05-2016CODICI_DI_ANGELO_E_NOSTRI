
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Borsa delle idee - Successo</title>
 <?php 
 define("INCLUDING", 'TRUE');
include_once 'database.php';
$db = Database::getInstance();
$mysqli = $db->getConnection();
 $psw=$_POST['password'];
 $get_email=$_GET['email'];

 $comando= "update utenti set PWD =  '$psw' where email='" . $get_email . "' ";
 $result=$mysqli->query($comando); 
 if(!$result)
 	die("Modifica non valida: " . mysql_error());
 ?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
  <div class="alert alert-success">
  <strong>La tua nuova password e' stata registrata con successo! Ora verrai reindirizzato alla pagina di login </strong> <i class="fa fa-spinner fa-spin"></i>
</div>
<?php
header( "refresh:4 ;home.php" );
?>
</head>