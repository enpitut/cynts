const HOST_PATH = location.origin;
var $script_id = $('#help_script');
var caller_url = ($script_id.attr('controller') + "_" + $script_id.attr('action')).toLowerCase();

$(document).ready(function () {
    //定数読込
    $.getJSON(HOST_PATH + "/help_data/" + caller_url + ".json", function (data) {
        for (var block in data) {
            $(block).attr({
                'data-intro': data[block]["data-intro"],
                'data-position': data[block]["data-position"]
            });
        }
    });
});

(function() {
    $(function() {
        $('body').chardinJs();
        $('a[data-toggle="chardinjs"]').on('click', function(e) {
            ($('body').data('chardinJs')).toggle();
        });
        return $('body').on('chardinJs:stop', function() {
        });
    });

}).call(this);
