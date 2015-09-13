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
$photo_id = 0;
foreach ($coordinates as $coordinate) {
    // @see webroot/js/battle.js
    echo '<script>coordinate_id' . $photo_id . ' = ' . $coordinate->id . '</script>' . PHP_EOL;
    echo '<li>' . PHP_EOL;

    echo '<div class="phototags">';
    echo $this->Html->image(
        '/img/view/battle_' . $photo_id . '.png',
        [
            'id' => 'phototag' . $photo_id,
            'onClick' => sprintf(
                'updateCoordinateImage(image_obj%d, coordinate_id%d, coordinate_id%d, %d)',
                $photo_id, $photo_id, (($photo_id + 1) % 2), $max_n_battle
            ),
        ]);
    echo '</div>';

    echo '<div class="photo">' . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        [
            'onClick' => sprintf(
                'updateCoordinateImage(image_obj%d, coordinate_id%d, coordinate_id%d, %d)',
                $photo_id, $photo_id, (($photo_id + 1) % 2), $max_n_battle
            ),
            'id' => "photo" . $photo_id,
            'class' => "battlephoto",
        ]) . PHP_EOL;
    echo $this->Html->image($coordinate->photo_path,
        [
            'id' => "fadephoto" . $photo_id,
            'class' => "fadephoto",
        ]
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
