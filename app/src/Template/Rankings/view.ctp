<!DOCTYPE html>
<html>
<head>
    <?php const SHOW_NUMBER_UNDER_4 = 5 ?>
    <?= $this->Html->script('rankings/view.js') ?>
    <script type="text/javascript">
        // rankings/view.js で使用する
        var ranking_type = '<?= $type ?>';
    </script>
    <?= $this->Html->script('common.js') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('ranking/base.css') ?>
    <?= $this->Html->css('criteria/table.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript"
            src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".coordinate_image").fadeIn(700);
        });
    </script>
</head>
<body>

<?= $this->element('eachpage_header') ?>
<?= $this->element('criteria_table') ?>

<div id="rankings">
    <?php $loop = (2 - SHOW_NUMBER_UNDER_4); ?>
    <?php foreach ($ranking as $coordinate): ?>
<?php $rank = $loop + (SHOW_NUMBER_UNDER_4 - 1); ?>
<?php if ($loop % SHOW_NUMBER_UNDER_4 === 0 || $loop === (2 - SHOW_NUMBER_UNDER_4)) { ?>
    <div class="row">
        <?php } ?>

        <?php if ($loop > (4 - SHOW_NUMBER_UNDER_4)) { ?>
        <div class="span5">
            <?php } else { ?>
            <div class="span3">
                <?php } ?>
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
                        <span class="point_number" id="point_<?= $rank ?>">
                            <?php
                            if ($type
                                === \App\Controller\RankingsController::RANKING_TYPE_LIKE
                            ) {
                                echo $coordinate->n_like;
                            } else {
                                echo $coordinate->n_unlike;
                            }
                            ?>
                        </span> Points
                        </div>
                        <div class="total_price">
                            ¥<span class="price_number"
                                   id="price_<?= $rank ?>"><?= $coordinate->price ?></span>
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
            <?php if (++$loop % SHOW_NUMBER_UNDER_4 === 0) { ?>
        </div>
        <div class="clear"></div>
    <?php } ?>
        <?php endforeach; ?>
        <?php if ($loop % SHOW_NUMBER_UNDER_4 !== 0) { ?>
    </div>
    <div class="clear"></div>
<?php } ?>

</div>

<?= $this->element('footer') ?>

</body>
</html>
