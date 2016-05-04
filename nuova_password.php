<!-- La pagina nuova_password.php viene acceduta dal link mandato all' indirizzo di posta elettronica dell' azienda e
permette di inserire in una form la nuova password --!>
<?php 
define("INCLUDING", 'TRUE');
//prelevo codice tipo e email associate al link affinche' si possano modificare i dati corrispondenti all' azienda corretta
 if($_GET['code']){
 	$get_code=$_GET['code'];  
 	$get_email=$_GET['email'];
 }
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> 
    <title>Borsa delle idee - Reset password</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <hr>
<div class="container">
    <div class="row">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                         <i class="fa fa-refresh fa-3x"></i></h3>
                          <h3><i class="fa fa-lock fa-4x"></i></h3>  <h3>
                          <h2 class="text-center">Password Reset</h2>
                          <p>Inserisci la nuova password</p>
                            <div class="panel-body">
                              
                              <form class="form" name="new_password" action="<?php echo"pswUpdate.php?email=$get_email" ?>" method="POST" >
                                <fieldset>
                                  <div class="form-group">
                                    
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                      
                                      <!-- Nel campo relativo all' email non si potra' inserire nulla, l' email verra' mostrata automaticamente e non puo' essere modificata  grazie al readonly placeholder-->
                                      
                                      <input id="email" name="email"  readonly placeholder="<?php echo $get_email ?>" class="form-control" type="email" oninvalid="setCustomValidity('Inserisci una password valida')" onchange="try{setCustomValidity('')}catch(e){}" required="">
                                    </div>
                                    
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="glyphicon glyphicon-pencil color-blue"></i></span>
                                    
                                      <input id="password" name="password" placeholder="nuova password" class="form-control" type="password" oninvalid="setCustomValidity('Inserisci una password valida')" onchange="try{setCustomValidity('')}catch(e){}" required="">
                                    </div>
                                    
                                    
                                  </div>
                                  <div class="form">
                 
                                    <input class="btn btn-lg btn-primary btn-block" value="Invia" type="submit" onsubmit="window.alert('password registrata con successo')">
                                  </div>
                                </fieldset>
                              </form>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>