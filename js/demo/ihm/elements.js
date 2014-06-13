

var valueFocussed;

/**
 * Add click and change functions to ihm elements   
 */
function enableApp() {   
	

	/*
	 * CA
	 */

	$('[id^="ca_"]').focus( function() {

		valueFocussed = numeral().unformat($(this).val());
		$(this).val(valueFocussed);

	}).change( function() {

		if ( checkNumeric($(this).val()) ) {

			// Save to localStorage
			saveCA(parseInt($(this).attr('id').substr(3)), $(this).val());

		} else {

			// Restore previous value
			$(this).val(valueFocussed);
		}

	}).blur( function() {

		$(this).val(numeral($(this).val()-0).format('0,0[.]00 $'));
	});

	/*
	 * BENEF
	 */

	$('[id^="benef_"]').focus( function() {

		valueFocussed = numeral().unformat($(this).val());
		$(this).val(valueFocussed);

	}).change( function() {

		if ( checkNumeric($(this).val()) ) {

			// Save to localStorage
			saveBenef(parseInt($(this).attr('id').substr(6)), $(this).val());

		} else {

			// Restore previous value
			$(this).val(valueFocussed);
		}

	}).blur( function() {

		$(this).val(numeral($(this).val()-0).format('0,0[.]00 $'));
	});



}
