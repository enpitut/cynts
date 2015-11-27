var $script_id = $('#help_script');
var caller_url = ($script_id.attr('controller') + "_" + $script_id.attr('action')).tolowerCase();

$(window).load(function() {
    //定数読込
    $.getJSON("help_data/" + caller_url + ".json", function(data) {
        for(var id in data) {
            $("#" + id).attr({
                'data_intro': id.data_intro,
                'data_position': id.position
            });
        }
    });
});
