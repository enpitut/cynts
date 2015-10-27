<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('coorView.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".image").fadeIn(700);
        });
    </script>
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
            echo $this->Html->image(
                $coordinate->photo_path,
                [
                    'class' => 'image',
                    'width' => '313px',
                ]
            );
            ?>
        </div>
        <div class="coordinateButtons">
            <?php
            echo $this->Form->create();
            echo $this->Form->button('favorite', ['class' => 'favoriteButton']);
            if (
                isset($coordinate->user->id)
                && $this->request->session()->read('Auth.User.id') === $coordinate->user_id
            ) {
                echo "<div>";
                echo $this->Html->link(
                    __('削除'),
                    ['action' => 'delete', $coordinate->id],
                    ['class' => 'deleteButton', 'confirm' => '本当にコーディネートを削除してよろしいですか？']
                );
                echo "</div>";
            } ?>
        </div>
    </div>
    <?php foreach ($coordinate->items as $item): ?>
        <div class="itemColumn">
            <div class="itemPhoto">
                <?php
                if (!empty($item->photoPaths)) {
                    $photo_paths = $item->photoPaths;
                    echo $this->Html->image(
                        current($photo_paths),
                        [
                            'class' => 'image',
                            'width' => '125px',
                        ]
                    );
                }
                ?>
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
                    <?php echo "￥" . $item->price; ?>
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
    <hr style="position: relative; float: right;" width="470px"/>
    <div style="position: relative; float: right; margin: 10px 0; width: 470px;">
        <div id="buyAll"><br/>
            すべて購入<br/>

            <p id="coordinatePrice">
                <?php echo "￥" . $total_price; ?>
            </p>
        <span class="buyButton">
            <?php
            echo $this->Form->button('Buy', ['class' => 'buyButton']);
            ?>
        </span>
        </div>
    </div>
</div>
<?= $this->element('footer') ?>
</body>
</html>
