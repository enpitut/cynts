<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $coordinatesItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $coordinatesItem->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Coordinates Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="coordinatesItems form large-10 medium-9 columns">
    <?= $this->Form->create($coordinatesItem) ?>
    <fieldset>
        <legend><?= __('Edit Coordinates Item') ?></legend>
        <?php
            echo $this->Form->input('coordinate_id', ['options' => $coordinates]);
            echo $this->Form->input('item_id', ['options' => $items]);
            echo $this->Form->input('size');
            echo $this->Form->input('status');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
