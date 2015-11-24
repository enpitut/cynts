<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('users/base.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="body">
    <div id="side_contents">
        <div class="side_contents">
            <h1>Profile</h1>

            <div id="profile">
                <table>
                    <?= $this->Html->tableCells(
                        [
                            [h($user->name)]
                        ]
                    ); ?>
                </table>
            </div>
        </div>
    </div>
    <div id="main_contents">
        <h3>Coordinates</h3>
        <?php if (!empty($user->coordinates)): ?>
            <table cellpadding="0" cellspacing="0" id="related_coordinates">
                <?php
                $coordinates_table_row = 3;
                for (
                    $i = 0;
                    $i < count($user->coordinates);
                    $i += $coordinates_table_row
                ) {
                    $array = [];
                    for ($j = $i; $j < $i + $coordinates_table_row; $j++) {
                        array_push(
                            $array,
                            array_key_exists($j, $user->coordinates)
                                ? $this->Html->image(
                                $user->coordinates[$j]->photo_path,
                                [
                                    'class' => 'list_photo',
                                    'url' => [
                                        'controller' => 'Coordinates',
                                        'action' => 'view',
                                        $user->coordinates[$j]->id,
                                    ],
                                ]
                            ) : ''
                        );
                    }

                    echo $this->Html->tableCells(
                        [
                            $array
                        ]
                    );
                }
                ?>
            </table>
        <?php else: ?>
            <?php if ($is_self_page): ?>
                <?=
                $this->Html->link(
                    'Post',
                    [
                        'controller' => 'Coordinates',
                        'action' => 'create',
                    ],
                    [
                        'class' => 'link',
                    ]
                );
                ?> からコーディネートを作ってみてください！
            <?php else: ?>
                投稿がまだありません
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
