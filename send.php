<!DOCTYPE html>
<html>
<head>
  <title> Invio email| Borsa delle Idee</title>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    

    <script src="bootstrap/js/bootstrap.js"></script>
    <!-- Font Awesome -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Extra Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic,900,900italic,100italic,100,300italic,300' rel='stylesheet' type='text/css'>
	<!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Script per il selettore date -->
  <script src="components/bootstrap-datepicker/bootstrap-datepicker-built.js"></script>
  <link rel="stylesheet" href="components/bootstrap-datepicker/bootstrap-datepicker-built.css">
</head>
<body></body>
</html>


<?php
// Connessione al database mysql
define("INCLUDING", 'TRUE');
include_once 'database.php';
$db = Database::getInstance();
$mysqli = $db->getConnection();

     if(isset($_POST['submit'])){
     	$email=$_POST['email'];
     	
    $comando = "SELECT * FROM utenti where email= '" . $email . "'";
   
    $result= $mysqli->query($comando); 
    //controllo se la email e' presente nel database, se l' esito e' positivo verrano iniziati i preparativi per l'invio dell' email
    //in caso contrario(l' email non e' presente nel database) verra' mostrato un messaggio di errore
    $code= rand(10000,1000000); //dichiaro una variabile codice contenente una stringa numerica generata dalla funzione random
    $to ="$email";
    $subject = "Crea la tua nuova password qui";
    //Messaggio di conferma
    $confirmmessage = "Salve, ";
    $confirmmessage .= "ci e' pervenuta una richiesta di reset password per l'account $email. Per creare una nuova password clicca o copia e incolla sulla barra di ricerca il seguente link, ";
    //ai fini della sicurezza e per risolvere eventuali problemi di concorrenza al link viene associato il codice randomico, l'email e il tipo
    $confirmmessage .= "http://localhost/nuova_password.php"."?code=$code&email=$email";	
    //versione del MIME
    
    // costruiamo intestazione generale
    $headers = "From: Borsa delle idee \r\n";
    // Check to see if a user exists with this e-mail
    //questa parte del messaggio viene visualizzata
    // solo se il programma non sa interpretare
    // i MIME poiche' e'posta prima della stringa boundary
    $message = "This is a Multipart Message in MIME format\n";

    $message .= "Content-type: text/html; charset=iso-8859-1\n";
    //la codifica con cui viene trasmesso il contenuto.
    $message .= "Content-Transfer-Encoding: 7bit\n\n";
    $message .= $confirmmessage . "\n";
    
  	if($result)
  		if(mysqli_fetch_assoc($result)){
  			//invio mail
  			$mailsent = mail($to, $subject, $message, $headers);
  			//controllo se l'email e' stata mandata con successo,in caso negativo verra' mostrato un messaggio di errore invio mail
  			if ($mailsent)
  			{
  				echo "<body >
	  			<div class='row'>
        			<div class=' col-md-8 col-md-offset-2'>
        				<div class='well panel panel-default'>
	  						Salve,<br>"; 
	  echo 					"Un messaggio &egrave stato inviato all'indirizzo <b>" . $to . "</b> da te fornito.<br><br>";  
	  echo					 "Per creare una nuova password devi aprire la tua casella e-mail, leggere il messaggio di conferma e cliccare sul link che troverai all'interno.
	  						<br><br>Tra pochi secondi verrai reindirizzato alla home
	  					</div>
	  				</div>
	  			</div>
	  		
	  		</body>"; 
  		    }
  	}
  		    
  		    else{
  		    	echo "<body >
	  			<div class='row'>
        			<div class=' col-md-8 col-md-offset-2'>
        				<div class='well panel panel-default'>
	  						L' email inserita non &egrave corretta
	  					</div>
	  				</div>
	  			</div>
	  		
	  		</body>"; }
  	         }
 
   	      header( "refresh:10;index.php" );
   
   ?>
