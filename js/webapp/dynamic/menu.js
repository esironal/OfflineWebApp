/*******************************************************************************
 * 
 * 	All functions to build menus
 * 
 *******************************************************************************/

// Global variables
var running_page;		// Id
var Groups = [];		// All groups
var Categories = [];	// All categories
var Pages = [];			// All pages
var Navigation = [];	// Navigation order


/**
 * Init menu map
 */
function createMap() {

	Categories["webapp"]		= "";
	Categories["exemple"] 		= "";

	Groups["presentation"] 		= "";
	Groups["technique"] 		= "";
	Groups["donnees"] 			= "";
	Groups["graphs"] 			= "";


  	Pages["fonctionnalitees"] 	= "";
  	Pages["philo"] 				= "";
 	Pages["telechargement"] 	= "";

  	Pages["principe"] 			= "";
  	Pages["bdd"] 				= "";

  	Pages["inputs"] 			= "";
  	Pages["resultats"] 			= "";

	Navigation[0]  = "webapp_presentation_fonctionnalitees";
	Navigation[1]  = "webapp_presentation_philo";
	Navigation[2]  = "webapp_presentation_telechargement";

	Navigation[3]  = "webapp_technique_principe";
	Navigation[4]  = "webapp_technique_bdd";

	Navigation[5]  = "exemple_donnees_inputs";
	Navigation[6]  = "exemple_graphs_resultats";

}

/**
 * Return the index for the page
 * 
 * @param pageName The name of the page
 * @returns {Number}
 */
function navigationIndex(pageName) {
	for (var i = 0; i < Navigation.length; i++) {
		if (Navigation[i] == pageName) {
			return i;
			break;
		}
	}
}

/**
 * Return the previous page in the navigation or the same page if the running page is the first page
 * 
 * @returns The full name of the previous page
 */
function navigationPrevious () {
	if (running_page - 1 >= 0) {
		return Navigation[running_page - 1];
	} else {
		return Navigation[running_page];
	}
}

/**
 * Return the next page in the navigation or the same page if the running page is the last page
 * 
 * @returns The full name of the next page
 */
function navigationNext () {
	if (running_page < Navigation.length - 1) {
		return Navigation[running_page + 1];
	} else {
		return Navigation[running_page];
	}
}

/**
 * Show a visual progression using small icons at the bottom of the page.
 * Change the colour of the inputs/results menus at the top of the page.
 */
function navigationPoints() {

	var count = 0; 	// Number of icons
	var info;		// Information on the page
	var html = "";	// Html content shown in the end

	info = extractInfoFromPage(Navigation[running_page]);

	// Category of the running page
	var category = info["Category"];

	// Reset css for the inputs menu
	$("#menu_webapp").removeClass("active");
	$("#menu_webapp ul li a").each(function(index, element) {
		$(element).removeClass("linkActive");		
	});

	// Reset css for the results menu
	$("#menu_exemple").removeClass("active");
	$("#menu_exemple ul li a").each(function(index, element) {
		$(element).removeClass("linkActive");		
	});

	// Loop through all pages (inputs and results)
	for ( var i = 0; i < Navigation.length; i++ ) {

		info = extractInfoFromPage(Navigation[i]);

		// Same category as the running page
		if (info["Category"] == category) {
	
			// Number of links in the category
			count++;

			// Same page as the running page => active icon
			if (i == running_page) {

				html = html + "<a href=\"#\" onClick=\"showPage('"+ Navigation[i] +"');\" title=\""+ Pages[info["Page"]] +"\">";
				html = html + "<span id=\"MenuBottomMiddleActive\" class=\"glyphicon glyphicon-certificate\"></span></a>";

				// Add linkActive in the corresponding menu
				$("#menu_"+category+" ul li a").each(function(index, element) {

					if (navigationIndex($(element).attr("onClick").replace("showPage('","").replace("');","")) == running_page) {
						$(element).addClass("linkActive");
					}			
				});		
	
			// Otherwise => non active icon
			} else {

				html = html + "<a href=\"#\" onClick=\"showPage('"+ Navigation[i] +"');\" title=\""+ Pages[info["Page"]] +"\">";
				html = html + "<span class=\"glyphicon glyphicon-certificate\"></span></a>";
			}
		}
	}

	// Change css for the inputs or results menu
	$("#menu_"+category).addClass("active");

	// Show html in the bottom div
	if (count > 1) {
		$("#MenuBottomMiddle").html(html);
	} else {
		$("#MenuBottomMiddle").html("&nbsp");
	}
}

/**
 * Return an array with Category, Group and Page name
 * 
 * @param pageName The name of the page
 * @returns {Array} The information on the page
 */
function extractInfoFromPage(pageName) {

	var regex = new RegExp(/^([^_]+)_([^_]+)_([^_]+)$/);
	var values = [];
	values["Category"] = pageName.replace(regex, "$1");
	values["Group"] = pageName.replace(regex, "$2");
	values["Page"] = pageName.replace(regex, "$3");

	return values;
}


/**
 * Hide all divs and show the divs of the page
 * 
 * @param pageName The name of the page
 */
function showPage(pageName) {

	/*
	 * Running page (Category, Group, Page and index)
	 */

	// Save data from previous page
	//if (running_page>0) saveDataFromPage(running_page);		

	// Request new page
	//var info = extractInfoFromPage(pageName);
	running_page = navigationIndex(pageName);
	console.log("Demo - showPage("+ pageName +") - Index : "+running_page);

	/*
	 * Hide all pages
	 */

	// Hide all divs
	// Filter is needed to show properly the select elements from bootstrap-select
	//$("#pages div").each(function(index, element) {
	$("#pages div").filter( function() {

		return $(this).parents("[class^='custom-select']").length < 1;

	}).each( function(index, element) {

		$(element).hide();
	});		

	// Show pages container
	$("#pages").removeClass('hide');

	// Hide arrows
	$("#arrowLeft").hide();
	$("#arrowRight").hide();
	$("#MenuBottomLeft").html("&nbsp");
	$("#MenuBottomRight").html("&nbsp");

	/*
	 * Show page
	 */

	// Show appropriate arrows
	if (running_page < Navigation.length - 1) {
		var html = "<a href=\"#\" onClick=\"showPage(navigationNext());\">";
		html = html + "<span id=\"arrowRight\" class=\"glyphicon glyphicon-circle-arrow-right\"></span></a>";
		$("#MenuBottomRight").html(html);
		$("#arrowRight").show();
	}
	if (running_page > 0) {
		var html = "<a href=\"#\" onClick=\"showPage(navigationPrevious());\">";
		html = html + "<span id=\"arrowLeft\" class=\"glyphicon glyphicon-circle-arrow-left\"></span></a>";
		$("#MenuBottomLeft").html(html);
		$("#arrowLeft").show();
	}

	// Show sub divs for active page
	// Filter is needed to show properly the select elements from bootstrap-select
	//$("#"+pageName+" div").each(function(index, element) {
	$("#"+pageName+" div").filter( function() {

		return $(this).parents("[class^='custom-select']").length < 1;

	}).each( function(index, element) {

		$(element).show();
	});

	// Animation simulating a progress bar
	animation();

	// Show navigationPoints
	navigationPoints();


	// Show active page
	$("#"+pageName).fadeIn(500);

	// Load data for new page after all div visible
	// Necessary for jqplots
	if (running_page == 6) drawGraphExemple();
	else if (graph_exemple) graph_exemple.destroy();
}

/**
 * Enable clicks on navtabs
 * 
 * @param id_tab id of the navtab
 * @param num_select Default selected tab
 */
function enableTabs(id_tab, num_select) {

	// Loop for each tab
	$('#'+ id_tab +' a').each(function (index, element) {

		// Hide content
		$($(element).attr('href')).hide();

		// Css
		$(element).parent().removeClass('active');

		// Show tab when clicked
		$(element).click(function(e) {

			// Disable local link
			e.preventDefault();

			// Hide all divs and reset css menu
			$('#'+ id_tab +' a').each(function (index, element) {
				$($(element).attr('href')).hide();
				$(element).parent().removeClass('active');
			});

			// Change ccs link
			$(element).parent().addClass('active');

			// Show divs
			//$($(element).attr('href')).show(600, "swing");
			$($(element).attr('href')).show();
		});
	});

	// Active first link
	$('#'+ id_tab +' a:eq('+ (num_select -1) +')').trigger('click');
}
