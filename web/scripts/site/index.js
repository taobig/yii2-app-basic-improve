/*global SimpleLoading*/
$(function () {

    $("#loading_btn").on("click", function (e) {
        SimpleLoading.start('gears'); 	// Load gears.gif
        // SimpleLoading.start('default'); // Load default.gif
        // SimpleLoading.start(); 			// Load default.gif

        setTimeout(function () {
            SimpleLoading.stop();
        }, 2000);
    });
});