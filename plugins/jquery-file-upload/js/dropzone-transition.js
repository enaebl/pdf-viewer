$(document).bind('dragover', function (e) {
    var dropZone = $('#dropzone'), timeout = window.dropZoneTimeout;
    if (timeout) {
        clearTimeout(timeout);
    } else {
        dropZone.addClass('in');
    }
    var hoveredDropZone = $(e.target).closest(dropZone);
    dropZone.toggleClass('hover', hoveredDropZone.length);
    window.dropZoneTimeout = setTimeout(function () {
        window.dropZoneTimeout = null;
        dropZone.removeClass('in hover');
    }, 100);
});