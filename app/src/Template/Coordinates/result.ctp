<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<?php
echo "you score:" . $score;
echo "<br>";
echo "max score:" . $max_n_battle * 100;
echo "<br>";
//var_dump($battle_history);
?>

<?= $this->element('footer') ?>

</body>
</html>