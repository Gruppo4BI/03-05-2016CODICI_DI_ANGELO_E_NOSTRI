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
  				echo "<body style=' font-family: monospace; font-size: x-large;  text-align: center;'>
	  		Salve,<br>";
   	echo "Un' email &egrave stata mandata con successo all'indirizzo email <b>" . $email . "</b> da te fornito.<br><br>";
   	echo "<br>";
   	echo "Per creare una nuova password devi aprire la tua casella e-mail, leggere il messaggio  e cliccare sul link che troverai all'interno.
   			<br><br>Tra pochi secondi verrai reindirizzato alla pagina di login</body>";
  				header( "refresh:10;index.php" );
  			}
  			else {
  				echo "<body style='background-color:#8080ff; font-family: monospace; font-size: x-large; color: white; text-align: center;'>
	  			Errore nell' invio dell'email all' indirizzo di posta elettronica da lei indicato.
	  		</body>";
  		    }
  	}
  		    
  		    else{ echo"<body style='background-color:#8080ff; font-family: monospace; font-size: x-large; color: white; text-align: center;'>
  		    L' email inserita non e' corretta </body>"; }
  	         }
 
   	      header( "refresh:10;index.php" );
   
   ?>
