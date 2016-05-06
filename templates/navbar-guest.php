
<?php
/* Navbar di base per utenti non loggati*/

defined('INCLUDING') or die('Restricted access');

include(METHODS_PATH . '/login.method.php');
include_once 'database.php';
$db = Database::getInstance();
$mysqli = $db->getConnection();

?>

<nav class="navbar navbar-default navbar-fixed-top" role = "navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#hidden-view" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand bid-logo" href="home.php">BORSA<i>delle<b></i>IDEE</b></a>      
    </div>

    <div class="collapse navbar-collapse" id="hidden-view">
    	<ul class="nav navbar-nav navbar-right hidden-xs">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
							<div class="col-md-12">
								 <form class="form" role="form" method="post" accept-charset="UTF-8" id="login">
										<div class="form-group has-feedback">
											 <label class="sr-only" for="Email">Indirizzo Email</label>
											 <input type="email" class="form-control" name="email" placeholder="Indirizzo Email" required>
											 
										</div>
										<div class="form-group">
											 <label class="sr-only" for="Password">Password</label>
											 <input type="password" class="form-control" name="password" placeholder="Password" required>
                                             <div class="help-block text-right"><a href="forgot.php">Hai dimenticato la password?</a></div>
										</div>
										<div class="form-group">
											 <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
										</div>
										<div class="checkbox">
											 <label>
											 <input type="checkbox"> Ricordami
											 </label>
										</div>
								 </form>
								 <hr>
								 <div class="text-center">
								 Non sei iscritto? <a href="register.php"><b>Registrati!</b></a>
								</div>
							</div>
					 </div>
				</li>
			</ul>
     </ul>      
         
     <form class="navbar-form navbar-right hidden-xs" id="search" role="search">
	    <div class="form-group">
	    <input type="text" class="form-control" placeholder="Cerca">
	    </div>
		<button type="submit" class="btn btn-link"><i type="submit" class="glyphicon glyphicon-search"></i></button>
    </form>
      <form class="navbar-form navbar-right visible-xs" id="search" role="search">
    	
	    <div class="col-xs-10 form-group">
	    <input type="text" class="form-control" placeholder="Cerca">
	    </div>
		<button type="submit" class="btn btn-link"><i type="submit" class="glyphicon glyphicon-search"></i></button>
    </form>  
    
    <ul class="nav navbar-nav visible-xs">
    	<li><a href="login.php">Login</a></li>
        <li><a href="register.php">Registrati</a></li>
	</ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

