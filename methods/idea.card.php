<?php 

/*Funzione IDEAPRINT
 * Stampa una "card" idea 
*/
function ideaprint ($id, $titolo, $descrizione, $foto){
	echo   '<div class="card">
				<div class="card-image">
			    	<img class="img-responsive" src="'.$foto.'">
			    	<span class="card-title">'.$titolo.'</span>
				</div>
			       
				<div class="card-content">
			    	<p>'.$descrizione.'</p>
				</div>
				<div class="card-action">';
	
if(isset($_SESSION['loggeduser']) && $_SESSION['loggeduser']->isLoggedIn()){
			echo '<a href="#" target="new_blank">Segui</a>';
		}
	echo '<a href="#" target="new_blank">Di più</a>
				</div>
			</div>';
}

?>