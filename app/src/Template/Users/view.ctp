<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('users/base.css') ?>
</head>
<body>

<?= $this->element('eachpage_header') ?>

<div id="body">
    <div id="left_contents">
        <div class="left_contents">
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
    <div id="center_contents">
        <h1>Posted Coordinates</h1>
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
    <div id = "right_contents">
        <h1>Fovorite Coordinates</h1>
        <?php if (!empty($favorite)): ?>
            <table cellpadding="0" cellspacing="0" id="favoriteCordinates">
                <?php
                $count = 0;
                $all_count = 0;
                $fav_array = [];
                    foreach($favorite as $id => $fav) {
                        array_push(
                        $fav_array,
                        $this->Html->image($fav->coordinate->photo_path,
                        [
                            'class' => 'favoritelist_photo',
                            'url' => [
                                'controller' => 'Coordinates',
                                'action' => 'view',
                                $fav->coordinate_id,
                                ],
                            ]
                        )
                        );
                    $count++;
                    $all_count++;
                    if($count == 3 || $all_count == count($user->favorites)){
                        
                        echo $this->Html->tableCells(
                            [
                                $fav_array
                            ]
                        );
                        $count = 0;
                        $fav_array = [];
                        
                    }
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