

/*************************************************************************
 * 
 * Save CA and Benef
 * 
 *************************************************************************/

function saveCA(mois, value) {

	console.log( "Demo - saveCA");

	var moisObj = getMois(mois);
	moisObj[0]["ca"] = value;

	setMois(mois, moisObj);

}

function saveBenef(mois, value) {

	console.log( "Demo - saveBenef");

	var moisObj = getMois(mois);
	moisObj[0]["benef"] = value;

	setMois(mois, moisObj);

}

