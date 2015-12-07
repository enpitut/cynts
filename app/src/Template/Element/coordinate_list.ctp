<table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
    <?php
    const TABLE_ROW = 3;
    for ($i = 0; $i < count($coordinates); $i += TABLE_ROW) {
        $row_list = [];
        for ($j = $i; $j < $i + TABLE_ROW; $j++) {
            if (array_key_exists($j, $coordinates)) {
                $row_list[] = $this->Html->image(
                    $coordinates[$j]->photo_path,
                    [
                        'class' => 'list_photo',
                        'url' => [
                            'controller' => 'Coordinates',
                            'action' => 'view',
                            $coordinates[$j]->id,
                        ],
                    ]
                );
            } else {
                $row_list[] = '';
            }
        }
        echo $this->Html->tableCells([$row_list]);
    }
    ?>
</table>
