<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('coordinates/create.css') ?>
    <?= $this->Html->css('coordinates/post.css') ?>
    <?= $this->Html->css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/ui-lightness/jquery-ui.css') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div style="width: 900px; margin: 30px auto; position: relative;">

    <div id="screen" style="background: #dddddd; height: 630px; width: 450px; position: relative; float: left;"></div>

    <table id="sizechanger" style="width: 430px; position: relative; float: right;">
        <tr>
            <td class='postTd'>アイテムの大きさを変更 (%)</td>
        </tr>
    </table>
    <hr class="postHr">

    <table class='postTable'>
        <tr>
            <td class='postTd'>対象性別</td>
            <td class='postTd'>
                <?= $this->Form->select(
                    'sex',
                    array_merge(['default' => '未選択'], $sex_list),
                    ["id" => "sex"]
                ) ?>
            </td>
        </tr>
        <tr>
            <td class='postTd'>対象季節</td>
            <td class='postTd'>
                <?php
                echo $this->Form->checkbox('spring', [
                        'hiddenField' => false,
                        'value' => 'spring',
                    ]) . '春<br>';
                echo $this->Form->checkbox('summer', [
                        'hiddenField' => false,
                        'value' => 'summer',
                    ]) . '夏<br>';
                echo $this->Form->checkbox('autumn', [
                        'hiddenField' => false,
                        'value' => 'autumn',
                    ]) . '秋<br>';
                echo $this->Form->checkbox('winter', [
                        'hiddenField' => false,
                        'value' => 'winter',
                    ]) . '冬<br>';
                ?>
            </td>
        </tr>
    </table>

    <button onclick="screenshot('#screen')" class='postButton'>投稿</button>

    <div style="clear: both;"></div>
    <br />
    <div style="position: relative; float: left;">
    <?= $this->html->link(
        '<< アイテムを選びなおす',
        [
            'controller' => 'coordinates',
            'action' => 'create',
        ],
        [
            'class' => 'link_to_post',
        ]
    ) ?>
    </div>
    <script>
        var zIndex = 0;

        function moveFront(id) {
            zIndex += 1;
            $(id).css("z-index", zIndex);
        }

        function addCanvas(img, name) {
            var width = img.width;
            var height = img.height;
            var screen = document.getElementById('screen');
            var id = 'canvas' + (screen.getElementsByTagName('canvas').length + 1).toString();
            zIndex += 1;

            $('#screen').append(
                $('<canvas></canvas>')
                    .attr('id', id)
                    .attr('width', width)
                    .attr('height', height)
                    .attr('onClick', 'moveFront(\'#' + id + '\')')
                    .attr('style', 'position: absolute; top: 0; left: 0; z-index: ' + zIndex + ';')
            );
            $('#sizechanger').append(
                $('<tr></tr>').append(
                    $('<td>' + name + '</td>')
                ).append(
                    $('<td></td>').append(
                        $('<input>').attr('id', id + "size").attr('value', '100').attr('style', 'width: 40px;')
                    )
                )
            );
            $('#' + id + 'size').spinner();
            $('#' + id + 'size').on("spin", function (event, ui) {
                var canvas = $('#' + id);
                var context = canvas[0].getContext('2d');
                var img_ = img;
                context.clearRect(0, 0, canvas.width(), canvas.height());
                context.save();
                var val = $('#' + id + 'size').val() / 100;
                canvas.attr('width', img_.width * val);
                canvas.attr('height', img_.height * val);
                context.setTransform(val, 0, 0, val, 0, 0);
                context.drawImage(img_, 0, 0);
            });

            var canvas = document.getElementById(id);
            if (!canvas || !canvas.getContext) {
                return null;
            }

            return canvas;
        }

        function initContext(canvas, context) {
            $(canvas).draggable({containment: '#screen', scroll: false});
        }

        function addRect(filepath, name) {
            var img = new Image();
            img.src = filepath;
            img.onload = function () {
                var canvas = addCanvas(img, name);
                if (!canvas) return false;

                var context = canvas.getContext('2d');
                context.drawImage(img, 0, 0);

                initContext(canvas, context);
            }
        }

        function sendPost(action, send_data, args) {
            return $.ajax({
                type: "POST",
                url: action,
                data: send_data,
                context: args
            })
        }

        function getSeasonJson() {
            return ($("[name=spring]").prop("checked") ? "1" : "0") +
                ($("[name=summer]").prop("checked") ? "1" : "0") +
                ($("[name=autumn]").prop("checked") ? "1" : "0") +
                ($("[name=winter]").prop("checked") ? "1" : "0");
        }

        function screenshot(selector) {

            // 季節，性別が選択されていなければ投稿させない
            if(
                getSeasonJson() === "0000" ||
                document.getElementById('sex').value === "default"
            ) {
                alert("あなたのコーディネートがどのような時期や人物に適しているか教えていただけますか？\n性別，季節の情報を入力してください\n");
                return;
            }

            var dfd = $.Deferred();

            var element = $(selector)[0];
            html2canvas(element, {
                onrendered: function (canvas) {
                    var imgData = canvas.toDataURL();
                    sendPost("ajaxPostCoordinate",
                        {
                            img: imgData,
                            items: JSON.stringify(items),
                            sex: document.getElementById('sex').value,
                            season: getSeasonJson()
                        },
                        null
                    ).done(function (result) {
                            var result_data = JSON.parse(result);
                            if (!result_data["hasSucceeded"]) {
                                throw new Error("Illegal post value");
                            }
                            localStorage.clear();
                            window.location.href = "./view/" + result_data["id"];
                        });
                }
            });

            return dfd.promise();
        }

        var items = JSON.parse(localStorage.getItem('items'));
        Object.keys(items).forEach(function (key) {
            addRect("../img/" + items[key]["photoPath"], items[key]["name"]);
        });
    </script>

<?= $this->element('footer') ?>
</body>
</html>
