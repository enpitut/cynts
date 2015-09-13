var coordinate_id0;
var coordinate_id1;
var push_enable = true;
var last_time_coordinate_id = -1;
var n_continuously_like = 1;
var n_battle = 1;
var usr_score = 0;
var battle_history = "";
const NUM_FOR_FAV = 10;

/**
 * コーデ画像を更新する
 * @param obj
 * @param like_coordinate_id
 * @param dislike_coordinate_id
 */
function updateCoordinateImage(obj, like_coordinate_id, dislike_coordinate_id, max_n_battle) {
    var like_side_new_coordinate;
    var dislike_side_new_coordinate;
    var like_side_obj_id = obj.id[5];
    var dislike_side_obj_id = String((Number(obj.id[5])+1)%2);

    if (!push_enable){ return; }

    try {
        if (n_battle == 1) {
            battle_history =
                '{' +
                '"max_n_battle":' + max_n_battle + ',' +
                '"battle_history": [';
        }

        // スコアを取得・記録する
        sendPost("getScore",
            {
                a_side_coordinate_id: coordinate_id0,
                b_side_coordinate_id: coordinate_id1,
                liked_coordinate_id: like_coordinate_id
            }
        ).done(
            function(result) {
                var result_data = JSON.parse(result);

                // コーデバトルの履歴を保持する
                if (n_battle != 2) {
                    battle_history += ',';
                }
                battle_history +=
                    '{' +
                    '"a_side_coordinate_id":' + coordinate_id0 + ',' +
                    '"a_side_coordinate_point":' + result_data["a_side_point"] + ',' +
                    '"b_side_coordinate_id":' + coordinate_id1 + ',' +
                    '"b_side_coordinate_point":' + result_data["b_side_point"] + ',' +
                    '"selected_side":' + like_coordinate_id +
                    '}';

                // スコアを保持する
                usr_score += parseFloat(result_data["score"]);
            }
        );

        // 押下されなかった画像を差し替える
        sendPost("getNewCoordinate",
            {
                liked_coordinate_id: like_coordinate_id,
                disliked_coordinate_id: dislike_coordinate_id
            }
        ).done(
            function(coordinate_data) {
                dislike_side_new_coordinate = JSON.parse(coordinate_data);

                animateCoordinateImage(
                    dislike_side_obj_id,
                    dislike_side_new_coordinate
                );
            }
        );

        // お気に入りの判定 & 処理
        if (like_coordinate_id == last_time_coordinate_id) {
            if (++n_continuously_like >= NUM_FOR_FAV) {
                alert(NUM_FOR_FAV + "回連続で同じコーデを選んだので, お気に入りに登録しました!");

                sendPost("favorite", {favorite_id: like_coordinate_id}).done(function (result) {
                    if (result == "saved") {
                        getNewCoordinateImage(like_coordinate_id, dislike_side_new_coordinate.id).done(
                            function (coordinate_data) {
                                like_side_new_coordinate = JSON.parse(coordinate_data);

                                animateCoordinateImage(
                                    like_side_obj_id,
                                    like_side_new_coordinate
                                )
                            }
                        );
                    }
                });
                n_continuously_like = 1;
            }
        } else {
            n_continuously_like = 1;
        }
        last_time_coordinate_id = like_coordinate_id;

        // バトル終了判定 & redirect
        if (++n_battle > max_n_battle) {
            battle_history +=
                '],' +
                '"score":"' + usr_score + '"' +
                '}';
            alert(battle_history);

            var html =
                "<form method='post' action='result' id='refresh' style='display: none;'>" +
                "<input type='hidden' name='battle_history' value='" + battle_history  + "' >" +
                "</form>";
            $("body").append(html);
            $("#refresh").submit();
        }

    } catch (exception) {
        alert(exception);
    }
}


function sendPost(action, send_data) {
    return $.ajax({
        type: "POST",
        url: action,
        data: send_data,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            throw new Error(errorThrown);
        }
    })
}


/**
 * コーデ画像をアニメーションで置き換える
 * @param obj_id
 * @param coordinate_data
 */
function animateCoordinateImage(obj_id, coordinate_data) {
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
                dealingAfterAnimation(obj_id, coordinate_data);
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
                dealingAfterAnimation(obj_id, coordinate_data);
            }
        );
    }
}


/**
 * アニメーションの事後処理を行う
 * @param obj_id
 * @param coordinate_data
 */
function dealingAfterAnimation(obj_id, coordinate_data) {
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
