

/*
 * GET
 */

	//Retourne un mois depuis le LS
	function getMois(mois) {
		return JSON.parse(localStorage.getItem(FolderName+"_USER_"+mois));
	}


/*
 * SET
 */

	//Enregistre un mois dans le LS
	function setMois(mois, value) {
		localStorage.setItem(FolderName+"_USER_"+mois, JSON.stringify(value));
	}


