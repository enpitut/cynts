<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('coordinates/create.css') ?>
    <script src='http://code.jquery.com/jquery-1.11.1.min.js'></script>
    <?= $this->Html->script('coordinate/create.js') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<table class="search_area">
    <?= $this->Form->create() ?>
    <tr>
        <td class="search_label">Sex</td>
        <td class="search_value">
            <?= $this->Form->input(
                'sex',
                [
                    'label' => '',
                    'options' => $sex_list,
                    'empty' => 'Choose one',
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">Category</td>
        <td class="search_value">
            <?= $this->Form->input(
                'category',
                [
                    'label' => '',
                    'options' => $category_list,
                    'empty' => 'Choose one',
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">Color</td>
        <td class="search_value">
            <?= $this->Form->input(
                'color',
                [
                    'label' => '',
                    'options' => $color_list,
                    'empty' => 'Choose one',
                ]
            ); ?>
        </td>
    </tr>
    <tr>
        <td class="search_label">Price</td>
        <td class="search_value">
            <?= $this->Form->input(
                'price',
                [
                    'label' => '',
                    'options' => [
                        '0,1000' => '¥0 - ¥1000',
                        '1001,3000' => '¥1001 - ¥3000',
                        '3001,5000' => '¥3001 - ¥5000',
                        '5001,10000' => '¥5001 - ¥10000',
                    ],
                    'empty' => 'Choose one',
                ]
            ); ?>
        </td>
    </tr>
    <tr class="search_button">
        <td colspan="2">
            <?= $this->Form->button('Search') ?>
            <?= $this->Form->end() ?>
        </td>
    </tr>
</table>

<hr>

<div class="item_list">
    <?php $loop = 0; ?>
    <?php foreach ($items as $item): ?>
        <?php if ($loop % 3 === 0) { ?>
            <div class="row">
        <?php } ?>

        <div class="span3">
            <div class="photo">
                <?= $this->Html->image(
                    $item->photo_paths[0],
                    [
                        'class' => 'item_image',
                        'width' => '280px',
                    ]
                )
                ?>
                <button
                    class="pick_button"
                    data-item-id="<?= $item->id ?>"
                    data-item-photo-path="<?= $item->photo_paths[0] ?>"
                    data-item-price="<?= $item->price ?>"
                    >
                    Pick
                </button>
            </div>
            <div class="info">
                <div class="name">
                    <?= $item->name ?>
                </div>
                <div class="price">
                    ¥<?= $item->price ?>
                </div>
            </div>
        </div>

        <?php if (++$loop % 3 === 0) { ?>
            </div>
            <div class="clear"></div>
        <?php } ?>
    <?php endforeach; ?>
    <?php if ($loop % 3 !== 0) { ?>
</div>
    <div class="clear"></div>
<?php } ?>

<?= $this->element('footer') ?>
</div>

<div class="picked_items_area">
    <div class="picked_items_message">Picked Items</div>
    <div class="picked_items"></div>
    <?= $this->Html->link(
        '>> Next step',
        [
            'controller' => 'Coordinates',
            'action' => 'post',
        ],
        [
            'class' => 'link_to_post',
        ]
    ) ?>
</div>

</body>
</html>
