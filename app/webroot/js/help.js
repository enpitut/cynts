/**
 * Created by ace on 2015/11/16.
 */

const HELP_ROOT = "http://localhost:8765/pages/"
var $script_id = $('#help_script');
var controller_name = $script_id.attr('controller_name');

$("#modal_open").click(
    function () {
        $(this).blur();
        if($("#modal_overlay")[0]) return false;

        $("body").append('<div id="modal_overlay"></div>');
        $("#modal_overlay").fadeIn("slow");

        $("body").append('<div id="modal_help"></div>');
        $("#modal_help").load(HELP_ROOT + "help #modal_help_" + controller_name, function(data) {
            if(data === null) {
                console.log("Reading Error");
            }
        })

        $("#modal_overlay, #modal_help").unbind().click(function() {
            $("#modal_overlay, #modal_help").fadeOut("slow", function() {
                $("#modal_overlay, #modal_help").remove();
            });
        });
    }
)


