<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('ranking/base.css') ?>
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
            <?= $loop + 1 ?>
        </div>
        <div class="photo">
            <a href="/coordinates/view/<?= $coordinate->id ?>">
                <?= $this->Html->image($coordinate->photo_path); ?>
            </a>
        </div>
        <div class="information">
            <span class="point">
                <span class="point_number"><?= $coordinate->n_like * 1000 ?></span> Points
            </span>
            <span class="user">
                <?php if (isset($coordinate->user->name)) { ?>
                    Posted by
                    <span class="user_name">
                    <a href="/users/view/<?= $coordinate->user->id ?>">
                        <?= $coordinate->user->name ?>
                    </a>
                </span>
                <?php } ?>
            </span>
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
