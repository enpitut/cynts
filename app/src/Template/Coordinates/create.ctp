<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <script src='http://code.jquery.com/jquery-1.11.1.min.js'></script>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<?= $this->Form->create() ?>
<?= $this->Form->input(
    'sex',
    [
        'options' => $sex_list,
        'empty' => '(Choose one)',
    ]
); ?>
<?= $this->Form->input(
    'category',
    [
        'options' => $category_list,
        'empty' => '(Choose one)',
    ]
); ?>
<?= $this->Form->input(
    'color',
    [
        'options' => $color_list,
        'empty' => '(Choose one)',
    ]
); ?>
<?= $this->Form->button('Search') ?>
<?= $this->Form->end() ?>

<?php foreach ($items as $item): ?>
    <?= $item->name ?>
    <?= $this->Html->image(
        $item->photo_paths[0],
        [
            'width' => '200px'
        ]
    )
    ?>
<?php endforeach; ?>

<?= $this->element('footer') ?>

</body>
</html>
