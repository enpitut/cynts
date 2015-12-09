/**
 * battle.ctp で利用することを前提で作成しています
 * 他の場所では使用しないでください
 *
 * common.js をロードしていることを前提としています
 */

var coordinate_id0; // mean side_a
var coordinate_id1; // mean side_b
var push_enable = true;
var previous_like_coordinate_id = -1;
var n_continuously_like = 1;
var n_battle = 0;
var usr_score = 0;
var battle_info = {};
const MAX_N_BATTLE = 30;
const NUM_FOR_FAV = 10;
const COORDINATE_VIEW_ROOT = location.origin + "/coordinates/view"
const OFFSET_BOTTOM = 70;

/**
 * コーデ画像を更新する
 * @param side_id 選択した側がどちら側か？を示すID (0: 左, 1: 右)
 * @param like_coordinate_id 選択した側のコーデID
 * @param dislike_coordinate_id 選択しなかった側のコーデID
 */
function updateCoordinateImage(side_id, like_coordinate_id, dislike_coordinate_id) {
    var like_side_id = side_id.id[5];
    var dislike_side_id = String((Number(side_id.id[5]) + 1) % 2);

    if (!push_enable) {
        return;
    }

    if (n_battle == 0) {
        battle_info.battle_history = [];
    }

    try {
        var dfd = $.Deferred().resolve().promise();
        
        dfd.then(function() {

            return dfdGetScore(like_coordinate_id);

        }).then(function() {

            return dfdGetNewCoordinate(like_coordinate_id, dislike_coordinate_id);

        }).then(function(new_coordinate_data) {

            return dfdAnimateCoordinateImage(new_coordinate_data, dislike_side_id);

        }).then(function(new_coordinate_data) {

            // 前回と同じコーデが選択されたかどうか
            if (like_coordinate_id == previous_like_coordinate_id) {
                if (++n_continuously_like >= NUM_FOR_FAV) {

                    n_continuously_like = 1;
                    return dfdFavoriteCoordinate(new_coordinate_data["id"], like_coordinate_id, like_side_id);

                }
            } else {

                n_continuously_like = 1;
                return $.Deferred().resolve().promise();

            }

        }).done(function() {
            n_battle++;
            // バトル終了判定
            if (n_battle >= MAX_N_BATTLE) {

                finishBattle()

            }
            // 1回以上押下されたら finish ボタンを追加する
            if (n_battle == 1) {

                addFinishButton();

            }
        }).fail(function(e) {
            alert(e);
        });

        previous_like_coordinate_id = like_coordinate_id;

    } catch (exception) {
        alert(exception);
    }
}

function addFinishButton() {
    var element = document.getElementById('finish_button');
    var buttonElement = document.createElement('button');
    buttonElement.innerHTML = 'ゲーム終了!!';
    var action = "finishBattle();";
    buttonElement.setAttribute('onclick', action);
    element.appendChild(buttonElement);
}

function finishBattle() {
    battle_info.max_n_battle = n_battle;
    battle_info.score = usr_score;

    sendPost("createTicket", {ticket: null}, null).done(function(result) {
        var result_data = JSON.parse(result);
        battle_info.ticket = result_data.ticket;
        // redirect
        var html =
            "<form method='post' action='result' id='refresh' style='display: none;'>" +
            "<input type='hidden' name='battle_info' value='" + JSON.stringify(battle_info) + "' >" +
            "</form>";
        $("body").append(html);
        $("#refresh").submit();
    });
}


/**
 * 選択されたコーデからスコアを取得する
 * @param like_coordinate_id 選択されたコーデのコーデID
 * @returns {*}
 */
function dfdGetScore(like_coordinate_id) {
    var dfd = $.Deferred();

    sendPost("getScore",
        {
            a_side_coordinate_id: coordinate_id0,
            b_side_coordinate_id: coordinate_id1,
            liked_coordinate_id: like_coordinate_id
        },
        null
    ).done(function(result) {
            var result_data = JSON.parse(result);
            if (!result_data["hasSucceeded"]) {
                throw new Error(result_data["errorMessage"]);
            }

            // コーデバトルの履歴を保持する
            battle_info.battle_history.push({
                a_side_coordinate_id: coordinate_id0,
                a_side_coordinate_point: result_data["a_side_point"],
                a_side_coordinate_photo_path: result_data["a_side_photo_path"],
                b_side_coordinate_id: coordinate_id1,
                b_side_coordinate_point: result_data["b_side_point"],
                b_side_coordinate_photo_path: result_data["b_side_photo_path"],
                selected_side: like_coordinate_id === coordinate_id0 ? "a" : "b",
                result: result_data["result"]
            });

            // スコアを保持する
            usr_score += parseFloat(result_data["score"]);

            dfd.resolve();
        }
    );

    return dfd.promise();
}


/**
 * 2つのコーデと重複しない新たなコーデを取得する
 * 取得したコーデは次の then ブロックに引数として受け渡す
 * @param liked_coordinate_id 選択した側のコーデ
 * @param disliked_coordinate_id 選択されなかった側のコーデ
 * @returns {*}
 */
function dfdGetNewCoordinate(liked_coordinate_id, disliked_coordinate_id) {
    var dfd = $.Deferred();

    sendPost("getNewCoordinate",
        {
            liked_coordinate_id: liked_coordinate_id,
            disliked_coordinate_id: disliked_coordinate_id,
            // criteria_json は，battle.ctp で criteria_table.ctp が読み込まれることを前提として利用する
            coordinate_criteria: JSON.stringify(criteria_json)
        },
        null
    ).done(
        function(coordinate_data) {
            // 重複しない新たなコーデを取得する
            var new_coordinate = JSON.parse(coordinate_data);

            if (!new_coordinate["hasSucceeded"]) {
                alert(new_coordinate["errorMessage"]);
                $.Deferred().reject('Fail to get new coordinate');
                throw new Error('Fail to get new coordinate');
            }

            // 取得したコーデを次の then ブロックに渡す
            dfd.resolve(new_coordinate);
        }
    );

    return dfd.promise();
}


/**
 * コーデをお気に入り登録し, 画像を切り替える
 * @param dislike_coordinate_id
 * @param like_coordinate_id
 * @param like_side_obj_id
 * @returns {*}
 */
function dfdFavoriteCoordinate(dislike_coordinate_id, like_coordinate_id, like_side_obj_id) {
    var dfd = $.Deferred();

    sendPost("ajaxPostFavorite",
        {
            favorite_id: like_coordinate_id
        },
        {
            dislike_coordinate_id: dislike_coordinate_id,
            like_coordinate_id: like_coordinate_id,
            like_side_id: like_side_obj_id
        }
    ).done(function (result) {
            var register_favorite = JSON.parse(result);

            // hasSucceeded : POST したデータの validate 結果. やりとりしたデータの型が正しいかどうか
            // hasRegistered : お気に入り登録したか(既に登録されていた場合には登録されない
            if (register_favorite["hasSucceeded"]) {

                if (register_favorite["hasRegistered"]) {
                    alert(NUM_FOR_FAV + "回連続で同じコーデを選んだので, お気に入りに登録しました!");
                }

                // スコープ的に, ここで宣言しなおさないと then ブロック内で利用できない?
                var side_id = this.like_side_id;
                var like_coordinate_id = this.like_coordinate_id;
                var dislike_coordinate_id = this.dislike_coordinate_id;

                // 既にお気にいりだった場合でも，10回連続で同じコーデが選ばれたら切り替える
                // その方がゲームが面白いので(ランキング1位のものをずっと選んでいれば高得点が簡単に取れてしまう)
                $.Deferred().resolve().promise().then(function() {

                    return dfdGetNewCoordinate(like_coordinate_id, dislike_coordinate_id);

                }).then(function(new_coordinate_data) {

                    return dfdAnimateCoordinateImage(new_coordinate_data, side_id);

                }).done(function() {

                    dfd.resolve();

                });
            } else {
                throw new Error("Illegal post value");
            }
        }
    );

    return dfd.promise();
}

function didChangeCoordinatesCriteria() {
    updateCriteriaJson();
    updateCoordinateImagesByCriteria();
}

/**
 * 絞り込みの条件に合わせて新たな二つのコーデを取得し，アニメーションで切り替える
 */
function updateCoordinateImagesByCriteria() {
    sendPost("ajaxGetCoordinatesPairMatchCriteria",
        {
            a_side_coordinate_id: coordinate_id0,
            b_side_coordinate_id: coordinate_id1,
            // criteria_json は，battle.ctp で criteria_table.ctp が読み込まれることを前提として利用する
            coordinate_criteria: JSON.stringify(criteria_json)
        },
        null
    ).done(
        function(coordinates) {
            console.log(coordinates);
            // 重複しない新たなコーデを2つ取得する
            var new_coordinates = JSON.parse(coordinates);

            if (!new_coordinates["hasSucceeded"]) {
                alert(new_coordinates["errorMessage"]);
                $.Deferred().reject('Fail to get new coordinate');
            }

            // 現在のコーデを切り替える
            var dfd = $.Deferred().resolve().promise();
            dfd.then(function() {

                dfdAnimateCoordinateImage(new_coordinates[0], 0)

            }).then(function() {

                dfdAnimateCoordinateImage(new_coordinates[1], 1)

            })
        }
    );
}

/**
 * コーデ画像をアニメーションで置き換える
 * battle.ctp で利用する前提で作成しているので, 他の場所では使えない
 * 受け取ったコーデのデータは, そのまま次の then ブロックへ渡す
 * @param coordinate_data アニメーションで切り替える, 新たなコーデのデータ
 * @param side_id どちらの側のコーデをアニメーションさせるか(0: 左, 1: 右)
 * @returns {*}
 */
function dfdAnimateCoordinateImage(coordinate_data, side_id) {
    var dfd = $.Deferred();

    var firstAnimate = function() {
        var dfd = $.Deferred();

        push_enable = false;

        // フェードアウト用画像を表面に持ってくる
        $("#fadephoto" + side_id).css({
            "opacity":0.75,
            "z-index":1
        });
        $("#photo" + side_id).css({
            "z-index":0
        });

        // 裏にまわった画像を次の画像に置き換える
        $("#photo" + side_id).attr("src", "/img/" + coordinate_data["url"]);
        eval("coordinate_id" + Number(side_id) + " = coordinate_data[\"id\"];");

        var animate_option = { opacity: 0 };
        if (Number(side_id)) {
            animate_option.left = 200;
        } else {
            animate_option.right = 200;
        }
        $("#fadephoto" + side_id).velocity(
            animate_option,
            500,
            function () {
                dfd.resolve();
            }
        );

        return dfd.promise();
    };

    var secondAnimate = function() {
        var dfd = $.Deferred();

        $("#fadephoto" + side_id).css({
            "z-index":0
        });

        // fadephoto を表示済みの画像に置き換える
        $("#fadephoto" + side_id).attr("src", "/img/" + coordinate_data["url"]);
        $("#photo" + side_id).css({
            "z-index":1
        });

        var animate_option = {};
        if (Number(side_id)) {
            animate_option.left = 0;
        } else {
            animate_option.right = 0;
        }
        $("#fadephoto" + side_id).velocity(
            animate_option,
            0,
            function () {
                dfd.resolve();
            }
        );

        return dfd.promise();
    };

    $.Deferred().resolve().promise()
        .then(firstAnimate())
        .then(secondAnimate())
        .done(
        function() {
            push_enable = true;
            dfd.resolve(coordinate_data)
        }
    );

    return dfd.promise();
}

function showCoordinateDetail(coordinate_id) {
    var now = $( window ).scrollTop() ;

    $("body").wrapInner('<div id="wrapper"></div>');
    $("#wrapper").css({
        position: 'fixed',
        width: '100%',
        top: -1 * now
    });

    $("body").append('<div id="modal_overlay"></div>' +
        '<div id="modal_window"></div>');

    $("#modal_window").load(COORDINATE_VIEW_ROOT + "/" + coordinate_id + " #coordinateDetail", function() {
        $(document).ready(function() {
            $("#modal_window").css("margin-bottom", OFFSET_BOTTOM + "px");

            $(".image").fadeIn(700);
            $.getScript("../js/coordinates/view.js");
            $("#modal_window").prepend('<div id="window_header">' +
                '<div id="window_title">コーディネートの詳細</div><div id="close_button">×</div></div>');
            $("#modal_overlay").fadeIn("slow");
            $("#modal_window").fadeIn("slow");

            $("#modal_overlay").unbind().click(function() {
                $("#modal_overlay, #modal_window").fadeOut("slow", function() {
                    $("#modal_overlay, #modal_window").remove();
                })
            });

            $("#close_button").unbind().click(function() {
                $("#modal_overlay, #modal_window").fadeOut("slow", function() {
                    $("#modal_overlay, #modal_window").remove();
                    $("body > #wrapper").contents().unwrap();
                    $( 'html, body' ).prop({ scrollTop: now })
                })
            });
        });
    });
}
