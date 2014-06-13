<?php

/*
echo "<pre>";
print_r(detectBrowser());
echo "</pre>";
if (checkBrowser(detectBrowser())) echo "OK"; else echo "KO";
*/

//Rules for web app
//Return false if outdated otherwise true
function checkBrowser($browser) {

	//Default action, set to false to deny unknown browsers
	$go = true;

	//Block outdated browser
	if ($browser !== false) {
		if ($browser["browser"]["name"] == "Internet Explorer"	&& $browser["browser"]["version"]["major"] < 10) 	{ $go = false; }	//Last:11	Jquery:9+		Bootstrap:10+
		if ($browser["browser"]["name"] == "Chrome" 			&& $browser["browser"]["version"]["major"] < 28) 	{ $go = false; }	//Last:29	Jquery:28+		Bootstrap:29+
		if ($browser["browser"]["name"] == "Safari" 			&& $browser["browser"]["version"]["major"] < 5) 	{ $go = false; }	//Last:6	Jquery:5.1+		Bootstrap:6+
		if ($browser["browser"]["name"] == "Iceweasel" 			&& $browser["browser"]["version"]["major"] < 16) 	{ $go = false; }	//Last:17	Jquery:--		Bootstrap:--
		if ($browser["browser"]["name"] == "Firefox" 			&& $browser["browser"]["version"]["major"] < 25) 	{ $go = false; }	//Last:26	Jquery:24+		Bootstrap:26+
		if ($browser["browser"]["name"] == "Opera" 				&& $browser["browser"]["version"]["major"] < 12) 	{ $go = false; }	//Last:18	Jquery:12.1+	Bootstrap:18+
	}

	//Return action: go or nogo
	return $go;
}

//Detect client browser
//Return false if not detected
//Or if detected:
// ["useragent"]
// ["browser"]["name"]
// ["browser"]["version"]["major"]
// ["browser"]["version"]["minor"]
// ["browser"]["version"]["micro"]
// ["browser"]["version"]["other"]
// ["engine"]["name"]
// ["engine"]["version"]["major"]
// ["engine"]["version"]["minor"]
// ["engine"]["version"]["micro"]
// ["engine"]["version"]["other"]
// ["os"]["name"]
// ["os"]["hardware"]
// ["os"]["version"]
function detectBrowser() {

	$useragent = $_SERVER["HTTP_USER_AGENT"];

	//---Internet Explorer---
		//$useragent = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; .NET4.0E; InfoPath.3; UHG_Win7_Build 11-15-2010)";
		//$useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko";
		//$useragent = "Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)";
		//$useragent = "Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)";
		//$useragent = "Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; InfoPath.1; SV1; .NET CLR 3.8.36217; WOW64; en-US)";
		//$useragent = "Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 5.2)";
		//$useragent = "Mozilla/4.01 (compatible; MSIE 6.0; Windows NT 5.1)";
		//$useragent = "Mozilla/4.0 (compatible; MSIE 5.0; Windows NT;)";
		//$useragent = "Mozilla/2.0 (compatible; MSIE 4.0; Windows 98)";
		//$useragent = "Mozilla/2.0 (compatible; MSIE 3.0; Windows 95)";
		//$useragent = "Mozilla/1.22 (compatible; MSIE 2.0; Windows 95)";
		//$useragent = "Microsoft Internet Explorer/4.0b1 (Windows 95)";

	//---Safari---
		//$useragent = "Mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) Mobile/11B554a";
		//$useragent = "Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5355d Safari/8536.25";
		//$useragent = "Mozilla/5.0 (iPad; CPU OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko ) Version/5.1 Mobile/9B176 Safari/7534.48.3";
		//$useragent = "Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; ja-jp) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5";
		//$useragent = "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_1 like Mac OS X; en-us) AppleWebKit/532.9 (KHTML, like Gecko) Version/4.0.5 Mobile/8B117 Safari/6531.22.7";
		//$useragent = "Mozilla/5.0 (iPhone Simulator; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7D11 Safari/531.21.10";
		//$useragent = "Mozilla/5.0 (iPhone; U; CPU iPhone OS 2_0_1 like Mac OS X; fr-fr) AppleWebKit/525.18.1 (KHTML, like Gecko) Version/3.1.1 Mobile/5G77 Safari/525.20";
		//$useragent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2";
		//$useragent = "mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.36+ (khtml, like gecko) version/1.2 Safari/8536.25";
		//$useragent = "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/312.8.1 (KHTML, like Gecko) Safari/312.6";

	//---Chrome---
		//$useragent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36";
		//$useragent = "mozilla/5.0 (iPad; CPU OS 7_0_4 like Mac OS X) applewebkit/537.51.1 (khtml, like gecko) CriOS/31.0.1650.18 Mobile/11B554a safari/8536.25";
		//$useragent = "mozilla/5.0 (x11; linux x86_64) applewebkit/537.36 (khtml, like gecko) chrome/27.2.1547.57 safari/537.36";
		//$useragent = "Mozilla/5.0 (Macintosh; U; Mac OS X 10_5_7; en-US) AppleWebKit/530.5 (KHTML, like Gecko) Chrome/ Safari/530.5";

	//---Iceweasel---
		//$useragent = "mozilla/5.0 (x11; linux x86_64; rv:17.0) gecko/20130917 firefox/17.0 iceweasel/15.2.9";
		//$useragent = "Mozilla/5.0 (X11; U; Linux i686; de; rv:1.8.1.1) Gecko/20061205 Iceweasel/2.0.0.1 (Debian-2.0.0.1+dfsg-2)";
		//$useragent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.0.8pre) Gecko/20061001 Firefox/1.5.0.8pre (Iceweasel)";
		//$useragent = "Mozilla/5.0 (Linux) Gecko Iceweasel (Debian) Mnenhy";

	//---Firefox---
		//$useragent = "mozilla/5.0 (x11; linux x86_64; rv:17.0) gecko/20130917 firefox/19.5.20";
		//$useragent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.5) Gecko/20041128 Firefox/1.0 (Debian package 1.0-4)";
		//$useragent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.8.1.19) Gecko/20081202 Firefox (Debian-2.0.0.19-0etch1)";
		//$useragent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.9.0.6) Gecko/2009011913 Firefox";

	//---Opera---
		//$useragent = "Opera/9.80 (X11; Linux x86_64) Presto/2.12.388 Version/12.16";
		//$useragent = "Opera/9.80 (Windows NT 6.1; U; es-ES) Presto/2.9.181 Version/12.00";
		//$useragent = "Opera/9.80 (Windows NT 6.1; U; zh-cn) Presto/2.6.37 Version/11.00";
		//$useragent = "Opera/9.80 (Windows NT 6.1; U; fi) Presto/2.2.15 Version/10.00";
		//$useragent = "Opera/9.00 (Windows NT 5.1; U; pl)";
		//$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.0";
		//$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.0) Opera 7.0 [en]";
		//$useragent = "Opera/7.0 (Windows NT 4.0; U) [de]";
		//$useragent = "Mozilla/4.0 (compatible; MSIE 5.0; Windows NT 4.0) Opera 6.0 [de]";
		//$useragent = "Opera/6.0 (Windows 2000; U) [fr]";
		//$useragent = "Mozilla/4.0 (compatible; MSIE 5.0; Linux) Opera 5.0 [en]";

	$detect = false;

	//Launch detections
	if ($detect == false) $detect = InternetExplorer($useragent);
	if ($detect == false) $detect = Safari($useragent);
	if ($detect == false) $detect = Firefox($useragent);
	if ($detect == false) $detect = Iceweasel($useragent);
	if ($detect == false) $detect = Chrome($useragent);
	if ($detect == false) $detect = Opera($useragent);

	return $detect;
}



// ---------------------------------------
// Detect browsers functions
// ---------------------------------------

	//Detect Internet Explorer
	function InternetExplorer($useragent) {

		$result = false;
	
		//Internet Explorer >= 11, only "trident" string is present
		if	(
				!preg_match("/msie/i", $useragent)
				&& preg_match("/^.+ \(([^;]+); ([^;]+); trident\/([0-9\.]+); rv\:([0-9\.]+)[;|\)].*$/i", $useragent, $matches)
			) {

				$result["useragent"]			= $useragent;
				$result["browser"]["name"]		= "Internet Explorer";
				$result["browser"]["version"]	= versionToArray($matches[4]);
				$result["engine"]["name"]		= "Trident";
				$result["engine"]["version"]	= versionToArray($matches[3]);
				$result["os"]					= OSToArray($matches[1]);
		
		//Internet Explorer <= 10, only "msie" string is present
		} elseif (preg_match("/^.+msie ([0-9\.]+); ([^;]+);{0,1}.*/i", $useragent, $matches)) {
				$result["useragent"]			= $useragent;
				$result["browser"]["name"]		= "Internet Explorer";
				$result["browser"]["version"]	= versionToArray($matches[1]);
				$result["os"]					= OSToArray($matches[2]);

		//Internet Explorer v1 (for fun)
		} elseif (preg_match("/^microsoft internet explorer\/4\.0b1 \((.+)\)$/i", $useragent, $matches)) {
				$result["useragent"]			= $useragent;
				$result["browser"]["name"]		= "Internet Explorer";
				$result["browser"]["version"]	= versionToArray("1.0.0");
				$result["os"]					= OSToArray($matches[1]);
		}

		return $result;
	}


	//Detect Safari
	function Safari($useragent) {

		$result = false;

		//To prevent against Chrome similitude
		if	(
				!preg_match("/chrome/i", $useragent)
				&& !preg_match("/crios/i", $useragent)
			) {

			//Safari >= 3
			if	(preg_match("/^.+\(([^\)]+)\).+applewebkit\/([0-9\.]+).+(version|mobile)\/([0-9\.]*).*$/i", $useragent, $matches)) {

				$result["useragent"]			= $useragent;
				$result["browser"]["name"]		= "Safari";
				$result["browser"]["version"]	= versionToArray($matches[4]);
				$result["engine"]["name"]		= "AppleWebKit";
				$result["engine"]["version"]	= versionToArray($matches[2]);
				$result["os"]					= OSToArray($matches[1]);

			//Safari < 3
			} elseif (preg_match("/^.+\(([^\)]+)\).+applewebkit\/([0-9\.]+).+safari\/([0-9\.]*).*$/i", $useragent, $matches)) {

				//The useragent don't have information to detect version (and num)

				$result["useragent"]			= $useragent;
				$result["browser"]["name"]		= "Safari";
				$result["browser"]["version"]	= versionToArray("0.0.0");
				$result["engine"]["name"]		= "AppleWebKit";
				$result["engine"]["version"]	= versionToArray($matches[2]);
				$result["os"]					= OSToArray($matches[1]);
			}
		}

		return $result;
	}


	//Detect Chrome and Chromium (computer and mobile version)
	function Chrome($useragent) {

		$result = false;

		if (preg_match("/^.+\(([^\)]+)\).+applewebkit\/([0-9\.]+).+(chrome|CriOS)\/([0-9\.]*).*$/i", $useragent, $matches)) {

			//Detect version
			if ($matches[3] == "") { $browser_version = "0.0.0";
			} else { $browser_version = $matches[4]; }

			$result["useragent"]			= $useragent;
			$result["browser"]["name"]		= "Chrome";
			$result["browser"]["version"]	= versionToArray($browser_version);
			$result["engine"]["name"]		= "AppleWebKit";
			$result["engine"]["version"]	= versionToArray($matches[2]);
			$result["os"]					= OSToArray($matches[1]);
		}

		return $result;
	}

	//Detect Iceweasel
	function Iceweasel($useragent) {

		$result = false;

		if (preg_match("/^.+\(([^\)]+)\).+gecko[\/]*([0-9\.]*).+iceweasel(.*)$/i", $useragent, $matches)) {

			//Detect version
			if (preg_match("/^\/([0-9\.]+).*$/i", $matches[3], $version)) {
				$browser_version = $version[1];
			} else { $browser_version = "1.0.0"; }

			$result["useragent"]			= $useragent;
			$result["browser"]["name"]		= "Iceweasel";
			$result["browser"]["version"]	= versionToArray($browser_version);
			$result["engine"]["name"]		= "Gecko";
			$result["engine"]["version"]	= versionToArray($matches[2]);
			$result["os"]					= OSToArray($matches[1]);
		}

		return $result;
	}

	//Detect Firefox
	function Firefox($useragent) {

		$result = false;

		if	(
				!preg_match("/iceweasel/i", $useragent)
				&& preg_match($pattern = "/^.+\(([^\)]+)\).+gecko\/([0-9\.]+).+firefox(.*)$/i", $useragent, $matches)
			) {

			//Detect version
			if (preg_match("/^\/([0-9\.]+).*$/i", $matches[3], $version)) {
				$browser_version = $version[1];
			} else { $browser_version = "0.0.0"; }

			$result["useragent"]			= $useragent;
			$result["browser"]["name"]		= "Firefox";
			$result["browser"]["version"]	= versionToArray($browser_version);
			$result["engine"]["name"]		= "Gecko";
			$result["engine"]["version"]	= versionToArray($matches[2]);
			$result["os"]					= OSToArray($matches[1]);
		}

		return $result;
	}


	//Detect Opera
	function Opera($useragent) {

		$result = false;

		//Opera > 10
		if	(preg_match($pattern = "/^.+\(([^\)]+)\).+presto\/([0-9\.]+).+version\/([0-9\.]+).*$/i", $useragent, $matches)) {

			$result["useragent"]			= $useragent;
			$result["browser"]["name"]		= "Opera";
			$result["browser"]["version"]	= versionToArray($matches[3]);
			$result["engine"]["name"]		= "Presto";
			$result["engine"]["version"]	= versionToArray($matches[2]);
			$result["os"]					= OSToArray($matches[1]);

		//Opera ?
		} elseif (preg_match($pattern = "/opera/i", $useragent, $matches)) {
			$result["useragent"]			= $useragent;
			$result["browser"]["name"]		= "Opera";
			$result["browser"]["version"]	= versionToArray("0.0.0");
			$result["engine"]["version"]	= versionToArray("0.0.0");
			$result["os"]					= OSToArray("");
		}

		return $result;
	}


// ---------------------------------------
// Utils
// ---------------------------------------

	//Convert string os to array if match
	function OSToArray($string) {

		$result = false;

		//Detect iOS
		if	(preg_match("/^(ipad|iphone|ipod).+ OS ([0-9\_]+).*$/i", $string, $matches)) {

			$result["name"]			= "iOS";
			$result["hardware"]		= $matches[1];
			$result["version"]		= versionToArray(preg_replace("/_/im",".", $matches[2]));
		
		//Detect Android
		} elseif (preg_match("/android/i", $string)) {

			$result["name"]	= "Android";

			//Version & hardware
			if	(preg_match("/^.+; android ([0-9\.]+); (.*)$/i", $string, $matches)) {
				$result["hardware"]		= $matches[2];
				$result["version"]		= versionToArray($matches[1]);
			}

		//Detect Linux
		} elseif (preg_match("/linux/i", $string)) {
			$result["name"]	= "Linux";
		
		//Detect Windows
		} elseif (preg_match("/windows/i", $string)) {
			$result["name"]	= "Windows";
			
		//Detect Apple
		} elseif (preg_match("/macintosh/i", $string)) {
			$result["name"]	= "MacOS";
		
		//Other
		} else {
			$result = $string;
		} 

		return $result;
	}


	//Convert num string to float
	function versionToArray($string) {
		if (preg_match("/^([^\.]+)\.{0,1}([^\.]*)\.{0,1}([^\.]*)\.{0,1}(.*)$/", $string, $matches)) {
			$result["major"] = intval($matches[1]);
			$result["minor"] = intval($matches[2]);
			$result["micro"] = intval($matches[3]);
			$result["other"] = intval($matches[4]);
		}
		if (!$result) $result = $string;
		return $result;
	}

?>
