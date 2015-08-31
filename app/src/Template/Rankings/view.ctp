<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('ranking/base.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".coordinate_image").fadeIn(700);
        });
    </script>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<?php $loop = 0; ?>
<?php foreach ($ranking as $coordinate): ?>
    <?php if ($loop % 3 === 0) { ?>
        <div class="row">
    <?php } ?>

    <div class="span3">
        <div class="rank">
            <?= $this->element('rank', ['rank' => $loop + 1]) ?>
        </div>
        <div class="photo">
            <a href="/coordinates/view/<?= $coordinate->id ?>">
                <?= $this->Html->image(
                    $coordinate->photo_path,
                    [
                        'class' => 'coordinate_image',
                    ]
                );
                ?>
            </a>
        </div>
        <div class="information">
            <div class="information_left">
                <div class="point">
                    <span class="point_number"><?= $coordinate->n_like * 1000 ?></span> Points
                </div>
                <div class="total_price">
                    ¥<span class="price_number"><?= $coordinate->total_price ?></span>
                </div>
            </div>
            <div class="information_right">
                <div class="user">
                    <?php if (isset($coordinate->user->name)) { ?>
                        Posted by
                        <span class="user_name">
                        <a href="/users/view/<?= $coordinate->user->id ?>">
                            <?= $coordinate->user->name ?>
                        </a>
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
