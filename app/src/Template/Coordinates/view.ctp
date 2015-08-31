<!DOCTYPE html>
<html>
<head>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('coorView.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="centerMessage">
  <p>コーディネートの詳細</p>
</div>

<div id="coordinateDetail">
    <div id="coordinateColumn">
        <div id="coordinatePhoto">
            <?php
                echo $this->Html->image($coordinate->photo_path, array('width' => '313px'));
            ?>
        </div>
        <div id="favorite">
            <?php
                echo $this->Form->create();
                echo $this->Form->button('favorite', ['class' => 'favoriteButton']);
            ?>
        </div>
    </div>
    <?php foreach ($coordinate->items as $item): ?>
    <div class="itemColumn">
        <div class="itemPhoto">
            <?php if (!empty($item->photoPaths)) { ?>
                <?php echo $this->Html->image(array_shift($item->photoPaths), array('width' => '125px')); ?>
            <?php } ?>
        </div>
        <div class="itemDetail">
            <p class="itemName">
                <?php echo $item->name; ?>
            </p>
            <p class="itemSize">
                size
            </p>
            <div class="sizeButtons">
                <?php
                    echo $this->Form->radio(
                        'size',
                        [
                            ['value' => 'XS', 'text' => 'XS'],
                            ['value' => 'S', 'text' => 'S'],
                            ['value' => 'M', 'text' => 'M'],
                            ['value' => 'L', 'text' => 'L'],
                            ['value' => 'XL', 'text' => 'XL'],
                            ['value' => 'XXL', 'text' => 'XXL'],
                            ['value' => '3XL', 'text' => '3XL'],
                            ['value' => '4XL', 'text' => '4XL'],
                        ]
                    );
                ?>
            </div>
            <p class="itemPrice">
                    <?php echo "￥".$item->price; ?>
            </p>
            <p class="buyButton">
                    <?php
                        echo $this->Form->create();
                        echo $this->Form->button('Buy', ['class' => 'buyButton']);
                    ?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>
    <div id="buyAll">
                 すべて購入
        <p id="coordinatePrice">
            <?php echo "￥".$total_price; ?>
        </p>
        <p class="buyButton">
            <?php
                echo $this->Form->button('Buy', ['class' => 'buyButton']);
            ?>
        </p>
    </div>
</div>

<?= $this->element('footer') ?>
</body>
</html>
