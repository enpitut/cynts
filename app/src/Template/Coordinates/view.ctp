<!DOCTYPE html>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.1.0/velocity.js"></script>
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<?= $this->Html->css('base.css') ?>
<?= $this->Html->css('coorView.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="centermessage">
  <p>コーディネートの詳細</p>
</div>

<div id="coorDetail">
    <div id="coorcolumn">
        <div id="coorPhoto">
            <?php
                echo $this->Html->image($coordinate->photo_path, array('width' => '500px'));
            ?>
        </div>
        <div id="favBtn">
            <?php 
                echo $this->Form->button('favorite', ['class' => 'favBtn']);
            ?>
        </div>
    </div>
    <?php foreach ($coordinate->items as $items): ?>
    <div id="itemcolumn">
        <div id="photos">
            <?php echo $this->Html->image($items->photos, array('width' => '200px')); ?>
        </div>
        <div id="itemDetail">
            <p id="itemName">
                <?php echo $items->name; ?>
            </p>
            <p id="itemSize">
                size
            </p>
            <div id="sizeBtns">
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
            <p id="itemPrice">
                    <?php echo "￥".$items->price; ?>
            </p>
            <p id="buyBtn">
                    <?php 
                        echo $this->Form->button('Buy', ['class' => 'btn']);
                    ?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>
    <div id="buyAll">
                 すべて購入
        <p id="coorPrice">
            <?php echo "￥".$total_price; ?>
        </p>
        <p id="buyBtn">
            <?php
                echo $this->Form->button('Buy', ['class' => 'btn']);
            ?>
        </p>
    </div>
</div>
</body>
</html>