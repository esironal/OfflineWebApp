/*******************************************************************************


					  All functions to manage Browsers


*******************************************************************************/

//Replace if match
function ReplaceByRegex(regex, text) {
	regex = new RegExp(regex);
	if (text.match(regex, text)) {
		var result = [];
		result[1] = text.replace(regex, "$1");
		result[2] = text.replace(regex, "$2");
		return result;
	} else { return false; }
}


//Detect navigator (name, version)
function jsDetectBrowser() {

	//--------------------------------------------------------------------------
	// Detection userAgent
	//--------------------------------------------------------------------------

	var userAgent;

	//Auto
	userAgent = navigator.userAgent;

	//UserAgent examples
	//userAgent = "Mozilla/5.0 (compatible; MSIE 9.2; Windows NT 6.1; WOW64; Trident/6.0)"; //IE
	//userAgent = "mozilla/5.0 (x11; linux x86_64) applewebkit/537.36 (khtml, like gecko) chrome/27.2.1547.57 safari/537.36"; //Chrome & Chromium
	//userAgent = "mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.36+ (khtml, like gecko) version/1.2 Safari/8536.25"; //Safari ordi
	//userAgent = "mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/537.36+ (khtml, like gecko) version/1.3 Mobile/10A5355d Safari/8536.25"; //Safari iOS
	//userAgent = "mozilla/5.0 (x11; linux x86_64; rv:17.0) gecko/20130917 firefox/17.0 iceweasel/15.2.9" //Iceweasel
	//userAgent = "mozilla/5.0 (x11; linux x86_64; rv:17.0) gecko/20130917 firefox/19.5.20" //Firefox

	//Lowercase
	userAgent = userAgent.toLowerCase();

	//--------------------------------------------------------------------------
	// Textmining
	//--------------------------------------------------------------------------

	var detect = [];

	//Other navigators
	var version="";

	//Internet Explorer
	detect = ReplaceByRegex(/^.+msie ([0-9\.]+);([^;]+);.+$/, userAgent);
	if (detect != false) { version = "Internet Explorer&"+detect[1]+"&"+detect[2]; }
	
	//Chrome & Chromium
	detect = ReplaceByRegex(/^[^\(\)]+\(([^\)]+)\).+applewebkit.+chrome\/([0-9\.]+).*$/, userAgent);
	if (detect != false) { version = "Chrome&"+detect[2]+"&"+detect[1]; }

	//Safari ordi
	detect = ReplaceByRegex(/^[^\(\)]+\(([^\)]+)\).+applewebkit.+version\/([0-9\.]+) safari.+$/, userAgent);
	if (detect != false) { version = "Safari&"+detect[2]+"&"+detect[1]; }

	//Safari iOS
	detect = ReplaceByRegex(/^[^\(\)]+\(([^\)]+)\).+applewebkit.+version\/([0-9\.]+) mobile\/.*$/, userAgent);
	if (detect != false) { version = "Safari&"+detect[2]+"&"+detect[1]; }

	//Iceweasel
	detect = ReplaceByRegex(/^[^\(\)]+\(([^\)]+)\).+iceweasel\/([0-9\.]+)$/, userAgent);
	if (detect != false) { version = "Iceweasel&"+detect[2]+"&"+detect[1]; }

	//Firefox
	detect = ReplaceByRegex(/^[^\(\)]+\(([^\)]+)\).+firefox\/([0-9\.]+)$/, userAgent);
	if (detect != false) { version = "Firefox&"+detect[2]+"&"+detect[1]; }

	//--------------------------------------------------------------------------
	// Results
	//--------------------------------------------------------------------------

	//If detection success
	var regex = new RegExp(/^([^&]+)&([^&]+)&(.*)$/);
	if (version.match(regex, version)) {
		var result = [];
		result["userAgent"] = userAgent;
		result["name"] = version.replace(regex, "$1");
		result["version"] = version.replace(regex, "$2");
		result["num"] = parseFloat(ReplaceByRegex(/^([^\.]+\.*[^\.]+).*$/, result["version"])[1]);
		result["os"] = version.replace(regex, "$3");
		return result;
	} else { return false; }
}
