<!DOCTYPE html>
<html>
<head>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="centermessage">
    <p>How many times do you play?</p>
</div>

<div class="select_box">
<?php
use App\Model\Entity\Coordinate;
$coordinate = new Coordinate();
echo $this->Form->create($coordinate, ['action' => 'battle']);
echo $this->Form->select(
    'max_n_battle',
    [
        10 => 10,
        30 => 30,
        50 => 50,
    ]
);
echo "<br>";
echo $this->Form->button('Play!!', ['class' => 'play_btn']);
?>
</div>

<?= $this->element('footer') ?>

</body>
</html>
