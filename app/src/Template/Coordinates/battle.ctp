<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.1.0/velocity.js"></script>
<script>
    var coordinate_id0;
    var coordinate_id1;
    var push_enable = true;

    /**
     * 押下されたコーデを加点後，次に表示するコーデを取得し，表示を切り替える
     */
    function img_update(obj, coordinate_id, dislike_id) {
        if (!push_enable){ return; }
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
</script>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="centermessage">
  <p>Which do you like?</p>
</div>

<div id="battlecolumn">
<ul>
<?php
$photo_id = 0;
foreach ($coordinates as $coordinate) {
    echo '<script>coordinate_id' . $photo_id . ' = ' . $coordinate->id . '</script>' . PHP_EOL;
    echo '<li>' . PHP_EOL;

    echo '<div class="phototags">';
    if ($photo_id == 0) {
        echo $this->Html->image(
            '/img/view/battle_A.png',
            array(
                'id' => 'phototag' . $photo_id,
                'onClick' => 'img_update(image_obj0, coordinate_id0, coordinate_id1)',
            ));
    } else {
        echo $this->Html->image(
            '/img/view/battle_B.png',
            array(
                'id' => 'phototag' . $photo_id,
                'onClick' => 'img_update(image_obj1, coordinate_id1, coordinate_id0)',
            ));
    }
    echo '</div>';

    echo '<div class="photo">' . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        array(
            'onClick' => 'img_update(this, coordinate_id' . $photo_id . ', coordinate_id' . (($photo_id + 1) % 2) . ')',
            'id' => "photo" . $photo_id,
            'class' => "battlephoto",
        )) . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        array(
            'id' => "fadephoto" . $photo_id,
            'class' => "fadephoto",
        )
    );
    echo '</div>';

    echo '</li>' . PHP_EOL;

    $photo_id++;
}
echo '<script>var image_obj0 = document.getElementById("photo0");</script>';
echo '<script>var image_obj1 = document.getElementById("photo1");</script>';
$photo_id = 0;
?>
</ul>
</div>

<?= $this->element('footer') ?>

</body>
</html>
