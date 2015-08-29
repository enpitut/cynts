<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
    var coordinate_id0;
    var coordinate_id1;

    /**
     * 押下されたコーデを加点後，次に表示するコーデを取得し，表示を切り替える
     */
    function img_update(obj, coordinate_id, dislike_id) {
        var data = {id: coordinate_id, d_id: dislike_id};
        $.ajax({
            type: "POST",
            url: "send",
            data: data,
            success: function (data, dataType) {
                data = (new Function("return " + data))();
                if (obj.id[5] == "0") {
                    $("#" + "photo1").attr("src", data["url"]);
                    coordinate_id1 = data["id"];
                } else {
                    $("#" + "photo0").attr("src", data["url"]);
                    coordinate_id0 = data["id"];
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                alert('Error : ' + errorThrown);
            }
        });
    }
</script>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->Html->image('/img/view/header.png'); ?>
<?= $this->element('header') ?>

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
        echo $this->Html->image('/img/view/battle_A.png', array('id' => 'phototag' . $photo_id));
    } else {
        echo $this->Html->image('/img/view/battle_B.png', array('id' => 'phototag' . $photo_id));
    }

    echo '</div>';
    echo '<div class="battlephotos">' . PHP_EOL;
    echo $this->Html->image($coordinate->photos,
        array(
            'onClick' => 'img_update(this, coordinate_id' . $photo_id . ', coordinate_id' . (($photo_id + 1) % 2) . ')',
            'id' => "photo" . $photo_id++,
        )) . PHP_EOL;
    echo '</div>';

    echo '</li>' . PHP_EOL;
}
$photo_id = 0;
?>
</ul>
</div>

<?= $this->element('footer') ?>

</body>
</html>
