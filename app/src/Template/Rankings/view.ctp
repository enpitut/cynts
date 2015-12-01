<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->script('rankings/view.js') ?>
    <?= $this->Html->script('common.js') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('ranking/base.css') ?>
    <?= $this->Html->css('criteria/table.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".coordinate_image").fadeIn(700);
        });
    </script>
</head>
<body>

<?= $this->element('eachpage_header') ?>
<?= $this->element('criteria_table') ?>

<?php $loop = 0; ?>
<?php foreach ($ranking as $coordinate): ?>
    <?php $rank = $loop + 1; ?>

    <?php if ($loop % 3 === 0) { ?>
        <div class="row">
    <?php } ?>

    <div class="span3">
        <div class="rank">
            <?= $this->element('rank', ['rank' => $rank]) ?>
        </div>
        <div class="photo">
            <?= $this->Html->link(
                $this->Html->image(
                    $coordinate->photo_path,
                    [
                        'class' => 'coordinate_image',
                        'id' => 'photo_' . $rank,
                    ]
                ),
                [
                    'controller' => 'Coordinates',
                    'action' => 'view',
                    $coordinate->id,
                ],
                [
                    'id' => 'link_' . $rank,
                    'escape' => false
                ]
            ) ?>
        </div>
        <div class="information">
            <div class="information_left">
                <div class="point">
                    <span class="point_number" id="point_<?= $rank ?>"><?= $coordinate->n_like * 1000 ?></span> Points
                </div>
                <div class="total_price">
                    ¥<span class="price_number" id="price_<?= $rank ?>"><?= $coordinate->total_price ?></span>
                </div>
            </div>
            <div class="information_right">
                <div class="user">
                    <?php if (isset($coordinate->user->name)) { ?>
                        制作者 :
                        <span class="user_name">
                            <?= $this->Html->link(
                                $coordinate->user->name,
                                [
                                    'controller' => 'Users',
                                    'action' => 'view',
                                    $coordinate->user->id,
                                ],
                                [
                                    'id' => 'user_name_' . $rank
                                ]
                            ) ?>
                        </span>
                    <?php } ?>
                </div>
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

</body>
</html>
