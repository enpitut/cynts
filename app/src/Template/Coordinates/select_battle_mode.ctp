<!DOCTYPE html>
<html>
<head>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<?php
use App\Model\Entity\Coordinate;
$coordinate = new Coordinate();
echo $this->Form->create($coordinate, ['action' => 'battle']);
echo $this->Form->select(
    'max_n_battle',
    [
        10 => 10,
        30 => 30,
        50 => 50
    ]
);
echo $this->Form->button('Play!!');
?>

<?= $this->element('footer') ?>

</body>
</html>
