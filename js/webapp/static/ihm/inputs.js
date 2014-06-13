/*******************************************************************************
 *
 * 	All functions to check user inputs values
 * 
 *******************************************************************************/


/**
 * Subtract 'value' to 'element' if the sum is greater or equal to 'min'
 * 
 * @param element
 * @param value
 * @param format
 * @param max
 */
function subtractValue(element, value, format, min) {
	var newValue = numeral().unformat(element.val()) - value;

	if (newValue >= min )
		element.val(numeral(newValue).format(format));
}


/**
 * Add 'value' to 'element' if the sum is smaller or equal to 'max'
 * 
 * @param element
 * @param value
 * @param format
 * @param max
 */
function addValue(element, value, format, max) {
	var newValue = numeral().unformat(element.val()) + value;
	if ( newValue <= max )
		element.val(numeral(newValue).format(format));
}


/**
 * Check if the sum of each of the n input fields (id = idstart + i + idend) is equal to 1
 * 
 * @param idstart start of the id name of the input field
 * @param idend end of the id name of the input field
 * @param n number of elements
 * @returns {Boolean} true if ok
 */
function checkSum(idstart, idend, n) {
	var sum = 0;

	for ( var i = 0; i < n; i++) {
		sum += numeral().unformat($(idstart + i + idend).val());
	}
	for ( var i = 0; i < n; i++) {
		if (sum == 1)
			$(idstart + i + idend + '.inputError').removeClass("inputError");
		else 
			$(idstart + i + idend).addClass("inputError");
	}
	return (sum == 1);
}


/**
 * Check if numericValue is between min and max
 * 
 * @param numericValue
 * @param min
 * @param max
 * @returns {Boolean} true if ok
 */
function checkRange(numericValue, min, max) {
	var rangeOk = false;

	if (numericValue >= min && numericValue <= max) {

		rangeOk = true;

	} else {
		if (numericValue < min) {

			BuildMsg("exclamation-sign", "Erreur",
					"<p>Vous avez saisi " + numericValue + ".</p><p>Merci de saisir une valeur plus grande que " + min + ".</p>");

		} else {
			BuildMsg("exclamation-sign", "Erreur",
					"<p>Vous avez saisi " + numericValue + ".</p><p>Merci de saisir une valeur plus petite que " + numeral(max).format('0,0') + ".</p>");
		}
	}

	return rangeOk;
}


/**
 * Check if value is a numeric and a percentage between min and max
 * 
 * @param value
 * @param min
 * @param max
 * @returns true if ok
 */
function checkPercent(value, min, max) {

	var num;

	if ( $.isNumeric(value) ) {

		num = value;

	} else {

		var regex = new RegExp(/^([0-9]+\.{0,1}[0-9]+)%$/);

		if ( value.match(regex) ) {

			value = value.replace(regex, "$1");    
			num = value / 100;

		} else {

			BuildMsg("exclamation-sign", "Erreur",
					"<p>Vous avez saisi " + value + ".</p><p>Merci de saisir une valeur numérique.</p>");
			return false;
		}
	}

	return checkRange(num, min, max);
}


/**
 * Check if value is a numeric between 0 and 10,000,000,000 (max value to prevent scientific notation).
 * 
 * @param value
 * @returns true if ok
 */
function checkNumeric(value) {

	if (!$.isNumeric(value)) {

		BuildMsg("exclamation-sign", "Erreur",
				"<p>Vous avez saisi " + value + ".</p><p>Merci de saisir une valeur numérique.</p>");
		return false;
	}
	
	return checkRange(value, 0, 10000000000);
}
