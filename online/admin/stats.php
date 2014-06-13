<?php
require_once "../utils.php";

//Rules
politic("deny");

//Connected or not
$state = check_connected();

//If connected
if ($state) {

	html_start("Stats", "../../");
	html_menu("../../");
	?>

	<script>
		$(function() {
			$(window).load(function() {

	
			});
		});
	</script>

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
