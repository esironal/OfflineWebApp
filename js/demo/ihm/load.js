

//Load default data 
function loadUSERInputs() {

	console.log("Demo - loadInputs");


	//CA
	$('[id^="ca_"]').each( function(index, element) {
		var mois = getMois(parseInt(index+1));
		$(element).val( numeral( mois[0]["ca"] ).format('0,0[.]00 $'));
	});

	//Benef
	$('[id^="benef_"]').each( function(index, element) {
		var mois = getMois(parseInt(index+1));
		$(element).val( numeral( mois[0]["benef"] ).format('0,0[.]00 $'));
	});
}

