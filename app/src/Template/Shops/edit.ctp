<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shop->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shop->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Shops'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="shops form large-10 medium-9 columns">
    <?= $this->Form->create($shop) ?>
    <fieldset>
        <legend><?= __('Edit Shop') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('url');
            echo $this->Form->input('address');
            echo $this->Form->input('photos');
            echo $this->Form->input('created_at');
            echo $this->Form->input('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
