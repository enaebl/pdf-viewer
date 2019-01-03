$(document).ready(function (e) {

    //$('#override').click(function(e) {
    var elm = $(this);
    if (!elm.hasClass('revert')) {
        elm.attr('value', 'Revert').addClass('revert');
        $('body').contextMenu('#popup', {triggerOn: 'contextmenu'});
    } else {
        elm.attr('value', 'Override').removeClass('revert');
        $('body').contextMenu('destroy');
    }
    //});

});
