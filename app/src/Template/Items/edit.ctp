<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $item->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Shops'), ['controller' => 'Shops', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Shop'), ['controller' => 'Shops', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="items form large-10 medium-9 columns">
    <?= $this->Form->create($item) ?>
    <fieldset>
        <legend><?= __('Edit Item') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('shop_id', ['options' => $shops, 'empty' => true]);
            echo $this->Form->input('color');
            echo $this->Form->input('sizes');
            echo $this->Form->input('category');
            echo $this->Form->input('price');
            echo $this->Form->input('photos');
            echo $this->Form->input('description');
            echo $this->Form->input('sex');
            echo $this->Form->input('status');
            echo $this->Form->input('purchase_url');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
            echo $this->Form->input('coordinates._ids', ['options' => $coordinates]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
