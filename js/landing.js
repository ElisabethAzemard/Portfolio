$( document ).ready(function() {
	function cacher(){
		var $height = $(window).height();
		$("#landing").height($height);
		$("#contentindex").hide();
		$("#portfolioButton").on("click" (function() {
			$("#landing").hide();
			$("#contentindex").show();
		}));
	}
});
