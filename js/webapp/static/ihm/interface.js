/*******************************************************************************
 * 
 * 	All functions to animate html objects
 * 
 *******************************************************************************/

/**
 * Center an image
 */
jQuery.fn.center = function () {
	this.css("position", "fixed");
	this.css("top", ( $(window).height() - this.height() ) / 2 + $(window).scrollTop() + "px");
	this.css("left", ( $(window).width() - this.width() ) / 2 + $(window).scrollLeft() + "px");
};


/**
 * Animation simulating a progress bar
 */
function animation() {

	$("#animation").removeClass('hide');
	$('#animation').css("width", "0%");
	$("#animation").show();
	$('#animation').animate({
		width: '100%'
	}, {
		// If finished
		complete: function() {
			$("#animation").fadeOut(100);
		}
	});
}