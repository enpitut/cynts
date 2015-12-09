/**
 * Created by ace on 2015/11/16.
 */

const HELP_ROOT = location.origin + "/pages/"
var $script_id = $('#help_script');
var caller_url = ($script_id.attr('controller') + "_" + $script_id.attr('action')).toLowerCase();

function displayModalHelpWindow() {
    $(this).blur();
    if($("#modal_overlay")[0]) return false;

    $("body").append('<div id="modal_overlay"></div>');
    $("body").append('<div id="close_message">クリックすれば，この画面は閉じます．</div>');
    $("body").append('<div id="modal_help"><div id="center_window"></div></div>');

    $("#center_window").load(HELP_ROOT + "help #modal_help_" + caller_url ,function() {
        $(document).ready(function() {
            $("#modal_help_" + caller_url).prepend('<div id="help_title">ヘルプ</div>')
            $("#modal_overlay, #modal_help, #close_message").fadeIn("slow");

            $("#modal_overlay, #modal_help, #close_message").unbind().click(function() {
                $("#modal_overlay, #modal_help, #close_message").fadeOut("slow", function() {
                    $("#modal_overlay, #modal_help, #close_message").remove();
                });
            });
        });
    })
}

$(function() {
    $.get(HELP_ROOT + "help #modal_help_" + caller_url, function(data, status){
        if(status === "success") {
            if(data.match(caller_url)) {
                if(!(Number($script_id.attr('isVisited')))){
                    displayModalHelpWindow();
                }

                $("#modal_open").click(function() {
                    displayModalHelpWindow();
                });
            } else {
                $("#modal_open").remove();
            }
        }
    });
});
