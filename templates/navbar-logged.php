<?php
defined('INCLUDING') or die('Restricted access');

/* Navbar di base per utenti loggati*/



?>

<nav class="navbar navbar-default" role = "navigation">
  <div class="container-fluid">
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
	        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"> <span class="caret"></span></a>
	        <ul class="dropdown-menu">
	            <li><a href='profile.php?id=<?php echo $_SESSION['loggeduser']->getid()."'>".$_SESSION['loggeduser']->who();?></a></li>
	            <li><a href="settings.php">Impostazioni</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="logout.php">Logout</a></li>
	        </ul>
     	</li>
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
    	<li><a href='profile.php?id=<?php echo $_SESSION['loggeduser']->getid();?>'>Profilo</a></li>
        <li><a href="settings.php">Impostazioni</a></li>
        <li><a href="logout.php">Logout</a></li>
	</ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>