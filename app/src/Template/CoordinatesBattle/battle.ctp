<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.1.0/velocity.js"></script>
<?= $this->Html->script('battle.js') ?>
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
$side_id = 0;
foreach ($coordinates as $coordinate) {
    // @see webroot/js/battle.js
    echo sprintf('<script>coordinate_id%d = %d</script>', $side_id, $coordinate->id);
    echo '<li>' . PHP_EOL;

    echo '<div class="phototags">';
    echo $this->Html->image(
        '/img/view/battle_' . $side_id . '.png',
        [
            'id' => 'phototag' . $side_id,
            'onClick' => sprintf(
                'updateCoordinateImage(image_obj%d, coordinate_id%d, coordinate_id%d)',
                $side_id, $side_id, (($side_id + 1) % 2)
            ),
        ]);
    echo '</div>';

    echo '<div class="photo">' . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        [
            'onClick' => sprintf(
                'updateCoordinateImage(image_obj%d, coordinate_id%d, coordinate_id%d)',
                $side_id, $side_id, (($side_id + 1) % 2)
            ),
            'id' => "photo" . $side_id,
            'class' => "battlephoto",
        ]) . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        [
            'id' => "fadephoto" . $side_id,
            'class' => "fadephoto",
        ]
    );
    echo '</div>';

    echo '</li>' . PHP_EOL;

    $side_id++;
}
echo '<script>var image_obj0 = document.getElementById("photo0");</script>';
echo '<script>var image_obj1 = document.getElementById("photo1");</script>';
$side_id = 0;
?>
</ul>
</div>
<br>
<div id="finish_button"></div>

<?= $this->element('footer') ?>

</body>
</html>
