<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Coordinates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Favorites'), ['controller' => 'Favorites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Favorite'), ['controller' => 'Favorites', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="coordinates form large-10 medium-9 columns">
    <?= $this->Form->create($coordinate) ?>
    <fieldset>
        <legend><?= __('Add Coordinate') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users, 'empty' => true]);
            echo $this->Form->input('photos');
            echo $this->Form->input('n_like');
            echo $this->Form->input('n_unlike');
            echo $this->Form->input('status');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
            echo $this->Form->input('items._ids', ['options' => $items]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
