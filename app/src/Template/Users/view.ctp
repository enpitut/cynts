<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('user/base.css') ?>
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
                You have
            <?php else: ?>
                This user has
            <?php endif; ?>
            not yet posted coordinates.
        <?php endif; ?>
    </div>


    <div id = "right_contents">
                <h1>Fovorite Coordinates</h1>
                <?php if (!empty($user->favorites)): ?>
                <table cellpadding="0" cellspacing="0" id="favoriteCordinates">
                 <?php
                $coordinates_table_row = 3;
                for (
                    $i = 0;
                    $i < count($user->favorites);
                    $i += $coordinates_table_row
                ) {
                    $array = [];
                    for ($j = $i; $j < $i + $coordinates_table_row; $j++) {
                        $id = $user->favorites[$j]->coordinate_id;
                        foreach($this->Coordinates as Coordinates->){

                        }


                        array_push(
                            $array,
                            array_key_exists($j, $user->favorites)
                                ? $this->Html->image(
                                $user->favorites[$j]->photo_path,
                                [
                                    'class' => 'favorite_photo',
                                    'url' => [
                                        'controller' => 'Favorite',
                                        'action' => 'view',
                                         $user->favorites[$j]->id,
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
                You have
            <?php else: ?>
                This user has
            <?php endif; ?>
            not yet favorite coordinates.
        <?php endif; ?>
    </div>
</body>
</html>