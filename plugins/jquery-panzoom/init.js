(function () {
    var $section = $('body');
    $section.find('.panzoom').panzoom({
        $zoomIn: $section.find("#zoom-in"),
        $zoomOut: $section.find("#zoom-out"),
        $zoomRange: $section.find(".zoom-range"),
        $reset: $section.find(".reset")
    });
})();
