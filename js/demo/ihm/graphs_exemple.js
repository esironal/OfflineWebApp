
/************************************************************************************************************
 * 
 * 
 * 
 ************************************************************************************************************/

function drawGraphExemple() {

	console.log("drawGraphExemple");


	//Valeurs
	var s1 = [];
	var s2 = [];
	for (var i=0; i<12;i++) {
		var mois = getMois(i+1);
		s1[i] = parseFloat(mois[0]["ca"]);
		s2[i] = parseFloat(mois[0]["benef"]);
	}

	console.log(s1);
	console.log(s2);

    // Les mois
    var ticks = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    graph_exemple = $.jqplot('graph_exemple', [s1, s2], {

    	// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
    	// Turns on animation for all series in this plot
        animate: !$.jqplot.use_excanvas,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,

    	title: "Chiffre d'affaires et bénéfice de l'année 2013",

    	// Provide a custom seriesColors array to override the default colors
    	seriesColors:['#d63e50', '#4f7588'],

    	// The "seriesDefaults" option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: { 
            	fillToZero: true,
            	animation: { speed: 1500 }
            },
            // Show point labels to the right ('e'ast) of each bar.
            // edgeTolerance of -15 allows labels flow outside the grid
            // up to 15 pixels.  If they flow out more than that, they
            // will be hidden.
            pointLabels: { show: true, edgeTolerance: -15 }
        },
        // Custom labels for the series are specified with the "label"
        // option on the series option.  Here a series option object
        // is specified for each series.
		series:[
		        { label: "Chiffre d'affaires" },
		        { label: "Bénéfice" }
		        ],
		        
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of "outside" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: { show: true, location: 's', placement: 'outsideGrid' },

        grid: {
            background: '#F8F8F8', // CSS color spec for background color of grid
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            yaxis: {
                tickOptions: {formatString: "%'i €"},
                label:'',
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            }
        }
    });
    graph_exemple.replot();
}

