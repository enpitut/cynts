<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('users/base.css') ?>
    <?= $this->Html->css('users/view.css') ?>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="body">
    <div id="side_contents">
        <div class="side_contents">
            <h3><?= $this->Html->tableCells(
                    [
                        [$user->name]
                    ]
                ); ?>
            </h3>
            <div class="coordinate_level">
                おしゃれレベル : <?= $user->getCoordinateLevel() ?>
            </div>
        </div>
    </div>
    <div id="main_contents">
        <?php if ($mode === 'coordinates'): ?>
            <span class="mode_tab">コーディネート</span>
            <span class="mode_tab clickable">
                <?=
                $this->Html->link(
                    'お気に入り',
                    [
                        'controller' => 'Users',
                        'action' => 'view',
                        $user->id,
                        'favorites'
                    ]
                );
                ?>
            </span>
        <?php elseif ($mode === 'favorites'): ?>
            <span class="mode_tab clickable">
                <?=
                $this->Html->link(
                    'コーディネート',
                    [
                        'controller' => 'Users',
                        'action' => 'view',
                        $user->id,
                        'coordinates'
                    ]
                );
                ?>
            </span>
            <span class="mode_tab">お気に入り</span>
        <?php endif ?>

        <hr>

        <?php if (!empty($coordinates)): ?>
            <?= $this->element('coordinate_list', ['coordinates' => $coordinates]); ?>
        <?php else: ?>
            <?php if ($mode === 'coordinates'): ?>
                <?php if ($is_self_page): ?>
                    <?=
                    $this->Html->link(
                        'Post',
                        [
                            'controller' => 'Coordinates',
                            'action' => 'create',
                        ],
                        ['class' => 'link']
                    );
                    ?> からコーディネートを作ってみてください！
                <?php else: ?>
                    投稿がありません
                <?php endif; ?>
            <?php elseif ($mode === 'favorites'): ?>
                お気に入りコーディネートがありません
            <?php endif ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
