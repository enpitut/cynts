var coordinate_id0;
var coordinate_id1;
var push_enable = true;
var last_time_coordinate_id = -1;
var n_continuously_like = 1;
const NUM_FOR_FAV = 10;

/**
 * コーデ画像を更新する
 * @param obj
 * @param like_coordinate_id
 * @param dislike_coordinate_id
 */
function updateCoordinateImage(obj, like_coordinate_id, dislike_coordinate_id) {
    var like_side_new_coordinate;
    var dislike_side_new_coordinate;
    var like_side_obj_id = obj.id[5];
    var dislike_side_obj_id = String((Number(obj.id[5])+1)%2);

    if (!push_enable){ return; }

    try {
        getNewCoordinateImage(like_coordinate_id, dislike_coordinate_id).done(
            function(coordinate_data) {
                dislike_side_new_coordinate = JSON.parse(coordinate_data);

                animateCoordinateImage(
                    dislike_side_obj_id,
                    dislike_side_new_coordinate
                );
            }
        );

        if (like_coordinate_id == last_time_coordinate_id) {
            if (++n_continuously_like >= NUM_FOR_FAV) {
                alert(NUM_FOR_FAV + "回連続で同じコーデを選んだので, お気に入りに登録しました!");

                favoriteCoordinate(like_coordinate_id).done(function (result) {
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
    } catch (exception) {
        alert(exception);
    }
}

/**
 * 2つのコーデIDを与えると，それらと重複しない新たなコーデIDを取得してくる
 * @param coordinate_id
 * @param dislike_id
 */
function getNewCoordinateImage(coordinate_id, dislike_id) {
    var data = {id: coordinate_id, d_id: dislike_id};
    return $.ajax({
        type: "POST",
        url: "send",
        data: data,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            throw new Error(errorThrown);
        }
    });
}

/**
 * コーデをお気に入りする
 * @param coordinate_id
 */
function favoriteCoordinate(coordinate_id) {
    var send_data = {favorite_id: coordinate_id};
    return $.ajax({
        type: "POST",
        url: "favorite",
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
