$(function () {

    $(".fullscreen-supported").toggle($(document).fullScreen() != null);
    $(".fullscreen-not-supported").toggle($(document).fullScreen() == null);

    $(document).bind("fullscreenchange", function (e) {
        if ($(document).fullScreen()) {
            $('#full-screen').attr('title', 'Disable fullscreen');
        } else {
            $('#full-screen').attr('title', 'Enable fullscreen');
        }
    });

    $(document).bind("fullscreenerror", function (e) {
        console.log("Full screen error.");
        $("#status").text("Browser won't enter full screen mode for some reason.");
    });

});
