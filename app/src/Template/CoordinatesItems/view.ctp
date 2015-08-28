<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Coordinates Item'), ['action' => 'edit', $coordinatesItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Coordinates Item'), ['action' => 'delete', $coordinatesItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coordinatesItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinates Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="coordinatesItems view large-10 medium-9 columns">
    <h2><?= h($coordinatesItem->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Coordinate') ?></h6>
            <p><?= $coordinatesItem->has('coordinate') ? $this->Html->link($coordinatesItem->coordinate->id, ['controller' => 'Coordinates', 'action' => 'view', $coordinatesItem->coordinate->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Item') ?></h6>
            <p><?= $coordinatesItem->has('item') ? $this->Html->link($coordinatesItem->item->name, ['controller' => 'Items', 'action' => 'view', $coordinatesItem->item->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Color') ?></h6>
            <p><?= h($coordinatesItem->color) ?></p>
            <h6 class="subheader"><?= __('Size') ?></h6>
            <p><?= h($coordinatesItem->size) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($coordinatesItem->id) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($coordinatesItem->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($coordinatesItem->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($coordinatesItem->updated_at) ?></p>
        </div>
    </div>
</div>
