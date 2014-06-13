/*******************************************************************************
 * 
 * 	All functions to animate the progress bar
 * 
 *******************************************************************************/

function ProgressPercent(percent) {
	//console.log("Demo - ProgressPercent("+ percent +")");
	$("#progBar_percent_value").css("width",percent+'%');
}

function ProgressBarShow() {
	console.log("Demo - ProgressBarShow");
	$('#LabelWait').modal('show');
}

function ProgressBarHide() {
	console.log("Demo - ProgressBarHide");
	$('#LabelWait').modal('hide');
	window.setTimeout(function() {ProgressBarReset(); },500);
}

function ProgressBarReset() {
	console.log("Demo - ProgressBarReset");
	$("#progBar_percent_value").css("width",'0%');
}

function ProgressBarTitle(title) {
	console.log("Demo - ProgressBarTitle");
	$("#progBar_title_value").html(title);
}

function ProgressBarImg(css) {
	console.log("Demo - ProgressBarImg");
	$("#progBar_img").removeClass();
	$("#progBar_img").addClass(css);
	$("#progBar_img").css("margin","20px 0px 0px 0px");
	$("#progBar_img").css("font-size","100px");
}
