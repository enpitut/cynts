const FADE_DURATION = 300;

/**
 * 条件の絞り込みがユーザによって操作された際に呼び出される
 */
function didChangeCoordinatesCriteria() {
    updateCriteriaJson();
    updateRanking();
}

/**
 * 条件の絞り込みに応じて Controller と通信を行い，
 * ランキング表示を更新する
 */
function updateRanking() {
    sendPost("/rankings/ajaxUpdateRanking",
        {
            // criteria_json は，Rankings/view.ctp で criteria_table.ctp が読み込まれることを前提として利用する
            coordinate_criteria: JSON.stringify(criteria_json),
            type: ranking_type
        },
        null
    ).done(
        function (ranking) {
            var json_result = JSON.parse(ranking);

            if (json_result["hasSucceeded"] === false) {
                throw new Error(json_result["errorMessage"]);
            }

            var dfd = $.Deferred().resolve().promise();

            /*
             GET メソッドで html のテンプレートを順に読み込み，
             renderRanking の引数に渡す
              */
            dfd.then(function() {
                return fetchHtml("/html/rankings/ranking_template.html")
            }).then(function (base_template) {
                return fetchHtml("/html/rankings/coordinates_user_template.html", base_template)
            }).then(function(templates) {
                renderRanking(json_result, templates);
            });
        }
    );
}

/**
 * コーデ情報と html テンプレートから，
 * アニメーションを利用してランキングを描画する
 *
 * @param coordinates
 * @param templates
 */
function renderRanking(coordinates, templates) {
    var dfd = $.Deferred().resolve().promise();

    // アニメーション効果を付加するために，ここでも jQuery Deferred を利用する
    dfd.then(function() {

        return dfdRemoveRankingElements();

    }).then(function() {

        return dfdCreateRankingHtmlByTemplate(coordinates, templates);

    }).done(function(html) {

        $("#rankings")
            .css({
                'visibility':'hidden',
                'opacity':0
            })
            .append(html)
            .css({'visibility':'visible'})
            .animate({opacity: 1}, FADE_DURATION);

    });
}

/**
 * 現在描画されているランキングをフェードアウトさせ，消去する
 *
 * @returns {*}
 */
function dfdRemoveRankingElements() {
    var dfd = $.Deferred();

    $("#rankings")
        .animate( {opacity: 0},
        {
            duration: FADE_DURATION,
            complete: function () {
                $("#rankings").empty();
                dfd.resolve();
            }
        });

    return dfd.promise();
}

/**
 * コーデ情報と html テンプレートから，
 * 絞り込み結果を反映したランキングの html を生成する
 *
 * @param coordinates 絞り込み結果を反映したコーデの情報群
 * @param templates html テンプレート．ranking と user information の2つのテンプレートを含む
 * @returns {*}
 */
function dfdCreateRankingHtmlByTemplate(coordinates, templates) {
    var dfd = $.Deferred();
    var html = "";
    var base_template = templates[0];
    var user_information_template = templates[1];

    for (var i = 0, len = coordinates["RANKING_SHOW_LIMIT"]; i < len; i++) {
        var index = String(i);

        // コーデが1つも存在しない場合のエラーメッセージ
        if (i === 0 && coordinates[index] === undefined) {
            return"</br><span>条件に該当するコーディネートが存在しません</span>";
        }

        // 該当するランクのコーデが存在しない場合には何もしない
        if (coordinates[index] === undefined) {
            if (i % 3 !== 0) {
                html += "</div>";
                html += '<div class="clear"></div>';
            }
            continue;
        }

        if (i % 3 === 0) {
            html += "<div class='row'>";
        }

        var div_rank = getWordAndClassByRank(i+1);
        var div_span3 = base_template;
        div_span3 = div_span3.replace(
            /#\{ranking_class_extend}/g ,
            div_rank[0]
        );
        div_span3 = div_span3.replace(
            /#\{rank}/g ,
            div_rank[1]
        );
        div_span3 = div_span3.replace(
            /#\{coordinates_view_path}/g ,
            '/coordinates/view/' + coordinates[index]["id"]
        );
        div_span3 = div_span3.replace(
            /#\{coordinates_photo_path}/g ,
            '/img/' + coordinates[index]["photo_path"]
        );
        // url に unlike が付加されていた場合には，表示ポイントを n_unlike に変更する
        if (coordinates["type"] === "like") {
            div_span3 = div_span3.replace(
                /#\{coordinates_score}/g ,
                parseInt(coordinates[index]["n_like"])
            );
        } else {
            div_span3 = div_span3.replace(
                /#\{coordinates_score}/g ,
                parseInt(coordinates[index]["n_unlike"])
            );
        }
        div_span3 = div_span3.replace(
            /#\{coordinates_price}/g ,
            coordinates[index]["total_price"]
        );

        // コーデの制作者が存在すれば中身を生成
        if (
            coordinates[index]["user_id"] !== ""
            && coordinates[index]["user_name"] !== ""
        ) {
            var div_user = user_information_template;
            div_user = div_user.replace(
                /#\{coordinates_user_view_path}/g ,
                '/users/view/' + coordinates[index]["user_id"]
            );
            div_user = div_user.replace(
                /#\{coordinates_user_name}/g ,
                coordinates[index]["user_name"]
            );
            div_span3 = div_span3.replace(
                /#\{coordinates_user_information}/g,
                div_user
            )
        } else {
            div_span3 = div_span3.replace(
                /#\{coordinates_user_information}/g ,
                ""
            );
        }

        html += div_span3;

        if (i % 3 === 2) {
            html += "</div>";
            html += '<div class="clear"></div>';
        }
    }

    dfd.resolve(html);

    return dfd.promise();
}

/**
 * ランクに応じて，ページに表示する文言と class を取得する
 *
 * @param rank
 * @returns {*[]}
 */
function getWordAndClassByRank(rank) {
    var rank_class = "rank";
    var rank_word = "";
    switch (rank) {
        case 1:
            rank_class += " rank_1st";
            rank_word = "1st";
            break;
        case 2:
            rank_class += " rank_2nd";
            rank_word = "2nd";
            break;
        case 3:
            rank_class += " rank_3rd";
            rank_word = "3rd";
            break;
        default:
            rank_word = String(rank) + "th";
            break;
    }
    return [rank_class, rank_word];
}
