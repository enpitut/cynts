$.fn.extend({
    toggleButtons : function(callback){
        var radios = this;
        radios.on("change", function(e){
            $(e.target).parent().parent().children(".selected").removeClass("selected");
            $(e.target).closest("label").addClass("selected");
            callback.call(this, e);
        });
        radios.closest("label").on("click", function(e){
            var input = $(this).find("input");
            if(! input.prop("checked")){
                input.prop("checked", true).trigger("change");
            }
        });
        radios.filter(":checked").trigger("change");
    }
});

$("input[type='radio']").toggleButtons(function(e){
   });

/**
 * controller の action へ POST メソッドで ajax による通信を行う
 * @param action データ送信先の action
 * @param send_data action へ送信するデータ
 * @param args done ブロック等に引数でデータを渡したい場合には, ここに記述する
 * @returns {*}
 */
function sendPostInView(action, send_data, args) {
    var controller = location.origin + "/coordinates/";
    return $.ajax({
        type: "POST",
        url: controller + action,
        data: send_data,
        context: args
    })
}

function addFavorite(favorite_id) {
    var dfd = $.Deferred();

    sendPostInView("ajaxPostFavorite", {coordinate_id: favorite_id}, null)
        .done(function() {
            alert("お気に入りに登録しました！");
            if(location.pathname === "/coordinates_battle/battle") {
                showCoordinateDetail(favorite_id);
            } else {
                window.location.reload();
            }

        });

    return dfd.promise();
}
