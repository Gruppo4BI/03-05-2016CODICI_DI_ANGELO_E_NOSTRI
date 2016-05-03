<?php 
	session_start();
	define("INCLUDING", 'TRUE');
?>
<!DOCTYPE html>
<html>
<head>
  <title> Conferma | Borsa delle Idee</title>
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
  //include_once 'configurazioneDB.php';
  include_once 'database.php';
  $db = Database::getInstance();
  $mysqli = $db->getConnection();
	//Invio un Email contentente NickName, password in chiaro e link per confermare la registrazione. 
	$mail=$_SESSION['email'];
	$pass=$_SESSION['psw'];
	//Attraverso la funzione md5 che sfrutta l'algoritmo MD5 cripto un messaggio che dopo utilizzero
	$msgid = md5(time());
	$msgid = md5((($msgid-rand(1,5))+15)+rand(1000,5000));
	
	$sql= "UPDATE utenti SET CODICE_ATTIVAZIONE='".$msgid."' WHERE EMAIL='".$mail."' AND PWD=PASSWORD('".$pass."');";
	
	$result = $mysqli->query($sql);
	//mi servirà per mandare $msgid al loginborsa.php

	
	$to =$mail; 
	$toname = $_SESSION['nomeAZ']; 
	$subject = "Completa la tua registrazione"; 
	//MIME, Multiporpouse Internet Mail Extensions 
	//sono estensioni del formato originario con cui venivano inviati i messaggi di posta elettronica
	$boundary = "==BORSA DELLE IDEE=="; /*Separatore per il "multipart message"*/
	
	//versione del MIME
	$headers = "MIME-Version: 1.0\r\n"; 
	//multipart/alternative per indicare che il messaggio è costituito da più parti 
	//(&#147;multipart&#148;) le quali sono tra loro alternative (&#147;alternative&#148;). Separate dal BOUNDARY 
	$headers .= "Content-type: multipart/alternative; boundary='$boundary'\r\n"; 
	// costruiamo intestazione generale
	$headers .= "From: BorsaIdeeTeam4@gmail.com \r\n";  
	
	//Costruisco il messaggio html
	$html_msg .= "Questi sono i dati della tua registrazione: \r\n"; 
	$html_msg .= "Username: " . $mail . "\r\n "; 
	$html_msg .= "Password: " . $pass . "\r\n";  
	
	//Messaggio di conferma
	$confirmmessage = "Salve,\n\n"; 
	$confirmmessage .= "per completare la registrazione della tua azienda devi cliccare sul link sottostante:\n"; 
	$confirmmessage .= $html_msg . "\n\n"; 
	// confirm_reg.php 
	$confirmmessage .= "http://borsaidee.altervista.org/home.php" . 
	  "?id=$msgid"."\r\n"; 
	
	//questa parte del messaggio viene visualizzata
	// solo se il programma non sa interpretare
	// i MIME poiché è posta prima della stringa boundary
	 
	$message .= "--$boundary\n"; 
	
	//la codifica con cui viene trasmesso il contenuto.
	$message .= $confirmmessage . "\n"; 
	$message .= "--$boundary--";
	
	//invio mail
	$mailsent = mail($to, $subject, $message, $headers); 
	//controllo 
	if ($mailsent) 
	{ 
	  echo "<body >
	  			<div class='row'>
        			<div class=' col-md-8 col-md-offset-2'>
        				<div class='well panel panel-default'>
	  						Salve,<br>"; 
	  echo 					"Un messaggio &egrave stato inviato all'indirizzo <b>" . $mail . "</b> da te fornito.<br><br>";  
	  echo					 "Per completare la registrazione al sito devi aprire la tua casella e-mail, leggere il messaggio di conferma e cliccare sul link che troverai all'interno.
	  						<br><br>Tra pochi secondi verrai reindirizzato alla pagina di login
	  					</div>
	  				</div>
	  			</div>
	  		
	  		</body>"; 
	  // reindirizzamento a tempo
	  header( "refresh:5;index.php" );
	}
	 else { 
	  	  echo "<body >
	  			<div class='row'>
        			<div class=' col-md-8 col-md-offset-2'>
        				<div class='well panel panel-default'>
	  						Errore durente l'invio mail
	  					</div>
	  				</div>
	  			</div>
	  		
	  		</body>";
	  	header( "refresh:5;index.php" );
	}
	?>