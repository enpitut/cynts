$('input[type="submit"]').mousedown(function () {
    $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function () {
    $(this).css('background', '#1abc9c');
});

$('#headerLoginForm').click(function () {
    $('.loginWindow').fadeToggle('slow');
    $(this).toggleClass('selected');
});

$(document).mouseup(function (e) {
    var container = $(".loginWindow");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
        $('#headerLoginForm').removeClass('selected');
    }
})
