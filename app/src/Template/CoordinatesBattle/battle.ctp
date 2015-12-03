<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.1.0/velocity.js"></script>
<?= $this->Html->script('jquery.session.js') ?>
<?= $this->Html->script('battle.js') ?>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('coordinates_battle/battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<table class="search_area">
    <?= $this->Form->create(null, ['name' => 'criteria_form']) ?>
    <tr>
        <td class="search_label">性別</td>
        <td class="search_value" id="sex">
            <?= $this->Form->input(
                'sex',
                [
                    'label' => '',
                    'options' => $sex_list,
                    'empty' => '指定なし',
                    'class' => 'criteria_value',
                    'onChange' => 'setBattleFilter();'
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">価格帯</td>
        <td class="search_value" id="price">
            <?= $this->Form->input(
                'price',
                [
                    'label' => '',
                    'options' => [
                        '0,1000' => '¥0 - ¥1000',
                        '1001,3000' => '¥1001 - ¥3000',
                        '3001,5000' => '¥3001 - ¥5000',
                        '5001,10000' => '¥5001 - ¥10000',
                        '10001,15000' => '¥10001 - ¥15000',
                        '15001,20000' => '¥15001 - ¥20000',
                    ],
                    'empty' => '指定なし',
                    'class' => 'criteria_value',
                    'onChange' => 'setBattleFilter();'
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">季節</td>
        <td>
            <?php
            echo "春" . $this->Form->checkbox(
                    'spring', [
                    'hiddenField' => false,
                    'value' => 'spring',
                    'onChange' => 'setBattleFilter();'
                ]);
            echo "夏" . $this->Form->checkbox(
                    'summer', [
                    'hiddenField' => false,
                    'value' => 'summer',
                    'onChange' => 'setBattleFilter();'
                ]);
            echo "秋" . $this->Form->checkbox(
                    'autumn', [
                    'hiddenField' => false,
                    'value' => 'autumn',
                    'onChange' => 'setBattleFilter();'
                ]);
            echo "冬" . $this->Form->checkbox(
                    'winter', [
                    'hiddenField' => false,
                    'value' => 'winter',
                    'onChange' => 'setBattleFilter();'
                ]);
            ?>
        </td>
    </tr>
</table>

<div id="centermessage">
  <p>どっちが好き？</p>
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
