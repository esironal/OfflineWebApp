<?php
require_once "../utils.php";

//Rules
politic("deny");

//Connected or not
$state = check_connected();

//If connected
if ($state) {


	html_start("Logs", "../../");
	html_menu("../../"); 
	?>

	<div class="container">

		
		Pas encore implémenté !

	
	</div>


	<?php
	html_end(false);


//If not connected
} else {
	ForbiddenAccess("../../");
}
?>
