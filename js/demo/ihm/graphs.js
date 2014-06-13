

var graph_exemple;


$(window).resize(function() {
	if (graph_exemple) {
		graph_exemple.destroy();
		drawGraphExemple();
	}
	
});
