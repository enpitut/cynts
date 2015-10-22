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
        <div id="author">
            製作者：
            <?=
            $this->Html->link(
                $coordinate->user->name,
                [
                    'controller' => 'Users',
                    'action' => 'view',
                    $coordinate->user->id
                ]
            );
            ?>
        </div>
        <div id="favorite">
            <?php
            echo $this->Form->create();
            echo $this->Form->button('お気に入り', ['class' => 'favoriteButton']);
            ?>
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

                <div class="sizeButtons"
                     style="height: <?php echo 34 * (int)(count(
                                 $item->sizeArray
                             ) / 4 + 1) ?>px">
                    <?php

                    $options = array();
                    for ($i = 0; $i < count($item->sizeArray); $i++) {
                        if($i === 0) array_push($options, ['value' => $item->sizeArray[$i], 'text' => $item->sizeArray[$i], 'checked' => true]);
                        else array_push($options, ['value' => $item->sizeArray[$i], 'text' => $item->sizeArray[$i]]);
                    }
                    $sizeLabel = 'size' . $item->id;
                    echo $this->Form->create();
                    echo $this->Form->radio($sizeLabel, $options);
                    echo $this->Form->end();
                    ?>
                </div>
                <div class="itemPrice">
                    <?php echo "￥" . $item->price; ?>
                </div>

                <?php
                    echo $this->Form->create();
                echo $this->Form->button('買う', ['class' => 'buyButton']);
                echo $this->Form->end();
                ?>
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
            <?php
            echo $this->Form->create();
            echo $this->Form->button('買う', ['class' => 'buyButton']);
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
<?= $this->Html->script('coordinate/view.js') ?>
<?= $this->element('footer') ?>
</body>
</html>
