<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Favorite'), ['action' => 'edit', $favorite->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Favorite'), ['action' => 'delete', $favorite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $favorite->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Favorites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Favorite'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Coordinates'), ['controller' => 'Coordinates', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Coordinate'), ['controller' => 'Coordinates', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="favorites view large-10 medium-9 columns">
    <h2><?= h($favorite->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $favorite->has('user') ? $this->Html->link($favorite->user->name, ['controller' => 'Users', 'action' => 'view', $favorite->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Coordinate') ?></h6>
            <p><?= $favorite->has('coordinate') ? $this->Html->link($favorite->coordinate->id, ['controller' => 'Coordinates', 'action' => 'view', $favorite->coordinate->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($favorite->id) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($favorite->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created At') ?></h6>
            <p><?= h($favorite->created_at) ?></p>
            <h6 class="subheader"><?= __('Updated At') ?></h6>
            <p><?= h($favorite->updated_at) ?></p>
        </div>
    </div>
</div>
