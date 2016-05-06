<?php
define("INCLUDING", 'TRUE');
include('config.php');
include_once(METHODS_PATH . '/persona.class.php');
include_once(METHODS_PATH . '/azienda.class.php');
?>


<!DOCTYPE HTML>

<head>
  <title> Home | Borsa delle Idee </title>
   <?php include(TEMPLATES_PATH.'/head.php'); ?>
</head>

<?php include (TEMPLATES_PATH.'/navbar.php'); //Navbar ?>

<div class="container main-content">
	<?php //include (TEMPLATES_PATH.'/dialog.php'); //Messaggi di errore ?>
  
  <div class="jumbotron bid-jumbotron">
  	<h1 id="title-jumbo"><?php if (isset($_SESSION['loggeduser'])){
 	 		if ($_SESSION['loggeduser']->isLoggedIn()){
 	 			echo "Ciao, ". $_SESSION['loggeduser']->who()."";
  			}}
 	 		else echo "Benvenuto";
 	 	?>!</h1>
  <p class="p-jumbo">Sei pronto per iniziare?</p>

  <p> <?php if (isset($_SESSION['loggeduser'])){
 	 		if ($_SESSION['loggeduser']->isLoggedIn())
 	 			echo 'Condividi ';}
		else echo "Registrati per condividere ";?>
		con il mondo le tue idee, o partecipa a quelle di altri utenti!</p>
  <p>
  	 <div class="btn-group ">
  	<a class="btn btn-primary btn-lg" href="#" role="button">Esplora</a>
  		<?php if (isset($_SESSION['loggeduser'])){
 	 		if ($_SESSION['loggeduser']->isLoggedIn()){
 	 			echo '<a class="btn btn-primary btn-lg" href="#" role="button">Pubblica</a></div>';}}
 	 		else
 	 			echo '
				  <button type="button" class="btn btn-primary btn-lg">Registrati</button>
				  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu">
				    <li><a href="REGISTRAZIONE2.php">Registrati come azienda</a></li>
				    <li><a href="register.php">Registrati come utente</a></li>
				  </ul>
			</div>;';
 	 	?>
  </p>
</div>	
 	
</div> 	
<?php
//per settare l'id dopo che è stata inviata la mail all'azienda 
if( isset($_GET['id']) )
{
	$slq= "SELECT EMAIL,CODICE_ATTIVAZIONE FROM utenti WHERE CODICE_ATTIVAZIONE='".$_GET['id']."';";
	$result = $mysqli->query($slq);
	$RIGA = $result->fetch_assoc();
	switch ($_GET['id'])
	{
		 

		case $RIGA['CODICE_ATTIVAZIONE']:
			$comandoSQL="update utenti set ATTIVO='1' where EMAIL='".$RIGA['EMAIL']."';";
			$q = $mysqli->query($comandoSQL);
			$mysqli->close();
			//$result=mysqli_query($conn,$comandoSQL);
			break;
			 
	}
}
?>
 <?php include (TEMPLATES_PATH.'/footer.php');?>	
</body>

<!>
