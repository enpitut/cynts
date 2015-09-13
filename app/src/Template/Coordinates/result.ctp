<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('battle.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<?php
echo "your score:" . $score;
echo "<br>";
echo "max score:" . $max_n_battle * 100;
?>

<?= $this->element('footer') ?>

</body>
</html>