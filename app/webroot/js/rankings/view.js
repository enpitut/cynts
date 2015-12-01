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
            renderRanking(JSON.parse(result));
        }
    );
}

function renderRanking(coordinates) {
    for (var i = 0, len = coordinates["RANKING_SHOW_LIMIT"]; i < len; i++) {
        if (coordinates[String(i)] === undefined) {
            var element_div_span3 = document.getElementsByClassName("span3")[i];
            var element_child;
            while (element_child = element_div_span3.lastChild) {
                element_div_span3.removeChild(element_child);
            }
            continue;
        }

        var element_photo_a;
        var element_photo_img;
        var user_div_tag;
        var element_span_point;
        var element_span_price;
        if (document.getElementsByClassName("user")[i] === undefined) {
            // span3 以下が削除されていれば全てのタグを生成する
            // 読みづらくてすいません...

            //------------------ div photo ---------------------//
            var element_div_rank = document.createElement('div');
            element_div_rank.className = "rank";
            element_div_rank.appendChild(elementRank(i+1));


            var element_div_photo = document.createElement('div');
            element_photo_img = document.createElement('img');
            element_photo_a = document.createElement('a');

            element_div_photo.className = "photo";
            element_photo_img.className = "coordinate_image";
            element_photo_img.id = "photo_" + String(i+1);
            element_photo_img.style = "display: inline;";
            element_photo_a.id = "link_" + String(i+1);

            element_photo_a.appendChild(element_photo_img);
            element_div_photo.appendChild(element_photo_a);
            //-------------- end of div photo ----------------//


            //------------------- div information ---------------------//
            var element_div_information = document.createElement('div');
            element_div_information.className = "information";

            ///------------------ div information left -----------------///
            var element_div_information_left = document.createElement('div');
            var element_div_point = document.createElement('div');
            var element_div_price = document.createElement('div');
            element_span_point = document.createElement('span');
            element_span_price = document.createElement('span');

            element_div_information_left.className = "information_left";
            element_div_point.className = "point";
            element_div_price.className = "total_price";
            element_span_point.className = "point_number";
            element_span_point.id = "point_"+String(i+1);
            element_span_price.className = "price_number";
            element_span_price.id = "price_"+String(i+1);

            element_div_point.appendChild(element_span_point);
            element_div_point.appendChild(document.createTextNode(" Points"));
            element_div_price.appendChild(document.createTextNode("¥"));
            element_div_price.appendChild(element_span_price);
            element_div_information_left.appendChild(element_div_point);
            element_div_information_left.appendChild(element_div_price);
            ///-------------- end of div information left ---------------///

            ///------------------ div information right -----------------///
            var element_div_information_right = document.createElement('div');
            user_div_tag = document.createElement('div');

            element_div_information_right.className = "information_right";
            user_div_tag.className = "user";
            element_div_information_right.appendChild(user_div_tag);
            ///-------------- end of div information right ---------------///

            element_div_information.appendChild(element_div_information_left);
            element_div_information.appendChild(element_div_information_right);
            //------------------- end of div information ------------------//


            // Add rank, photo, and information div tags to span3 div tag
            var div_span3 = document.getElementsByClassName("span3")[i];
            div_span3.appendChild(element_div_rank);
            div_span3.appendChild(element_div_photo);
            div_span3.appendChild(element_div_information);
        } else {
            // span3 以下が削除されていなければ，上書きする要素を引っ張ってくる
            element_photo_img = document.getElementById("photo_"+String(i+1));
            element_photo_a = document.getElementById("link_"+String(i+1));
            element_span_point = document.getElementById("point_"+String(i+1));
            element_span_price = document.getElementById("price_"+String(i+1));

            // ユーザ情報は，コーデ制作者が存在しない場合には表示しないので，一旦全部消す
            user_div_tag = document.getElementsByClassName("user")[i];
            var child;
            while (child = user_div_tag.lastChild) {
                user_div_tag.removeChild(child);
            }
            user_div_tag.innerHTML = "";
        }

        // 要素を書き込み/上書き
        element_photo_img.src = '../img/' + coordinates[i]["photo_path"];
        element_photo_a.href = '../coordinates/view/' + coordinates[i]["id"];
        element_span_point.innerHTML = parseInt(coordinates[i]["n_like"]) * 1000;
        element_span_price.innerHTML = coordinates[i]["total_price"];

        // コーデの制作者が存在すれば中身を生成
        if (coordinates[i]["user_id"] !== "" && coordinates[i]["user_name"] !== "") {
            var element_span = document.createElement('span');
            var element_a = document.createElement('a');

            element_span.className = "user_name";
            element_a.id = "user_name_" + String(i+1);
            element_a.href = '../users/view/' + coordinates[i]["user_id"];
            element_a.innerHTML = coordinates[i]["user_name"];

            element_span.appendChild(element_a);
            user_div_tag.innerHTML = '制作者 :';
            user_div_tag.appendChild(element_span);
        }
    }
}

function elementRank(rank) {
    var span_rank = document.createElement('span');
    var class_rank = "rank";
    switch (rank) {
        case 1:
            span_rank.className = class_rank + "rank_1st";
            span_rank.innerHTML = "1st";
            break;
        case 2:
            span_rank.className = class_rank + "rank_2nd";
            span_rank.innerHTML = "2nd";
            break;
        case 3:
            span_rank.className = class_rank + "rank_3rd";
            span_rank.innerHTML = "3rd";
            break;
        default:
            span_rank.className = class_rank;
            span_rank.innerHTML = String(rank) + "th";
            break;
    }
    return span_rank;
}
