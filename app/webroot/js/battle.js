var coordinate_id0;
var coordinate_id1;
var push_enable = true;
var last_time_coordinate_id = -1;
var n_continuously_like = 1;
const NUM_FOR_FAV = 10;

/**
 * 押下されたコーデを加点後，次に表示するコーデを取得し，表示を切り替える
 */
function img_update(obj, coordinate_id, dislike_id) {
    if (!push_enable){ return; }

    if (coordinate_id == last_time_coordinate_id) {
        if (++n_continuously_like >= NUM_FOR_FAV) {
            favorite_coordinate(coordinate_id);
            n_continuously_like = 1;
        }
    } else {
        n_continuously_like = 1;
    }
    last_time_coordinate_id = coordinate_id;

    var data = {id: coordinate_id, d_id: dislike_id};
    $.ajax({
        type: "POST",
        url: "send",
        data: data,
        success: function (data, dataType) {
            data = (new Function("return " + data))();
            img_animate(obj.id[5], data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    });
}

function favorite_coordinate(coordinate_id) {
    var send_data = {favorite_id: coordinate_id};
    $.ajax({
        type: "POST",
        url: "favorite",
        data: send_data,
        success: function (send_data, dataType) {
            if (send_data == "saved") {
                alert(NUM_FOR_FAV + "回連続で同じコーデを選んだので, お気に入りに登録しました!");
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            alert('Error : ' + errorThrown);
        }
    })
}

/**
 * 次のコーデ画像へアニメーションする
 */
function img_animate(obj_id, coordinate_data) {
    obj_id = String((Number(obj_id)+1)%2);

    push_enable = false;

    // フェードアウト用画像を表面に持ってくる
    $("#fadephoto" + obj_id).css({
        "opacity":0.75,
        "z-index":1
    });
    $("#photo" + obj_id).css({
        "z-index":0
    });

    // 裏にまわった画像を次の画像に置き換える
    $("#photo" + obj_id).attr("src", "/img/" + coordinate_data["url"]);
    if (Number(obj_id)){
        coordinate_id1 = coordinate_data["id"];
        $("#fadephoto" + obj_id).velocity(
            {
                left: 200,
                opacity: 0,
            },
            500,
            function () {
                dealing_after_animation(obj_id, coordinate_data);
            }
        );
    } else {
        coordinate_id0 = coordinate_data["id"];
        $("#fadephoto" + obj_id).velocity(
            {
                right: 200,
                opacity: 0,
            },
            500,
            function () {
                dealing_after_animation(obj_id, coordinate_data);
            }
        );
    }
}

/**
 * アニメーションの事後処理を行う．
 * フェードアウトさせた画像の位置を戻したり，ボタン押下を有効化したり
 */
function dealing_after_animation(obj_id, coordinate_data) {
    $("#fadephoto" + obj_id).css({
        "z-index":0
    });
    // fadephoto を表示済みの画像に置き換える
    $("#fadephoto" + obj_id).attr("src", "/img/" + coordinate_data["url"]);
    $("#photo" + obj_id).css({
        "z-index":1
    });
    if (Number(obj_id)){
        $("#fadephoto" + obj_id).velocity(
            { left:0 },
            0,
            function () { push_enable=true; }
        );
    } else {
        $("#fadephoto" + obj_id).velocity(
            { right:0 },
            0,
            function () { push_enable=true; }
        );
    }
}