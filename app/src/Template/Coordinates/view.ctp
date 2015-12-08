<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('coordinates/view.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".image").fadeIn(700);
        });
    </script>
</head>
<body>

<?= $this->element('eachpage_header') ?>
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
        <div id="author">

            <?php
            if (isset($coordinate->user)) {
                echo '制作者：' . $this->Html->link(
                    $coordinate->user->name,
                    [
                        'controller' => 'Users',
                        'action' => 'view',
                        $coordinate->user->id
                    ]
                );
            }
            ?>
        </div>
        <div class="coordinateButtons">
            <?php
            echo $this->Form->create();
            echo $this->Form->button('お気に入り',[
                'class' => 'favoriteButton',
                'onclick' => 'addFavorite('.$coordinate->id.')',
                'disabled' => $coordinate->favorite_disabled,
                'type' => 'button'
            ]);
            echo $this->Form->end();
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
                if (!empty($item->photo_paths)) {
                    $photo_paths = $item->photo_paths;
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
                    サイズ
                </p>

                <div class="sizeButtons"
                     style="height: <?php echo $item->buttons_height ?>px">
                    <?php
                    echo $this->Form->create();
                    echo $this->Form->radio($item->size_label, $item->options);
                    echo $this->Form->end();
                    ?>
                </div>
                <div class="priceBox">
                    <span class="itemPrice">
                        <?php echo "￥" . $item->price; ?>
                    </span>
                    <span>
                        <?php
                        if (isset($item->purchase_url)) {
                            echo "<a target='_blank' class='buyButton' href='$item->purchase_url'>商品ページ</a>";
                        } else {
                            echo "<a class='buyButton disabled'>商品ページ</a>";
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <hr style="position: relative; float: right;" width="470px"/>
    <div style="position: relative; float: right; margin: 10px 0 0 0; width: 470px;">
        <div id="buyAll"><br/>
            <?php echo "合計金額 : ￥" . $total_price; ?>
        </div>
    </div>
</div>
<?= $this->Html->script('coordinates/view.js') ?>
<?= $this->element('footer') ?>
</body>
</html>
