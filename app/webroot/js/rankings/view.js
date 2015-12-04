function didChangeCoordinatesCriteria() {
    updateCriteriaJson();
    updateRanking();
}

function updateRanking() {
    sendPost("ajaxUpdateRanking",
        {
            // criteria_json は，Rankings/view.ctp で criteria_table.ctp が読み込まれることを前提として利用する
            coordinate_criteria: JSON.stringify(criteria_json)
        },
        null
    ).done(
        function (result) {
            var dfd = $.Deferred().resolve().promise();

            dfd.then(function() {
                return readHtml("/html/rankings/ranking_template.html")
            }).then(function (html) {
                return readHtml("/html/rankings/coordinates_user_template.html", html)
            }).done(function(response_list) {
                renderRanking(JSON.parse(result), response_list);
            });
        }
    );
}

function renderRanking(coordinates, response_list) {
    var template = response_list[0];
    var element_div_user_template = response_list[1];

    var render_result = "";

    // 一度ランキングを消去
    var element_div_rankings = document.getElementById("rankings");
    var child;
    while (child = element_div_rankings.lastChild) {
        element_div_rankings.removeChild(child);
    }

    for (var i = 0, len = coordinates["RANKING_SHOW_LIMIT"]; i < len; i++) {
        var index = String(i)
        if (coordinates[index] === undefined) {
            if (i % 3 !== 0) {
                render_result += "</div>";
                render_result += '<div class="clear"></div>';
            }
            continue;
        }

        if (i % 3 === 0) {
            render_result += "<div class='row'>";
        }

        var element_div_rank = elementRank(i+1);
        var element_div_span3 = template;
        element_div_span3 = element_div_span3.replace(
            /RANKING_CLASS_EXTEND/g ,
            element_div_rank[0]
        );
        element_div_span3 = element_div_span3.replace(
            /RANK/g ,
            element_div_rank[1]
        );
        element_div_span3 = element_div_span3.replace(
            /COORDINATES_VIEW_PATH/g ,
            '../coordinates/view/' + coordinates[index]["id"]
        );
        element_div_span3 = element_div_span3.replace(
            /COORDINATES_PHOTO_PATH/g ,
            '../img/' + coordinates[index]["photo_path"]
        );
        element_div_span3 = element_div_span3.replace(
            /COORDINATES_SCORE/g ,
            parseInt(coordinates[index]["n_like"]) * 1000
        );
        element_div_span3 = element_div_span3.replace(
            /COORDINATES_PRICE/g ,
            coordinates[index]["total_price"]
        );

        // コーデの制作者が存在すれば中身を生成
        if (coordinates[index]["user_id"] !== "" && coordinates[index]["user_name"] !== "") {
            var element_div_user = element_div_user_template;
            element_div_user = element_div_user.replace(
                /COORDINATES_USER_VIEW_PATH/g ,
                '../users/vew/' + coordinates[index]["user_id"]
            );
            element_div_user = element_div_user.replace(
                /COORDINATES_USER_NAME/g ,
                coordinates[index]["user_name"]
            );
            element_div_span3 = element_div_span3.replace(
                /COORDINATES_USER_INFORMATION/g,
                element_div_user
            )
        } else {
            element_div_span3 = element_div_span3.replace(
                /COORDINATES_USER_INFORMATION/g ,
                ""
            );
        }

        render_result += element_div_span3;

        if (i % 3 === 2) {
            render_result += "</div>";
            render_result += '<div class="clear"></div>';
        }
    }

    element_div_rankings.innerHTML = render_result;
}

function elementRank(rank) {
    var class_rank = "rank";
    var view_rank = "";
    switch (rank) {
        case 1:
            class_rank += " rank_1st";
            view_rank = "1st";
            break;
        case 2:
            class_rank += " rank_2nd";
            view_rank = "2nd";
            break;
        case 3:
            class_rank += " rank_3rd";
            view_rank = "3rd";
            break;
        default:
            view_rank = String(rank) + "th";
            break;
    }
    return [class_rank, view_rank];
}
